<?php

namespace App\Http\Controllers;

use App\Helpers\SendNotification;
use App\Models\Khotbah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KhotbahController extends Controller
{

    private $notificationHelpers;

    function __construct()
    {
        $this->notificationHelpers = new SendNotification();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = userInfo();
        $khotbah = Khotbah::where("cabang_id", $user['cabang_id'])->with('region')->get()->toArray();

        return view('khotbah.index', ['khotbahs' => $khotbah, 'title' => 'Khotbah']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("khotbah.create", ['title' => 'Khotbah Create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'pembawa' => 'required',
            'khotbah' => 'required',
            'date' => 'required|date',
            'bahan' => 'required',
            'banner' => 'required|image',
        ]);

        $user = userInfo();

        $fileName = $request->file('banner')->store('khotbah');

        $this->notificationHelpers->broadcastLocal($request->title, "Ringkasan Khotbah baru buat kamu - " . $request->bahan);

        Khotbah::create([
            'title' => $request->title,
            'image_path' => $fileName,
            'pembawa' => $request->pembawa,
            'khotbah' => $request->khotbah,
            'khotbah_date' => $request->date,
            'cabang_id' => $user['cabang_id'],
            'bahan' => $request->bahan,
        ]);

        return redirect('/khotbah')->with('success_form', 'Success Add Data!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $khotbah = Khotbah::find($id)->toArray();

        return view("khotbah.edit", ['khotbah' => $khotbah, 'title' => 'Khotbah Edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'pembawa' => 'required',
            'khotbah' => 'required',
            'date' => 'required|date',
            'bahan' => "required",
        ]);



        $khotbah = Khotbah::find($id);
        if ($request->file('banner')) {
            $tempFilePath = explode(env("APP_URL") . "/" . "storage/", $khotbah['image_path']);
            $tempFilePath = end($tempFilePath);


            if ($khotbah['image_path'] && Storage::exists($tempFilePath)) {
                Storage::delete($tempFilePath);
            }

            $fileName = $request->file('banner')->store('khotbah');
            $khotbah->image_path = $fileName;
        }
        $khotbah->title = $request->title;
        $khotbah->pembawa = $request->pembawa;
        $khotbah->khotbah = $request->khotbah;
        $khotbah->khotbah_date = $request->date;
        $khotbah->bahan = $request->bahan;
        $khotbah->save();

        return redirect('/khotbah')->with('success_form', 'Success Updates Data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $khotbah = Khotbah::find($id);
        if (Storage::exists($khotbah['image_path'])) {
            Storage::delete($khotbah['image_path']);
        }
        $khotbah->delete();
        return redirect('/khotbah')->with('warning_form', 'Success Delete Data!');
    }
}
