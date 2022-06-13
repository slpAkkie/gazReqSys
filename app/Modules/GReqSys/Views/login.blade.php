@extends('templates.service')

@section('title', 'Вход')

@section('content')
    <h2 class="text-secondary text-center fw-normal my-3">Вход в систему</h2>

    <form method="post" action="{{ route('auth.login') }}" class="login p-4">
        @csrf
        <div class="mb-2">
            <label class="form-label form-label_prefix-icon d-flex align-items-center [@error('login') is-invalid @enderror]" for="login">
                <i class="bi bi-person-fill me-2 form-control-icon"></i>
                <input type="text" id="login" name="login" class="form-control form-control_prefix-icon w-100 border-c-light prefix-icon" placeholder="Логин" value="{{ old('login') }}">
            </label>
            <p class="invalid-feedback">@error('login') {{ $message }} @enderror</p>
        </div>
        <div class="mb-2">
            <label class="form-label form-label_prefix-icon d-flex align-items-center [@error('password') is-invalid @enderror]" for="password">
                <i class="bi bi-key-fill me-2 form-control-icon"></i>
                <input type="password" id="password" name="password" class="form-control form-control_prefix-icon w-100 border-c-light" placeholder="Пароль">
            </label>
            <p class="invalid-feedback">@error('password') {{ $message }} @enderror</p>
        </div>
        <div class="mb-2 form-check">
            <input type="checkbox" id="remember_me" name="remember_me" class="form-check-input border-c-light">
            <label class="form-check-label [@error('remember_me') is-invalid @enderror]" for="remember_me">Запомнить меня</label>
        </div>

        <input type="submit" value="Войти" class="btn btn-primary w-100">
    </form>
@endsection
