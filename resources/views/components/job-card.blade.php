@props(['job'])

<div>
    {{$job->title}}
 <p class="text-gray-700 text-lg mt-2">   {{Str::limit($job->description, 100)}}</p>
    {{$job->job_type}}
    {{$job->salary}}
</div>
