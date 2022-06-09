@include('GReqSys::tpl.header')

<div class="wrapper d-flex">
    <aside class="sidebar d-flex flex-column shadow position-fixed p-3">
        <div class="sidebar__header mb-3">
            <h1 class="sidebar-title">GazReqSys</h1>
        </div>

        <nav class="sidebar-nav d-flex flex-column h-100">
            <ul class="sidebar-nav__ul list-unstyled flex-grow-1">
                <li class="sidebar-nav__li mb-2"><a class="sidebar-nav__link text-decoration-none" href="#">Список всех заявок</a></li>
                <li class="sidebar-nav__li"><a class="sidebar-nav__link text-decoration-none" href="#">Добавление заявки</a></li>
            </ul>
            <a class="sidebar-nav__link exit-btn text-decoration-none" href="#">Выйти</a>
        </nav>
    </aside>
    <div class="content p-3 w-100">
        @yield('body')
    </div>
</div>

@yield('scripts')

@include('GReqSys::tpl.footer')
