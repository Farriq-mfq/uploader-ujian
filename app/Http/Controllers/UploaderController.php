<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploaderRequest;
use App\Models\AllowIp;
use App\Models\AttchRoom;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UploaderController extends Controller
{
    private Room $room;
    private AllowIp $allowIP;
    private AttchRoom $attch;
    public function __construct()
    {
        $this->room = new Room();
        $this->allowIP = new AllowIp();
        $this->attch = new AttchRoom();
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
        $room = $this->room->where('name', $room)->where('status', 1)->with('attchs')->first();
        return Inertia::render('uploader/show', ['room' => $room]);
    }

    public function upload(UploaderRequest $request, $room)
    {
        $format1 = "NAMA_MAKUL_NIM_SOAL";
        $format2 = "NAMA_MAKUL_NIM";
        str_replace(["NAMA", "MAKUL", "NIM", "SOAL"], ["FARRIQ", "KELAS", "NOMER", "ANBSE"], $format1);
        $room = $this->room->where("name", $room)->first();
        if (count($request->file('files')) > 1) {
            $zip = new \ZipArchive();
            foreach ($request->file('files') as $file) {
                if ($zip->open(storage_path("app/" . $room->folder . "/coba.zip"), \ZipArchive::CREATE)) {
                    $zip->addFile($file->getRealPath(), $file->getClientOriginalName());
                    $zip->close();
                }
            }
        } else {
            Storage::putFileAs($room->folder, $request->file('files')[0], $request->file('files')[0]->getClientOriginalName());
        }
    }
    public function downloadAttch($attch)
    {
        $find = $this->attch->with('room')->find($attch);
        return response()->download(storage_path("app/attch/" . $find->room->name . "/" . $find->file));
        // dd(Storage::download("attch/" . $find->room->name . "/" . $find->file));
    }
}
