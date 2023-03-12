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
    public function index()
    {
        // get room by ip private
        $ip = gethostbyname(gethostname());
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
                'file' => $convert_zip,
            ];
            if ($room->type_field) {
                $data = [...$data, "type" => $request->type];
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
            }
        } else {
            $extension = $request->file('files')[0]->extension();
            if ($room->type_field) {
                $single_file =  $nama_file_format_1 . "." . $extension;
            } else {
                $single_file =   $nama_file_format_2 . "." . $extension;
            }
            $data = [
                'name' => $request->name,
                'nim' => $request->nim,
                'file' => $single_file,
            ];
            if ($room->type_field) {
                $data = [...$data, "type" => $request->type];
            }
            $insertUpload = $room->uploads()->create($data);
            if ($insertUpload) {
                Storage::putFileAs($room->folder, $request->file('files')[0], $single_file);
            }
        }
    }
    public function downloadAttch($attch)
    {
        $find = $this->attch->with('room')->find($attch);
        return response()->download(storage_path("app/attch/" . $find->room->name . "/" . $find->file));
        // dd(Storage::download("attch/" . $find->room->name . "/" . $find->file));
    }
}
