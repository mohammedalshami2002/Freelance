    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ URL::asset('assets/compiled/css/dashborad.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    
    @if (App::getLocale()=='ar')
    <link rel="shortcut icon" href="{{ URL::asset('assets/compiled/svg/logo.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{ URL::asset('assets/compiled/css/app.rtl.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/compiled/css/iconly.rtl.css')}}">
    <link rel="shortcut icon" href="{{URL::asset('assets/compiled/svg/logo.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{URL::asset('assets/compiled/css/auth.rtl.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/extensions/choices.js/public/assets/styles/choices.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/extensions/fortawesome/fontawesome-free/css/all.min.css') }}">
    @else
    <link rel="shortcut icon" href="{{ URL::asset('assets/compiled/svg/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ URL::asset('assets/compiled/css/app.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/compiled/css/iconly.css')}}">
    <link rel="shortcut icon" href="{{URL::asset('assets/compiled/svg/logo.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{URL::asset('assets/compiled/css/auth.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/extensions/choices.js/public/assets/styles/choices.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/extensions/fortawesome/fontawesome-free/css/all.min.css') }}">
    @endif
    @yield('css')

