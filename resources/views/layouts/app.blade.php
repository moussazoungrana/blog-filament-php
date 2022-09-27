<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="preconnect" href="https://unpkg.com" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link rel="preload"
          href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&family=Rubik:wght@700&display=swap"
          as="style" onload="this.onload=null;this.rel='stylesheet'">

    <noscript>
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&family=Rubik:wght@700&display=swap">
    </noscript>


    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    @yield('extra-style')
    @livewireStyles
</head>
<body>

<div id="app">

    <div class="page-content--wrapper">

        <main class="page-main">
            @yield('content')
        </main>

    </div>

</div>


@yield('extra-script')
@livewireScripts
</body>
</html>
