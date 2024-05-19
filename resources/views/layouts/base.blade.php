<!DOCTYPE html>
<html lang="en">
<head>
    @include('.layouts.lib')
    <title>@yield('title')</title>
    @yield('ownlib')
</head>
<body>
    @include('.layouts.header')
    @include('.layouts.modal')

    @yield('content')

    @include('.layouts.footer')
</body>
</html>