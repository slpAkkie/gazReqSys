@extends('templates._general')

@section('body')
    <div class="site-wrapper">
        <div class="row m-0 h-100">
            <aside class="sidebar col-2 p-3">
                <div class="sidebar__header">
                    <h1 class="sidebar__title mb-3">GazReqSys</h1>
                </div>

                <nav class="sb-nav d-flex flex-column h-100">
                    <ul class="sb-nav__ul list-unstyled flex-grow-1">
                        <li class="sb-nav__li mb-2"><a class="sb-nav__link text-decoration-none" href="#">Список всех заявок</a></li>
                        <li class="sb-nav__li"><a class="sb-nav__link text-decoration-none" href="#">Добавление заявки</a></li>
                    </ul>
                    <a class="sb-nav__link exit-btn text-decoration-none" href="#">Выйти</a>
                </nav>
            </aside>
            <div class="content-wrapper col p-3">
                @yield('content')
            </div>
        </div>
    </div>
@endsection
