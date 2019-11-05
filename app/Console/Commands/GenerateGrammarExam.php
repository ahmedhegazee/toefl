<?php

namespace App\Console\Commands;

use App\Grammar\GrammarExam;
use App\Grammar\GrammarQuestion;
use Illuminate\Console\Command;

class GenerateGrammarExam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:grammarExam {reservation}  {groupType}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Grammar Exam From Random Questions';

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

        $type=$this->argument('groupType');
        $count =GrammarExam::where('reservation_id',$res)->where('group_type_id',$type)->count();
        if($count==0) {
            $exam = GrammarExam::create([
                'reservation_id' => $res,
                'group_type_id' => $type,
            ]);
            $fillQuestions = GrammarQuestion::fillQuestions()->random(15)->pluck('id')->toArray();
            $findQuestions = GrammarQuestion::findQuestions()->random(25)->pluck('id')->toArray();

            $exam->questions()->attach($fillQuestions);
            $exam->questions()->attach($findQuestions);
            $this->info("Added:" . $exam->id);
        }else
        {
            $this->error('There is exam for this reservation and group type');
        }
    }
}
