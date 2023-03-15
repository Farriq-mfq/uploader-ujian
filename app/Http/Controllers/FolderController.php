<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Lazzard\FtpClient\Config\FtpConfig;
use Lazzard\FtpClient\Connection\FtpConnection;
use Lazzard\FtpClient\FtpClient;

class FolderController extends Controller
{
    private Room $room;
    private Upload $upload;
    public function __construct()
    {
        $this->room = new Room();
        $this->upload = new Upload();
    }
    public function index()
    {
        if (Auth::user()->role === "operator") {
            $rooms = $this->room->where('operator_id', Auth::user()->id)->get();
        } else if (Auth::user()->role === "master") {
            $rooms = $this->room->get();
        }
        return Inertia::render('folder/index', ['rooms' => $rooms]);
    }
    public function download_file($id)
    {
        $room = $this->room->find($id);
        if ($room) {
            if (!$room->ftp) {
                $all_files =  Storage::allFiles($room->folder);
                $folder_name = strtoupper(str_replace("", "_", $room->folder)) . ".zip";
                if (count($all_files)) {
                    foreach ($all_files as $file) {
                        $zip = new \ZipArchive();
                        if ($zip->open(storage_path('app/' . $folder_name), \ZipArchive::CREATE)) {
                            $zip->addFile(storage_path('app/' . $file), $file);
                            $zip->close();
                        }
                    }
                    return Response::download(storage_path('app/' . $folder_name), $folder_name, ['Content-Type: application/zip']);
                } else {
                    return redirect()->back();
                }
            } else {
                return redirect()->back()->withErrors(['ftp' => "file sudah tersedia di local"]);
            }
        }
    }
    public function detail(Request $request, $room)
    {
        $keyword = $request->keyword;
        if ($keyword != null) {
            $uploads = $this->upload->where('room_id', $room)->where('name', "LIKE", "%" . $keyword . "%")->orWhere('nim', "LIKE", "%" . $keyword . "%")->paginate(5);
        } else {
            $uploads = $this->upload->where('room_id', $room)->with('room')->paginate(5);
        }
        if (Auth::user()->role === "operator") {
            $roomName = $this->room->select('name', 'id')->where('operator_id', Auth::user()->id)->find($room);
            if ($roomName === null) {
                return redirect(route('folder.index'));
            }
        } else if (Auth::user()->role === "master") {
            $roomName = $this->room->select('name', 'id')->find($room);
        }


        if ($room) {
            return Inertia::render('folder/detail', ['uploads' => $uploads, 'roomName' => $roomName]);
        }
    }
    public function remove_upload($uploader)
    {
        $upload = $this->upload->with("room")->find($uploader);

        $deleteUpload = $this->upload->where('id', $uploader)->delete();
        if ($deleteUpload) {
            if ($upload->room->ftp) {
                try {
                    if (preg_match("/ftp:\/\/(.*?):(.*?)@(.*?)(\/.*)/i", $upload->room->ftp, $match)) {
                        if (!extension_loaded('ftp')) {
                            throw new \RuntimeException("FTP extension not loaded.");
                        }

                        $connection = new FtpConnection($match[3], $match[1], $match[2]);
                        $connection->open();

                        $config = new FtpConfig($connection);
                        $config->setPassive(true);

                        $client = new FtpClient($connection);
                        if ($client->isExists($upload->room->folder . "/" . $upload->file)) {
                            $client->removeFile($upload->room->folder . "/" . $upload->file);
                        }
                        $connection->close();
                    }
                } catch (\Throwable $th) {
                    return redirect()->back()->withErrors(['ftp' => $th->getMessage()]);
                }
            } else {
                if (Storage::exists($upload->room->folder . "/" . $upload->file)) {
                    Storage::delete($upload->room->folder . "/" . $upload->file);
                }
            }
        }
    }
    public function remove_all($room)
    {
        $room = $this->room->find($room);
        $deleteAll = $room->uploads()->delete();
        if ($deleteAll) {
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
                        $all_files = $client->listDir($room->folder);
                        foreach ($all_files as $file) {
                            if ($client->isExists($room->folder . "/" . $file)) {
                                $client->removeFile($room->folder . "/" . $file);
                            }
                        }
                        $connection->close();
                    }
                } catch (\Throwable $th) {
                    return redirect()->back()->withErrors(['ftp' => $th->getMessage()]);
                }
            } else {
                $files =  Storage::allFiles($room->folder);
                Storage::delete($files);
            }
        }
    }
}
