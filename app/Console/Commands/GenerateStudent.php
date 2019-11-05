<?php

namespace App\Console\Commands;

use App\Http\Controllers\Auth\RegisterController;
use App\Student;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GenerateStudent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:student';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate initial student';

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
        $user=  User::create([
            'name' => 'Ahmed Ashraf Hegazy',
            'email'=>'ahmed@email.com',
//            'password' => Hash::make('password'),
            'password' => Hash::make('01234567891'),
            'role_id'=>2
        ]);
        Student::create([
            'uid'=> $user->id,
            'phone'=>'01234567891',
            'arabic_name'=>'أحمد أشرف حجازي',
            'personalimage'=>"personalimages/82gQX7mgFq88xKNZLEz05bJNpi6YlaTSlmmBBZtT.jpeg",
            'nidimage'=>"nidimages/PbysiJmknQX5Vbgk0Hea81RynFf3PoNxBi5qsL8p.jpeg",
            'certificateimage'=>"certificateimages/KwD353A8ZlOBuXkObXb1gZVjjROBNdxBQxBEZt9J.jpeg",
            'messageimage'=>"messageimages/2j6T1AbL2PHugcoftRIrmLat08zqQobXNFQHkNdQ.jpeg",
            'res_id'=>1,
            'group_id'=>1,
            'verified'=>1,
            'enterexam'=>1,
            'startexam'=>1
        ]);
    }
}
