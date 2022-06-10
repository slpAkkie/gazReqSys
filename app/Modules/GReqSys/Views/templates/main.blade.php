@extends('templates._general')

@section('body')
    <div class="site-wrapper">
        <div class="row m-0 h-100">
            @include('GReqSys::templates.components.sidebar')

            <div class="content-wrapper offset-2 col p-4">
                <h2 class="mb-4">@yield('title')</h2>

                @yield('content')
            </div>
        </div>
    </div>
@endsection
