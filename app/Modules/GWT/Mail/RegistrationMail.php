<?php

namespace Modules\GWT\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\GWT\Models\User;

class RegistrationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Логин пользователя
     *
     * @var string
     */
    protected string $login;

    /**
     * Пароль пользователя
     *
     * @var string
     */
    protected string $password;

    /**
     * Инстанициировать объекта письма
     *
     * @return void
     */
    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->password = $password;

        $this->afterCommit();
    }

    /**
     * Отрисовать сообщение
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('GWT::mail.registration', [
            'login' => $this->login,
            'password' => $this->password,
        ]);
    }
}
