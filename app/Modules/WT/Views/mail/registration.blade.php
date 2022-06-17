@component('mail::message')

# Вы были зарегистрированы в системе WT

Ваш лоигн: {{ $params['login'] }} <br />
Ваш пароль: {{ $params['password'] }}

@endcomponent
