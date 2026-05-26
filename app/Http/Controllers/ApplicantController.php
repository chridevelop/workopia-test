<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Applicant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Mail\JobApplied;
use Illuminate\Support\Facades\Mail;

class ApplicantController extends Controller
{

    public function store(Request $request, Job $job): RedirectResponse
    {
        //@check if the loged user exist in Applicants with job_id
        $existingApplication = Applicant::where('job_id',$job->id)->
            where('user_id',auth()->id())->exists();


        if($existingApplication){
            return redirect()->back()->with('error','Your already applied for this job');
        }

        //@desc Store new job application
        //@route POST /jobs/{job}/apply

        $validateData = $request->validate([
            'full_name' => 'required|string',
            'contact_phone' => 'string',
            'contact_email' => 'required|string|email',
            'message' => 'string',
            'location' => 'string',
            'resume' => 'required|file|mimes:pdf|max:2048' ,
        ]);

        //Handle resume upload
        if($request->hasFile('resume')){
            $path = $request->file('resume')->store('resume','public');
            $validateData['resume_path'] = $path;

        }

        //Store the Application

        $application =new Applicant($validateData);
        $application->job_id = $job->id;
        $application->user_id = auth()->id();
        $application->save();

        //Send emai lto owner .
      //  Mail::to($job->user->email)->send(new JobApplied($application,$job))  ;


        return redirect()->back()->with('success', 'Your application has been submitted');

    }

    public function destroy($id): RedirectResponse
    {

        $applicant = Applicant::findOrFail($id);
        $applicant->delete();
        return redirect()->route('dashboard')->with('success', 'Applicant deleted successfully');

    }
}
