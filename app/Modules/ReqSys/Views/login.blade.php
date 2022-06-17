@extends('templates.service')

@section('title', 'Вход')

@section('content')
    <h2 class="text-secondary text-center fw-normal my-3">Вход в систему</h2>

    <section id="section_login-form">
        <form method="post" action="{{ route('auth.login') }}" @submit="formSubmit" class="login p-4" :class="{ disabled: formBlocked }">
            @csrf
            <div class="mb-2">
                <label class="form-label form-label_prefix-icon d-flex align-items-center [@error('login') is-invalid @enderror]" for="login">
                    <i class="bi bi-person-fill me-2 form-control-icon form-control-icon_prefix"></i>
                    <input type="text" id="login" name="login" class="form-control form-control_prefix-icon w-100 border-c-light prefix-icon" placeholder="Логин" v-model="formData.login">
                </label>
                <p class="invalid-feedback">@error('login') {{ $message }} @enderror</p>
            </div>
            <div class="mb-2">
                <label class="form-label form-label_prefix-icon d-flex align-items-center [@error('password') is-invalid @enderror]" for="password">
                    <i class="bi bi-key-fill form-control-icon form-control-icon_prefix"></i>
                    <input :type="passwordInputType" id="password" name="password" class="form-control form-control_prefix-icon form-control_suffix-icon w-100 border-c-light" placeholder="Пароль" v-model="formData.password">
                    <i class="bi form-control-icon form-control-icon_suffix cursor-pointer" :class="passwordShowIcon" @click="showPassword = !showPassword"></i>
                </label>
                <p class="invalid-feedback">@error('password') {{ $message }} @enderror</p>
            </div>
            <div class="mb-2 form-check">
                <input type="checkbox" id="remember_me" name="remember_me" class="form-check-input border-c-light">
                <label class="form-check-label [@error('remember_me') is-invalid @enderror]" for="remember_me">Запомнить меня</label>
            </div>

            <input type="submit" value="Войти" class="btn btn-primary w-100">
        </form>
    </section>
@endsection

@section('footer-js')
    <script>
        const loginForm = Vue.createApp({
            name: 'LoginForm',
            data: () => ({
                formData: {
                    login: '{{ old('login') }}',
                    password: '',
                },
                maxLength: {
                    login: 32,
                    password: 16,
                },
                formBlocked: false,

                showPassword: false,
            }),
            computed: {
                passwordInputType() {
                    return this.showPassword ? 'text' : 'password'
                },
                passwordShowIcon() {
                    return this.showPassword ? 'bi-eye-slash' : 'bi-eye'
                },
            },
            watch: {
                'formData.login': function (newVal, oldVal) {
                    (newVal.length > this.maxLength.login) && (this.formData.login = oldVal)
                },
                'formData.password': function (newVal, oldVal) {
                    (newVal.length > this.maxLength.password) && (this.formData.password = oldVal)
                },
            },
            methods: {
                formSubmit() {
                    this.formBlocked = true
                },
            },
        }).mount('#section_login-form')
    </script>
@endsection
