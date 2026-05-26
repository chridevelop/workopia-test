@props(['jobs'])

<x-layout>
    <div class="bg-blue-900 h-24 px-4 mb-4 flex justify-center items-center rounded">
    <x-search />
    </div>

    {{--Back buttons--}}
    @if(request()->has('keywords') || request()->has('location'))
        <a href="{{route('jobs.index')}}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded mb-4 inline-block">
            <i class="fa fa-arrow-left text-white"></i>Back
        </a>
    @endif


    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @foreach($jobs as $job)
          <x-job-card :job="$job" />

        @endforeach
    </div>
    {{-- Pagination Links --}}
    @if(method_exists($jobs, 'links'))
    {{$jobs->links()}}
    @endif
</x-layout>
