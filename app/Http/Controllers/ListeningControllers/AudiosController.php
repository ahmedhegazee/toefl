<?php

namespace App\Http\Controllers\ListeningControllers;

use App\Http\Controllers\Controller;
use App\Listening\Audio;
use App\Listening\AudioType;
use App\Logging;
use App\Question;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AudiosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $audios = Audio::getAudios(Audio::paginate(50));
        $count = Audio::all()->count();
        return response()->json(['questions' => $audios, 'count' => $count]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $types = AudioType::all();
        return view('listening.audio.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $audio = Audio::create([
            'title' => $request['title'],
            'source' => $request['source']->store('audio', 'public'),
            'audio_type_id' => $request['type'],
        ]);
        $message = " make new audio {" . $audio->id . "} ";
        Logging::logProfessor(auth()->user(), $message);
        return Redirect::route('audio.show', compact('audio'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Audio $audio
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Audio $audio)
    {
        return view('listening.audio.show', compact('audio'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Audio $audio
     * @return Response
     */
    public function edit(Audio $audio)
    {
        $previous = url()->previous();
        session([
            'previous' => $previous,
        ]);
        $types = AudioType::all();
        return view('listening.audio.update', compact('audio', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Audio $audio
     * @return RedirectResponse
     */
    public function update(Request $request, Audio $audio)
    {
        $this->updateValidator($request->all())->validate();
        if ($request->has('source')) {
            File::delete('storage/' . $audio->source);
            $audio->update([
                'source' => $request['source']->store('audio', 'public'),
            ]);
        }
//        dd(File::get('storage/'.$audio->source));
        $audio->update([
            'title' => $request['title'],
            'audio_type_id' => $request['type'],
        ]);
        $message = " update audio {" . $audio->id . "} ";
        Logging::logProfessor(auth()->user(), $message);
        if (session()->has('previous'))
            return \redirect()->to(session()->get('previous'));
        else
            return Redirect::route('audio-panel');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Audio $audio
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Audio $audio)
    {
        $message = " delete audio {" . $audio->id . "} ";
        Logging::logProfessor(auth()->user(), $message);
        $audio->questions()->delete();
        $audio->delete();
//        return Redirect::route('audio.index');
    }

    public function validator($data)
    {
        $message = [

            'source.required' => 'Audio File field is required.',

        ];
        $roles = [
            'title' => 'required|string|min:8',
            'source' => 'required|file|mimetypes:audio/x-wav|max:8000',

        ];
        return Validator::make($data, $roles, $message);

    }

    public function updateValidator($data)
    {

        $roles = [
            'title' => 'required|string|min:8',
            'source' => 'sometimes|file|mimetypes:audio/x-wav|max:8000',

        ];
        return Validator::make($data, $roles);

    }
}
