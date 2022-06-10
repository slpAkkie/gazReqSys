<aside class="sidebar col-2 p-4">
    <div class="sidebar__header">
        <h1 class="sidebar__title mb-3">Система заявок ГАЗ</h1>
    </div>

    <nav class="sb-nav d-flex flex-column h-100">
        <ul class="sb-nav__ul list-unstyled flex-grow-1">
            <li class="sb-nav__li mb-2"><a class="sb-nav__link text-decoration-none" href="{{ route('req.index') }}">Посмотреть заявки</a></li>
            <li class="sb-nav__li"><a class="sb-nav__link text-decoration-none" href="{{ route('req.create') }}">Создать заявку</a></li>
        </ul>
        <a class="sb-nav__link text-decoration-none" href="{{ route('auth.logout') }}">Выйти</a>
    </nav>
</aside>
