<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class VideoController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('video_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videos = Video::all();

        return view('videos.index', compact('videos'));
    }

    public function create()
    {
        abort_if(Gate::denies('video_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('videos.create');
    }

    public function store(StoreVideoRequest $request)
    {
        $request->validate([
            'file' => 'bail|required|file|mimes:mp4,oog,webm',
        ]);

        $fileName = time().'.'.$request->file('file')->extension();

        $request->file('file')->store('public/files');

        Video::create([
           'title' => $request->title,
           'description' => $request->description,
           'name' => $fileName,
        ]);

        return redirect()->route('videos.index');
    }

    public function show(Video $video)
    {
        abort_if(Gate::denies('video_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
