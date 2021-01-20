<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class VideoController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('video_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        if (Gate::allows('user_access')) {
            $videos = Video::all();
        }

        elseif (Gate::allows('reporter_access')) {
            $videos = Video::where('user_id',$user->id)->get();
        }

        return view('videos.index', compact('videos'));
    }

    public function create()
    {
        abort_if(Gate::denies('video_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('videos.create');
    }

    public function store(StoreVideoRequest $request)
    {
        $user = Auth::user();

        $request->validate([
        'file'      => 'bail|required|file|mimes:mp4,oog,webm|max:5242880',
        'thumbnail' => 'bail|required|file|mimes:jpeg,jpg,png|max:10000',
    ]);

        $fileModel = new Video;

        if($request->file('file')) {
            $fileName = md5(uniqid(mt_rand(), true)) . '-' . time() . '.' . $request->file('file')->extension();
            $filePath = $request->file('file')->storeAs('videos', $fileName, 'public');
            $thumbName = md5(uniqid(mt_rand(), true)) . '-' . time() . '.' . $request->file('thumbnail')->extension();
            $thumbPath = $request->file('thumbnail')->storeAs('thumbnails', $thumbName, 'public');
            $fileModel->title = $request->title;
            $fileModel->subject = $request->subject;
            $fileModel->name = $fileName;
            $fileModel->thumb_name = $thumbName;
            $fileModel->location = '/storage/' . $filePath;
            $fileModel->thumb_location = '/storage/' . $thumbPath;
            $fileModel->description = $request->description;
            $fileModel->user()->associate($user);
            $fileModel->save();
        }

        return redirect()->route('videos.index');
    }

    public function show(Video $video)
    {
        abort_if(Gate::denies('video_show_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Video::where('id', $video->id)->increment('view_count', 1);

        return view('videos.show', compact('video'));
    }

    public function edit(Video $video)
    {
        abort_if(Gate::denies('video_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('videos.edit', compact('video'));
    }

    public function update(UpdateVideoRequest $request, Video $video)
    {
        $video->update($request->validated());

        return redirect()->route('videos.index');
    }

    public function destroy(Video $video)
    {
        abort_if(Gate::denies('video_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $video->delete();

        return redirect()->route('videos.index');
    }
}
