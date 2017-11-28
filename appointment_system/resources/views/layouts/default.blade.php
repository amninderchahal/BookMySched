<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body>
    <div>
    <header>
        @include('includes.header')
    </header>
    <div class="main">
        @yield('content')
    </div>
    <footer>
        @include('includes.footer')
    </footer>
    </div>
</body>
</html>
