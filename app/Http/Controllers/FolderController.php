<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class FolderController extends Controller
{
    private Room $room;
    public function __construct()
    {
        $this->room = new Room();
    }
    public function index()
    {
        $rooms = $this->room->with('uploads')->get();
        return Inertia::render('folder/index', ['rooms' => $rooms]);
    }
    public function download_file($id)
    {
        $room = $this->room->find($id);
        if ($room) {
            $all_files = Storage::allFiles($room->folder);
            $folder_name = strtoupper(str_replace("", "_", $room->folder)) . ".zip";
            foreach ($all_files as $file) {
                $zip = new \ZipArchive();
                if ($zip->open(storage_path('app/' . $folder_name), \ZipArchive::CREATE)) {
                    $zip->addFile(storage_path('app/' . $file), $file);
                    $zip->close();
                }
            }
        }
        return Response::download(storage_path('app/' . $folder_name),$folder_name,['Content-Type: application/zip']);
    }
    public function detail()
    {
        return Inertia::render('folder/detail');
    }
}
