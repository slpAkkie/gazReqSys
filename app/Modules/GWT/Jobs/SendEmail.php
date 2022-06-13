<?php

namespace Modules\GWT\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Modules\GWT\Mail\RegistrationMail;
use Modules\GWT\Models\User;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Почта пользователя
     *
     * @var string
     */
    protected string $email;

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
     * Инстанциировать задачу
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->email = $user->email;
        $this->login = $user->login;
        $this->password = $user->unhashed_password;

        $this->afterCommit();
    }

    /**
     * Выполнить задачу
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new RegistrationMail($this->login, $this->password));
    }
}
