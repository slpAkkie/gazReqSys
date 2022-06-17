@extends('templates._general')

@section('body')
    <div class="site-wrapper">
        <div class="row m-0 h-100">
            @include('ReqSys::templates.components.sidebar')

            <div class="content-wrapper offset-2 col p-4">
                <h3 class="mb-4">@yield('title')</h3>

                @yield('content')
            </div>
        </div>
    </div>
@endsection
