<?php

namespace App\Http\Controllers\ReadingControllers;

use App\Http\Controllers\Controller;
use App\Logging;
use App\Question;
use App\Reading\Paragraph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ParagraphsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
//        $paragraphs=Paragraph::paginate(15);
        $paragraphs = Paragraph::getParagraphs(Paragraph::paginate(50));
        $count=Paragraph::all()->count();
        return response()->json(['questions'=>$paragraphs,'count'=>$count]);
//        $paragraphs = json_encode($paragraphs);

//        return view('reading.paragraph.index',compact('paragraphs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reading.paragraph.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $paragraph=Paragraph::create($this->validateData());
        $message=" make new paragraph {".$paragraph->id."} ";
        Logging::logProfessor(auth()->user(),$message);
        return Redirect::route('paragraph.show',['paragraph'=>$paragraph]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Paragraph  $paragraph
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Paragraph $paragraph)
    {
        return view ('reading.paragraph.show',compact('paragraph'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paragraph  $paragraph
     * @return \Illuminate\Http\Response
     */
    public function edit(Paragraph $paragraph)
    {
        $previous=url()->previous();
        session([
            'previous'=>$previous,
        ]);
        return view ('reading.paragraph.update',compact('paragraph'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paragraph  $paragraph
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Paragraph $paragraph)
    {
        $paragraph->update($this->validateData());
        $message=" update paragraph {".$paragraph->id."} ";
        Logging::logProfessor(auth()->user(),$message);
        if(session()->has('previous'))
            return \redirect()->to(session()->get('previous'));
        else
        return Redirect::route('paragraph-panel');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paragraph  $paragraph
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Paragraph $paragraph)
    {
        $check=false;
        if($paragraph->exam()->count()==0){
            $message=" delete paragraph {".$paragraph->id."} ";
            Logging::logProfessor(auth()->user(),$message);
            foreach ($paragraph->questions as $question){
                $question->options()->delete();
            }
            $paragraph->questions()->delete();
            $paragraph->delete();
            $check=true;
        }
        return response()->json(['success'=>$check]);

//        return Redirect::route('paragraph.index');

    }

    public function validateData()
    {
        return \request()->validate([
            'title'=>'required|string',
            'content'=>'required|string',
        ]);
    }
}
