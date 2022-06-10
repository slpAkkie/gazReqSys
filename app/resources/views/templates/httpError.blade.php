@extends('templates.service')

@section('content')
    <div class="http-error p-2">
        <h1 class="http-error__code text-danger mb-0 me-4">@yield('code')</h1>
        <div class="http-error__body">
            <p class="http-error__title text-danger mb-1">@yield('title')</p>
            <p class="http-error__message text-muted">@yield('message')</p>
        </div>
    </div>
@endsection
