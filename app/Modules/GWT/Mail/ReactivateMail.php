<?php

namespace Modules\GWT\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReactivateMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Данные письма
     *
     * @var string
     */
    protected array $params;

    /**
     * Инстанициировать объекта письма
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;

        $this->afterCommit();
    }

    /**
     * Отрисовать сообщение
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('GWT::mail.reactivate', [ 'params' => $this->params ]);
    }
}
