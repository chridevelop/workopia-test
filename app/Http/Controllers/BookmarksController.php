<?php

namespace App\Http\Controllers;

use http\Client\Curl\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Job;

class BookmarksController extends Controller
{
    //
    public function index():View
    {
        $user = Auth::user();
        $bookmarks = $user->bookmarkedJobs()->orderby('job_user_bookmarks.created_at','desc')->paginate(9);
        return view('jobs.bookmarked')->with('bookmarks',$bookmarks);

    }

    //@desc create a new bookmark store
    public function store(Job $job):RedirectResponse
    {

        $user = Auth::user();

        //Check if the job already bookmarked
        if($user->bookmarkedJobs()->where('job_id',$job->id)->exists()){
            return  back()->with('error','Job is already bookmarked');
        }


        //create new bookmark

        $user->bookmarkedJobs()->attach($job->id);

        return  back()->with('success','Job bookmarked succesfully!');
    }

    //@desc Remove a bookmark from stored jobs
    //@route DELETE /bookmarks/{job}
    public function destroy(Job $job):RedirectResponse
    {

        $user = Auth::user();

        //Check if the job already bookmarked
        if(!$user->bookmarkedJobs()->where('job_id',$job->id)->exists()){
            return  back()->with('error','Job is not bookmarked');
        }


        //Remove bookmark

        $user->bookmarkedJobs()->detach($job->id);

        return  back()->with('success','Bookmarked removed succesfully!');
    }
}
