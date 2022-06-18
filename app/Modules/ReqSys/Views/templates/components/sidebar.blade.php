<aside class="sidebar col-2 p-4" id="sidebar">
    <div class="sidebar__header mb-3">
        <h3 class="sidebar__title">Система заявок ГАЗ</h3>
        <h6 class="fw-semibold">{{ Auth::user()->staff->getFullName() }}</h6>
    </div>

    <nav class="sb-nav d-flex flex-column h-100">
        <ul class="sb-nav__ul list-unstyled flex-grow-1">
            <li class="sb-nav__li mb-2"><a class="sb-nav__link text-decoration-none" href="{{ route('req.index') }}">{{ Auth::user()->admin ? 'Все заявки' : 'Мои заявки' }}</a></li>
            <li class="sb-nav__li mb-2"><a class="sb-nav__link text-decoration-none" href="{{ route('req.index-for-me') }}">Заявки на меня</a></li>
            <li class="sb-nav__li"><a class="sb-nav__link text-decoration-none" href="{{ route('req.create') }}">Создать заявку</a></li>
        </ul>
        <form ref="loginForm" action="{{ route('auth.logout') }}" method="post">
            @csrf
            @method('put')
            <a class="sb-nav__link text-decoration-none fw-bold" @click.prevent="$refs.loginForm.submit()" href="#">Выйти</a>
        </form>
    </nav>
</aside>

<script>
    const sidebar = Vue.createApp({
        name: 'Sidebar',
    }).mount('#sidebar')
</script>
