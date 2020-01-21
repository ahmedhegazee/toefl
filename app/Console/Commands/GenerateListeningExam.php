<?php

namespace App\Console\Commands;

use App\Listening\Audio;
use App\Listening\ListeningExam;
use Illuminate\Console\Command;

class GenerateListeningExam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:listeningExam {reservation}  ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Listening Exam From Random Questions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $res=$this->argument('reservation');

//        $type=$this->argument('groupType');
//        $count =ListeningExam::where('reservation_id',$res)->where('group_type_id',$type)->count();
        $count =ListeningExam::where('reservation_id',$res)->count();
        if($count==0) {
            $exam = ListeningExam::create([
                'reservation_id' => $res,
//                'group_type_id' => $type,
            ]);
            $shortSpeech = Audio::shortConversation()->get()->random(18)->pluck('id')->toArray();
            $longSpeech = Audio::longConversation()->get()->random(3)->pluck('id')->toArray();
            $dialog=Audio::speech()->get()->random(3)->pluck('id')->toArray();
            $exam->audios()->attach($shortSpeech);
            $exam->audios()->attach($longSpeech);
            $exam->audios()->attach($dialog);

            $this->info("Added:" . $exam->id);
        }else
        {
            $this->error('There is exam for this reservation and group type');
        }
    }
}
