@component('mail::message')

# Ваш аккаунт в системе WT восстановлен

Ваш лоигн: {{ $params['login'] }} <br />
Ваш пароль: {{ $params['password'] }}

@endcomponent
