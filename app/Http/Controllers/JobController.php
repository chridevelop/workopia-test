<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class JobController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        //
        $jobs= Job::latest()->paginate(6);

        return view('jobs.index')->with('jobs',$jobs);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        if(!Auth::check()){
            return redirect()->route('login');
        }
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        //Check if user is auth

        $validateData = $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'required|string',
            'salary'=>'required|integer',
            'tags'=>'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements'=>'required|string',
            'benefits'=>'nullable|string',
            'address'=>'nullable|string',
            'city'=>'required|string',
            'state'=>'nullable|string',
            'zipcode'=>'nullable|string',
            'contact_email'=>'required|string',
            'contact_phone'=>'nullable|string',
            'company_name'=>'required|string',
            'company_description'=>'nullable|string',
            'company_logo'=>'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'company_website'=>'nullable|url'
        ]);

        //Hardcode user id
        $validateData['user_id'] = auth()->user()->id;

        if($request->hasFile('company_logo')){
            //Store the file and get the path.
            $path = $request->file('company_logo')->store('logos','public');
            $validateData['company_logo']=$path;
        }

        $jb = Job::create($validateData);

        return redirect()->route('jobs.index')->with('success','Job listing created succesfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        //
        $jobs= Job::find($id);

        return view('jobs.show')->with('job',$jobs);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job): View
    {

        $this->authorize('update', $job);
        //

        return view('jobs.edit')->with('job', $job);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {

        $this->authorize('update', $job);

        //
        $validateData = $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'required|string',
            'salary'=>'required|integer',
            'tags'=>'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements'=>'required|string',
            'benefits'=>'nullable|string',
            'address'=>'nullable|string',
            'city'=>'required|string',
            'state'=>'nullable|string',
            'zipcode'=>'nullable|string',
            'contact_email'=>'required|string',
            'contact_phone'=>'nullable|string',
            'company_name'=>'required|string',
            'company_description'=>'nullable|string',
            'company_logo'=>'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'company_website'=>'nullable|url'
        ]);

        //Hardcode user id
        $validateData['user_id'] = 1;

        if($request->hasFile('company_logo')){
            //Delete old Logo.
            Storage::delete('public/logos/'.basename($job->company_logo));

            //Store the file and get the path.
            $path = $request->file('company_logo')->store('logos','public');
            $validateData['company_logo']=$path;
        }

       $job->update($validateData);

        return redirect()->route('jobs.index')->with('success','Job listing updateed succesfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job):RedirectResponse
    {

        $this->authorize('delete', $job);
        //
        if($job->company_log){
            Storage::delete('public/logos'. $job->company_logoa);
        }
        $job->delete();

        //Check if request come form dashboard.
        if(request()->query('from')== 'dashboard'){
            return redirect()->route('dashboard')->with('success','Job listing deleted succesfully!');
        }
        return redirect()->route('jobs.index')->with('success','Job listing deleted succesfully!');
    }

    public function search(Request $request):string
    {
        $keywords = strtolower($request->input('keywords'));
        $location = strtolower($request->input('location'));

        $query = Job::query();

        if($keywords){
            $query->where(function($q) use($keywords){
                $q->orWhereRaw('LOWER(title) like ?',['%'.$keywords.'%'])
                ->orWhereRaw('LOWER(description) like ?',['%'.$keywords.'%'])
                ->orWhereRaw('LOWER(tags) like ?',['%'.$keywords.'%']);
            });
        }
        if($location){
            $query->where(function($q) use($location){
                $q->orWhereRaw('LOWER(address) like ?',['%'.$location.'%'])
                ->orWhereRaw('LOWER(city) like ?',['%'.$location.'%'])
                ->orWhereRaw('LOWER(state) like ?',['%'.$location.'%'])
                ->orWhereRaw('LOWER(zipcode) like ?',['%'.$location.'%']);
            });
        }

        $jobs = $query->paginate(12);
        return view('jobs.index')->with('jobs',$jobs);

    }
}
