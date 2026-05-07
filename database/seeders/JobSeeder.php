<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Load Job listing from files;
        $jobListings = include database_path('seeders/data/job_listings.php');

        //Get tst user  id.
        $testUserId = User::where('email','test@test.com')->value('id');

         //Get all other User Id's
        $userIds = User::where('email','!=','test@test.com')->pluck('id')->toArray();
        foreach ($jobListings as $index => &$listing) {
            if($index < 2){
                // Asing the first two listings to the user

                $listing['user_id'] = $testUserId;
            }else{
                $listing['user_id'] = $userIds[array_rand($userIds)];
            }
/*
            $listing['user_id'] = $userIds[array_rand($userIds)];*/

            //Add timestamps .
            $listing['created_at']= now();
            $listing['updated_at']= now();


        }

        DB::table('job_listings')->insert($jobListings);
    }
}
