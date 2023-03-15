<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomsRequest;
use App\Models\AllowIp;
use App\Models\AttchRoom;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Lazzard\FtpClient\Config\FtpConfig;
use Lazzard\FtpClient\Connection\FtpConnection;
use Lazzard\FtpClient\Connection\FtpSSLConnection;
use Lazzard\FtpClient\FtpClient;

class RoomsController extends Controller
{

    private Room $room;
    private AllowIp $ips;
    private User $user;
    public function __construct()
    {
        $this->room = new Room();
        $this->ips = new AllowIp();
        $this->user = new User();

        $this->middleware('role_login:auth,master', ['only' => ['create', 'store', 'destroy', 'batch_remove']]);
    }

    /**
     * Display a listing of the resource.
     * @param Illuminate\Http\Request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {

        if (Auth::user()->role === "operator") {
            if ($request->keyword) {
                $rooms = $this->room->with(['attchs', 'allowsIP'])->where('operator_id', Auth::user()->id)->where("name", "LIKE", "%" . $request->keyword . "%")->latest()->paginate(5);
            } else {
                $rooms = $this->room->with(['attchs', 'allowsIP'])->where('operator_id', Auth::user()->id)->latest()->paginate(5);
            }
        } else if (Auth::user()->role === "master") {
            if ($request->keyword) {
                $rooms = $this->room->with(['attchs', 'allowsIP'])->where("name", "LIKE", "%" . $request->keyword . "%")->latest()->paginate(5);
            } else {
                $rooms = $this->room->with(['attchs', 'allowsIP'])->latest()->paginate(5);
            }
        }
        return Inertia::render('rooms/index', ['rooms' => $rooms]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $operators = $this->user->where('role', 'operator')->select('id', 'name')->get();
        return Inertia::render('rooms/create', ['operators' => $operators]);
    }

    /**
     * Store a newly created resource in storage.
     * @param App\Http\Requests\RoomsRequest
     */
    public function store(RoomsRequest $request)
    {
        $times = $request->TimeRanges;
        $data = [
            "name" => $request->name,
            "time_start" => $times[0],
            "time_end" => $times[1],
            "folder" => $request->folder,
            'kelas' => $request->kelas,
            'mata_kuliah' => $request->mata_kuliah,
            "status" => $request->status,
            "extensions" => $request->extensions,
            "type_field" => $request->type_field,
            'ftp' => $request->ftp,
            'operator_id' => $request->operator
        ];


        $create = $this->room->create($data);
        if ($request->ftp) {
            try {
                if (preg_match("/ftp:\/\/(.*?):(.*?)@(.*?)(\/.*)/i", $request->ftp, $match)) {
                    if (!extension_loaded('ftp')) {
                        throw new \RuntimeException("FTP extension not loaded.");
                    }

                    $connection = new FtpConnection($match[3], $match[1], $match[2]);
                    $connection->open();

                    $config = new FtpConfig($connection);
                    $config->setPassive(true);

                    $client = new FtpClient($connection);
                    if ($create) {
                        $client->createDir($request->folder);
                        $connection->close();
                    }
                }
            } catch (\Throwable $ex) {
                return redirect()->back()->withErrors(['ftp' => 'Error : ' . $ex->getMessage()]);
            }
        }
        if ($create) {
            Storage::createDirectory($request->folder);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = $this->room->find($id);
        $operators = $this->user->where('role', 'operator')->select('id', 'name')->get();
        return Inertia::render('rooms/edit', ['room' => $room, 'operators' => $operators]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomsRequest $request, string $id)
    {
        $room = $this->room->find($id);
        $times = $request->TimeRanges;
        $data = [
            "name" => $request->name,
            "time_start" => $times[0],
            "time_end" => $times[1],
            'folder' => $request->folder,
            'kelas' => $request->kelas,
            'mata_kuliah' => $request->mata_kuliah,
            "status" => $request->status,
            "extensions" => $request->extensions,
            "type_field" => $request->type_field,
            'ftp' => $request->ftp,
            'operator_id' => $request->operator
        ];
        $update = $this->room->where('id', $id)->update($data);
        if ($request->ftp) {
            try {
                if (preg_match("/ftp:\/\/(.*?):(.*?)@(.*?)(\/.*)/i", $request->ftp, $match)) {
                    if (!extension_loaded('ftp')) {
                        throw new \RuntimeException("FTP extension not loaded.");
                    }

                    $connection = new FtpConnection($match[3], $match[1], $match[2]);
                    $connection->open();

                    $config = new FtpConfig($connection);
                    $config->setPassive(true);

                    $client = new FtpClient($connection);
                    if ($update) {
                        if (!$client->isDir($room->folder)) {
                            $client->createDir($room->folder);
                        } else {
                            if ($room->folder != $request->folder) {
                                $createDir = $client->createDir($request->folder);
                                if ($createDir) {
                                    foreach ($client->listDir($room->folder) as $file) {
                                        $client->move($room->folder . "/" . $file, $request->folder);
                                    }
                                    $client->removeDir($room->folder);
                                }
                            }
                        }
                        Storage::move("attch/" . $room->name . '/', "attch/" . $request->name);
                        $connection->close();
                    }
                }
            } catch (\Throwable $ex) {
                return redirect()->back()->withErrors(['ftp' => 'Error : ' . $ex->getMessage()]);
            }
        }
        if ($update) {
            if ($room) {
                Storage::move($room->folder . '/', $request->folder);
                Storage::move("attch/" . $room->name . '/', "attch/" . $request->name);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::user()->role === 'master') {
            $find = $this->room->with('attchs')->find($id);
            $this->room->where('id', $id)->delete();
            if ($find->ftp) {
                try {
                    if (preg_match("/ftp:\/\/(.*?):(.*?)@(.*?)(\/.*)/i", $find->ftp, $match)) {
                        if (!extension_loaded('ftp')) {
                            throw new \RuntimeException("FTP extension not loaded.");
                        }

                        $connection = new FtpConnection($match[3], $match[1], $match[2]);
                        $connection->open();

                        $config = new FtpConfig($connection);
                        $config->setPassive(true);

                        $client = new FtpClient($connection);
                        $client->removeDir($find->folder);
                        $connection->close();
                    }
                } catch (\Throwable $ex) {
                    return redirect()->back()->withErrors(['ftp' => 'Error : ' . $ex->getMessage()]);
                }
            }
            foreach ($find->attchs as $file) {
                Storage::delete("attch/" . $find->name . "/" . $file->file);
            }
            Storage::deleteDirectory($find->folder);
            Storage::deleteDirectory('attch/' . $find->name);
        } else {
            return redirect(route('rooms.index'));
        }
    }


    /**
     * remove all rooms
     */
    public function batch_remove()
    {
        if (Auth::user()->role === 'master') {
            $rooms = $this->room->where('id', ">", 0)->get();
            foreach ($rooms as $room) {
                Storage::deleteDirectory($room->folder);
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
                            $client->removeDir($room->folder);
                            $connection->close();
                        }
                    } catch (\Throwable $ex) {
                        return redirect()->back()->withErrors(['ftp' => 'Error : ' . $ex->getMessage()]);
                    }
                }
            }
            $delete = $this->room->where('id', ">", 0)->delete();
            if ($delete) {
                $files =  Storage::allFiles('attch');
                Storage::delete($files); // delete attch
            }
        } else {
            return redirect(route('rooms.index'));
        }
    }

