@component('mail::message')

# Вы были зарегистрированы в системе WT

- Ваш лоигн: {{ $login }}
- Ваш пароль: {{ $password }}

@endcomponent
