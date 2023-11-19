<head>
  
  @php
 use App\Models\Information;
  $information = Information::first();
@endphp
  
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> {{ $information->site_name }} </title>
    <meta name="robots" content="index, follow" />
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/img/'.$information->site_logo)}}">    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@100;200;300;400;500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- CSS
    ============================================ -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/vendor/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/vendor/font-awesome.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/vendor/flaticon/flaticon.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/vendor/slick.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/vendor/slick-theme.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/vendor/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/vendor/sal.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/vendor/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/vendor/base.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.min.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/header.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/update.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    @stack('css')
    {!!\App\Models\Information::value('tracking_code')!!}
</head>