    /**
     * update active record
     */

    public function batch_active()
    {
        if (Auth::user()->role === 'operator') {
            $this->room->where('id', ">", 0)->where('operator_id', Auth::user()->id)->update(['status' => true]);
        } elseif (Auth::user()->role === 'master') {
            $this->room->where('id', ">", 0)->update(['status' => true]);
        }
    }
    /**
     * update inactive record
     */

    public function batch_inactive()
    {
        if (Auth::user()->role === 'operator') {
            $this->room->where('id', ">", 0)->where('operator_id', Auth::user()->id)->update(['status' => false]);
        } elseif (Auth::user()->role === 'master') {
            $this->room->where('id', ">", 0)->update(['status' => false]);
        }
    }

    /**
     * @param string $id
     */
    public function active($id)
    {
        $room = $this->room->select('status')->find($id);
        if ($room != null) {
            $this->room->active($room->status, $id);
        }
    }
    public function attch(Request $request, $room)
    {
        $get_room = $this->room->find($room);
        foreach ($request->files as $files) {
            foreach ($files as $attch) {
                $name = $attch->getClientOriginalName();
                $size = $attch->getSize();
                $data = [
                    'file' => $name,
                    'size' => $size,
                    'room_id' => $room
                ];
                $created = AttchRoom::create($data);
                if ($created) {
                    Storage::putFileAs("attch/" . $get_room->name . "/", $attch, $name);
                }
            }
        }
    }
    public function show_ip($room)
    {
        $check = $this->room->find($room);
        if ($check != null) {
            $allows = $this->ips->whereHas('room', function ($q) use ($room) {
                return $q->where("id", $room);
            })->orderBy('ip', "ASC")->get();
            return Inertia::render('rooms/ip', ['allows' => $allows, 'room' => $room]);
        } else {
            return redirect(route('rooms.index'));
        }
    }
    public function add_ip(Request $request, $room)
    {
        $validate = Validator::make($request->all(), ['ip' => ['required', 'ip']], ['ip.required' => "ip harus di isi", 'ip.ip' => 'ip tidak valid']);

        if ($validate->validated()) {
            $data = [
                'ip' => $request->ip,
            ];
            $room = $this->room->find($room);
            $room->allowsIP()->create($data);
        }
    }
    public function delete_ip($room, $ip)
    {
        $this->ips->where('id', $ip)->delete();
    }
}
