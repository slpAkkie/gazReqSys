@extends('templates.service')

@section('title', 'Вход')

@section('content')
    <h2 class="text-secondary text-center fw-normal my-3">Вход в систему</h2>

    <form method="post" action="{{ route('auth.login') }}" class="login p-4">
        @csrf
        <div class="mb-2">
            <label class="form-label d-flex align-items-center [@error('login') is-invalid @enderror]" for="login">
                <i class="bi bi-person-circle me-2 input-prefix-icon"></i>
                <input type="text" id="login" name="login" class="form-control w-100 border-c-light prefix-icon" placeholder="Логин">
            </label>
            <p class="invalid-feedback">@error('login') {{ $message }} @enderror</p>
        </div>
        <div class="mb-2">
            <label class="form-label d-flex align-items-center [@error('password') is-invalid @enderror]" for="password">
                <i class="bi bi-key me-2 input-prefix-icon"></i>
                <input type="password" id="password" name="password" class="form-control w-100 border-c-light prefix-icon" placeholder="Пароль">
            </label>
            <p class="invalid-feedback">@error('password') {{ $message }} @enderror</p>
        </div>

        <input type="submit" value="Войти" class="btn btn-primary w-100">
    </form>
@endsection
