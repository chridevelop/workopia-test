<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="https://unpkg.com/alpinejs" defer></script>
    <title>{{$title ?? 'Workopia | Find and List jobs'}}</title>
</head>
<body class="bg-gray-100">
<x-header />

<x-nav-link></x-nav-link>
<x-hero />
<x-top-banner />
<main class="container mx-auto p-4 ">
    {{-- Display alert messages --}}
    @if(session('success'))
        <x-alert type="success" message="{{session('success')}}" />

     @endif

    @if(session('error'))
        <x-alert type="error" message="{{session('error')}}" />
     @endif
    {{$slot}}
</main>

<x-footer>

</x-footer>
</body>
</html>
