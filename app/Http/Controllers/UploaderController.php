<?php

namespace App\Http\Controllers;

use App\Helpers\FTP;
use App\Http\Requests\UploaderRequest;
use App\Models\AllowIp;
use App\Models\AttchRoom;
use App\Models\Room;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Lazzard\FtpClient\Config\FtpConfig;
use Lazzard\FtpClient\Connection\FtpConnection;
use Lazzard\FtpClient\FtpClient;

class UploaderController extends Controller
{
    private Room $room;
    private AllowIp $allowIP;
    private AttchRoom $attch;
    private Upload $upload;
    public function __construct()
    {
        $this->room = new Room();
        $this->allowIP = new AllowIp();
        $this->attch = new AttchRoom();
        $this->upload = new Upload();
    }
    public function index(Request $request)
    {
        // get room by ip private
        $ip = $request->getClientIp();
        $allowRoom = $this->allowIP->where('ip', $ip)->with('room')->get();
        // get room global ip
        $rooms = $this->room->doesnthave('allowsIP')->get();
        return Inertia::render('uploader/index', ['allows' => $allowRoom, 'globals' => $rooms]);
    }
    public function show_uploader($room)
    {
        $room = $this->room->where('name', $room)->where('status', 1)->with('attchs')->with('uploads')->first();
        return Inertia::render('uploader/show', ['room' => $room]);
    }

    public function upload(UploaderRequest $request, $room)
    {
        $format1 = "KELAS_MAKUL_NIM_TYPE";
        $format2 = "KELAS_MAKUL_NIM";
        $room = $this->room->where("name", $room)->first();
        if ($room->uploads()->where('ip', $request->getClientIp())->first() != null) {
            return redirect()->back()->withErrors(['ip' => 'IP ' . $request->getClientIp() . ' Sudah pernah Upload']);
        }
        $nama_file_format_1 = strtoupper(str_replace(["KELAS", "MAKUL", "NIM", "TYPE"], [$room->kelas, str_replace(" ", "_", $room->mata_kuliah), $request->nim, $request->type], $format1));
        $nama_file_format_2 = strtoupper(str_replace(["KELAS", "MAKUL", "NIM"], [$room->kelas, str_replace(" ", "_", $room->mata_kuliah), $request->nim], $format2));
        if (count($request->file('files')) > 1) {
            if ($room->type_field) {
                $convert_zip =  $nama_file_format_1 . ".zip";
            } else {
                $convert_zip =  $nama_file_format_2 . ".zip";
            }
            $data = [
                'name' => $request->name,
                'nim' => $request->nim,
                'ip' => $request->getClientIp(),
                'file' => $convert_zip,
            ];
            if ($room->type_field) {
                $data = [...$data, "type" => $request->type];
            }
            $getSize = 0;
            foreach ($request->file('files') as $file) {
                $getSize += $file->getSize();
            }
            if (round($getSize / 1024) >= $room->max_size) {
                return redirect()->back()->withErrors(['files' => 'Batas upload hanya  ' . $room->max_size . 'kb']);
            }
            $insertUpload = $room->uploads()->create($data);
            if ($insertUpload) {
                $zip = new \ZipArchive();
                foreach ($request->file('files') as $file) {
                    if ($zip->open(storage_path("app/" . $room->folder . "/" . $convert_zip), \ZipArchive::CREATE)) {
                        $zip->addFile($file->getRealPath(), $file->getClientOriginalName());
                        $zip->close();
                    }
                }
                if ($room->ftp) {
                    try {
                        if (preg_match("/ftp:\/\/(.*?):(.*?)@(.*?)(\/.*)/i", $room->ftp, $match)) {
                            if (!extension_loaded('ftp')) {
                                throw new \RuntimeException("FTP extension not loaded.");
                            }

                            $connection = new FtpConnection($match[3], $match[1], $match[2]);
                            $connection->open();

                            $config = new FtpConfig($connection);
                            $config->setPassive(true);

                            $client = new FtpClient($connection);
                            if ($zip->open(storage_path("app/" . $room->folder . "/" . $convert_zip), \ZipArchive::CREATE)) {
                                $zip->addFile($file->getRealPath(), $file->getClientOriginalName());
                                $zip->close();
                            }
                            $copy = $client->copyFromLocal(storage_path("app/" . $room->folder . "/" . $insertUpload->file),   $room->folder);
                            if ($copy) {
                                Storage::delete($room->folder . "/" . $insertUpload->file);
                            }
                            $connection->close();
                        }
                    } catch (\Throwable $ex) {
                        return redirect()->back()->withErrors(['ftp' => 'Error : ' . $ex->getMessage()]);
                    }
                }
            }
        } else {
            $extension = $request->file('files')[0]->extension();
            if ($room->type_field) {
                $single_file =  $nama_file_format_1 . "." . $extension;
            } else {
                $single_file =   $nama_file_format_2 . "." . $extension;
            }
            $getSize = $request->file('files')[0]->getSize();
            if (round($getSize / 1024) >= $room->max_size) {
                return redirect()->back()->withErrors(['files' => 'Batas upload hanya  ' . $room->max_size . 'kb']);
            }

            $data = [
                'name' => $request->name,
                'nim' => $request->nim,
                'ip' => $request->getClientIp(),
                'file' => $single_file,
            ];
            if ($room->type_field) {
                $data = [...$data, "type" => $request->type];
            }

            if ($room->ftp) {
                try {
                    if (preg_match("/ftp:\/\/(.*?):(.*?)@(.*?)(\/.*)/i", $room->ftp, $match)) {
                        if (!extension_loaded('ftp')) {
                            throw new \RuntimeException("FTP extension not loaded.");
                        }

                        $connection = new FtpConnection($match[3], $match[1], $match[2]);
                        $connection->open();

                        $config = new FtpConfig($connection);
                        $config->setPassive(true);

                        $client = new FtpClient($connection);
                        $client_upload = $client->upload($request->file('files')[0], $room->folder . "/" . $single_file);
                        if ($client_upload) {
                            $room->uploads()->create($data);
                        }
                        $connection->close();
                    }
                } catch (\Throwable $ex) {
                    return redirect()->back()->withErrors(['ftp' => 'Error : ' . $ex->getMessage()]);
                }
            } else {
                if ($room->uploads()->create($data)) {
                    Storage::putFileAs($room->folder, $request->file('files')[0], $single_file);
                }
            }
        }
    }
    public function downloadAttch($attch)
    {
        $find = $this->attch->with('room')->find($attch);
        return response()->download(storage_path("app/attch/" . $find->room->name . "/" . $find->file));
    }
}
