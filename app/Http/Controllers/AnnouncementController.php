<?php

namespace App\Http\Controllers;

use App\Helpers\SendNotification;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    private $notificationHelpers;


    public function __construct()
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
        $announcement = Announcement::where('cabang_id', $user['cabang_id'])->latest()->with('region')->get()->toArray();

        return view('announcement.index', ['announcements' => $announcement, 'title' => "Announcement"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('announcement.create', ['title' => "Create Announcement"]);
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
            'title' => "required",
            'description' => "required",
            'banner' => 'required|image',
            'announcement' => "required",
        ]);

        $user = userInfo();

        $fileName = $request->file('banner')->store('announcement');

        $this->notificationHelpers->broadcastLocal($request->title, $request->description);

        Announcement::create([
            'cabang_id' => $user['cabang_id'],
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $fileName,
            'body' => $request->announcement,
        ]);

        return redirect('/announcement')->with("success_form", 'Success Add Data!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $announcement =  Announcement::find($id)->toArray();

        return view('announcement.edit', ['announcement' => $announcement, 'title' => "Announcement Edit"]);
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
        $announcement = Announcement::find($id);

        if ($request->file('banner')) {

            $tempFilePath = explode(env("APP_URL") . "/" . "storage/", $announcement['image_path']);
            $tempFilePath = end($tempFilePath);

            if ($announcement['image_path'] && Storage::exists($tempFilePath)) {
                Storage::delete($tempFilePath);
            }

            $fileName = $request->file('banner')->store('announcement');
            $announcement->image_path = $fileName;
        }

        $announcement->title = $request->title;
        $announcement->description = $request->description;
        $announcement->body = $request->announcement;
        $announcement->save();

        return redirect('/announcement')->with("success_form", 'Success Update Data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $announcement = Announcement::find($id);

        $tempFilePath = explode(env("APP_URL") . "/" . "storage/", $announcement['image_path']);
        $tempFilePath = end($tempFilePath);

        if (Storage::exists($tempFilePath)) {
            Storage::delete($tempFilePath);
        }
        $announcement->delete();

        return redirect('/announcement')->with('warning_form', 'Success Delete Data!');
    }
}
