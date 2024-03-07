<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NuevoAviso extends Mailable
{
    use Queueable, SerializesModels;

    public $Titulo;

    public function __construct(String $Titulo)
    {
        $this->Titulo=$Titulo;
    }

        /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */

    public function build(){
        return $this->view('emails.NuevoAviso')->with([
            'Titulo' => $this->Titulo,
            'Imagen'=>asset('img/IconoTec.png')
        ])
        ->subject("Nuevo anuncio:$this->Titulo");
    }
}
