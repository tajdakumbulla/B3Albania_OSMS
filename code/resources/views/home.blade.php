@extends('layouts.app')

@section('content')


    <div class="parallax-container" style="height: 700px">
        <div class="parallax"><img style="width: 100%" src="{{asset('/assets/parallax1.png')}}"></div>
    </div>
    <div class="section white">
        <div class="row container">
            <h2 class="header">KALOO</h2>
            <p class="grey-text text-darken-3 lighten-3">Kaloo, a French-style passion story, offers toddlers and grown-ups soft and enchanting universes that meet their needs for awakening, tenderness and security.</p>
        </div>
    </div>
    <div class="parallax-container" style="height: 700px">
        <div class="parallax"><img style="width: 100%" src="{{asset('/assets/parallax2.jpg')}}"></div>
    </div>
    <div class="section white">
        <div class="row container">
            <h2 class="header">Parallax</h2>
            <p class="grey-text text-darken-3 lighten-3">Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.</p>
        </div>
    </div>
    <div class="parallax-container" style="height: 700px">
        <div class="parallax"><img style="width: 100%" src="{{asset('/assets/parallax3.jpg')}}"></div>
    </div>
    <div class="section white">
        <div class="row container">
            <h2 class="header">Parallax</h2>
            <p class="grey-text text-darken-3 lighten-3">Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.</p>
        </div>
    </div>
    <div class="parallax-container" style="height: 700px">
        <div class="parallax"><img style="width: 100%" src="{{asset('/assets/parallax4.jpg')}}"></div>
    </div>
    <script>
        $(document).ready(function(){
            $('.parallax').parallax();
        });
    </script>
@endsection
