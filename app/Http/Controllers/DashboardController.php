<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    //@desc Show all users job listings
    //@route GET /Dashborad
    public function index(): View
    {
        //Get logged users
        $user = Auth::user();


        //Get the jobs user
        $jobs = Job::where('user_id', $user->id)->get();

        return view('dashboard.index', compact('user','jobs'));
    }
}
