<?php

namespace routes;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        //
        $jobs= Job::all();

        return view('jobs.index')->with('jobs',$jobs);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
