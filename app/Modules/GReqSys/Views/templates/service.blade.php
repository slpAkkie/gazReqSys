@include('GReqSys::components.header')

<div class="wrapper d-flex">
    <div class="content w-100 d-flex justify-content-center align-items-center">
        <div class="card p-2 shadow">
            @yield('body')
        </div>
    </div>
</div>

@yield('scripts')

@include('GReqSys::components.footer')
