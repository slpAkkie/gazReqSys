@component('mail::message')

# Вы были зарегистрированы в системе WT

Ваш лоигн: {{ $login }} <br />
Ваш пароль: {{ $password }}

@endcomponent
