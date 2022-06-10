@extends('templates.service')

@section('title', 'Вход')

@section('content')
    <h1 class="text-secondary text-center fw-normal mb-3">GReqSys</h1>

    <form method="post" action="#" class="login p-2">
        <div class="mb-2">
            <label class="d-flex align-items-center" for="login">
                <i class="bi bi-person-circle me-2"></i>
                <input type="text" id="login" name="login" class="form-control w-100 border-c-light" placeholder="Логин">
            </label>
        </div>
        <div class="mb-2">
            <label class="d-flex align-items-center" for="password">
                <i class="bi bi-key me-2"></i>
                <input type="password" id="password" name="password" class="form-control w-100 border-c-light" placeholder="Пароль">
            </label>
        </div>

        <input type="submit" value="Войти" class="btn btn-primary w-100">
    </form>
@endsection
