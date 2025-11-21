<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class AssignmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $giverName;
    public string $receiverName;

    public function __construct(string $giverName, string $receiverName)
    {
        $this->giverName = $giverName;
        $this->receiverName = $receiverName;
    }

    public function build()
    {
        $gifUrl = 'https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExM3RqOXRnaXgzdWp5aTliaTl1bnVjODZvMm5lbTY3MWk0eDc2aXRoaCZlcD12MV9naWZzX3NlYXJjaCZjdD1n/WxTG12gbrdiHb0H1Jo/giphy.gif';

        $body = "
            Hola {$this->giverName}!<br><br>
            Amic invisible de REIS (6 de gener)!<br><br>
            Pressupost: 20 euros!!<br><br>
            T'ha tocat fer-li un regal a: <b><u>" . strtoupper($this->receiverName) . "</u></b><br><br>
            <b><i>BON NADAL!</i></b><br><br>
            <img src='{$gifUrl}' alt='Happy Holidays GIF' />
        ";

        return $this->subject('El teu amic invisible')
            ->html($body);
    }
}
