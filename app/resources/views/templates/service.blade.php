@extends('templates._general')

@section('body')
    <div class="site-wrapper">
        <div class="d-grid h-100 justify-content-center align-items-center">
            <div class="card p-2 shadow-sm border-c-light">
                @yield('content')
            </div>
        </div>
    </div>
@endsection
