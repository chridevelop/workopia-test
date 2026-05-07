@props(['jobs'])

<x-layout>

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
