<?php

namespace Modules\WT\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

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
     * Класс письма на отправку
     *
     * @var string
     */
    protected string $mail;

    /**
     * Параметры для письма
     *
     * @var array
     */
    protected array $params;

    /**
     * Инстанциировать задачу
     *
     * @return void
     */
    public function __construct(string $email, string $mail, array $params = [])
    {
        $this->email = $email;
        $this->mail = $mail;
        $this->params = $params;

        $this->afterCommit();
    }

    /**
     * Выполнить задачу
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new $this->mail($this->params));
    }
}
