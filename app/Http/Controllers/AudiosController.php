<?php

namespace App\Http\Controllers;

use App\Listening\Audio;
use App\Listening\AudioType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AudiosController extends Controller
{
    //TODO:: Add AudioQuestion views
    //TODO:: Add Routes
    //TODO:: Modify links in audio show


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $audios = Audio::paginate(15);
        return view('listening.audio.index',compact('audios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $types= AudioType::all();
       return view('listening.audio.create',compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        Audio::create([
            'title'=>$request['title'],
            'source'=>$request['source']->store('audio','public'),
            'audio_type_id'=>$request['type'],
        ]);
        return Redirect::action('AudiosController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Audio  $audio
     * @return \Illuminate\Http\Response
     */
    public function show(Audio $audio)
    {
        $questions=$audio->questions()->paginate(15);
        return view('listening.audio.show',compact('audio','questions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Audio  $audio
     * @return \Illuminate\Http\Response
     */
    public function edit(Audio $audio)
    {
        $types= AudioType::all();
        return view('listening.audio.update',compact('audio','types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Audio  $audio
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Audio $audio)
    {
        $this->updateValidator($request->all())->validate();
            if($request->has('source'))
            {
                File::delete('storage/'.$audio->source);
            $audio->update([
                'source'=>$request['source']->store('audio','public'),
            ]);
            }
//        dd(File::get('storage/'.$audio->source));
      $audio->update([
            'title'=>$request['title'],
            'audio_type_id'=>$request['type'],
        ]);
        return Redirect::action('AudiosController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Audio  $audio
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Audio $audio)
    {
        $audio->questions()->delete();
        $audio->delete();
        return Redirect::action('AudiosController@index');
    }
    public function validator( $data)
    {
        $message=[

            'source.required'=>'Audio File field is required.',

        ];
        $roles =[
            'title' => 'required|string|min:8',
            'source' => 'required|file|mimetypes:audio/x-wav',

        ];
        return Validator::make($data,$roles,$message);

    }
    public function updateValidator( $data)
    {

        $roles =[
            'title' => 'required|string|min:8',
            'source' => 'sometimes|file|mimetypes:audio/x-wav',

        ];
        return Validator::make($data,$roles,$message);

    }
}
