@extends('GReqSys::templates.service')

@section('body')
<h1 class="title mb-3 text-center">GReqSys</h1>
<form method="post" action="" class="login p-2">
    <label class="d-flex align-items-center mb-2" for="login">
        <i class="bi bi-person-circle me-2"></i>
        <input placeholder="Логин" id="login" class="form-control w-100" type="text">
    </label>
    <label class="d-flex align-items-center mb-2" for="login">
        <i class="bi bi-key me-2"></i>
        <input placeholder="Пароль" id="login" class="form-control w-100" type="text">
    </label>
    <input type="submit" value="Войти" class="btn btn-primary w-100">
</form>
@endsection
