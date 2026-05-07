<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\User;


class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //get user
        $testUser = User::where('email', 'test@test.com')->firstOrFail();

        //Get all job ids
        $jobIds = Job::pluck('id')->toArray();

        $RandomJobIds = array_rand($jobIds, 3);

        foreach ($RandomJobIds as $JobId) {
            $testUser->bookmarkedJobs()->attach($jobIds[$JobId]);

        }
    }


}
