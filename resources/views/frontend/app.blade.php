<!DOCTYPE html>
<html lang="en">
@include('frontend.partials.head')
<body class="sticky-header" style="max-width: 1600px;margin: 0 auto">
    <a href="#top" class="back-to-top" id="backto-top" style="background: #00276C;"><i class="fal fa-arrow-up"></i></a>
    @include('frontend.partials.header')
    @yield('content')

@include('frontend.partials.footer')
    