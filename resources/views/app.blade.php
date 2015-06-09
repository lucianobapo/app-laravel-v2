<!DOCTYPE html>
<html lang="pt_br">
<head>
    @include('partials.head')
</head>
<body>
    <header>
        @include('partials.nav')
    </header>

    <section class="container">
        @include('flash::message')
        @yield('content')
    </section>

    @include('partials.footer')
</body>
</html>
