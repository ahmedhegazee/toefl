<?php

namespace App\Console\Commands;

use App\Reading\Paragraph;
use App\Reading\ReadingExam;
use App\Reading\VocabQuestion;
use Illuminate\Console\Command;

class GenerateReadingExam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:readingExam {reservation}  {groupType}';

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
        $count =ReadingExam::where('reservation_id',$res)->where('group_type_id',$type)->count();
        if($count==0) {
            $exam = ReadingExam::create([
                'reservation_id' => $res,
                'group_type_id' => $type,
            ]);
            $vocabQuestions = VocabQuestion::all()->random(30)->pluck('id')->toArray();
            $paragraphs = Paragraph::all()->random(5)->pluck('id')->toArray();

            $exam->vocabQuestions()->attach($vocabQuestions);
            $exam->paragraphs()->attach($paragraphs);
            $this->info("Added:" . $exam->id);
        }else
        {
            $this->error('There is exam for this reservation and group type');
        }
    }
}
