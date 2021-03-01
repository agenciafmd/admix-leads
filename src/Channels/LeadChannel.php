<?php

namespace Agenciafmd\Leads\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class LeadChannel
{
    public function send($notifiable, Notification $notification)
    {
        $lines = collect($notification->data['introLines']);

        $data['source'] = $notifiable->slug;
        $data['name'] = null;
        $data['email'] = null;
        $data['phone'] = null;
        $data['message'] = null;

        foreach ($lines as $line) {
            $line = str_replace(['*'], '', $line);

            if (Str::startsWith($this->normalize($line), ['nome'])) {
                $data['name'] = Str::after($line, ' ');
            } elseif (Str::startsWith($this->normalize($line), ['email', 'e-mail'])) {
                $data['email'] = Str::after($line, ' ');
            } elseif (Str::startsWith($this->normalize($line), ['telefone', 'celular'])) {
                $data['phone'] = Str::after($line, ' ');
            } else {
                $data['message'] .= "$line \n";
            }
        }

        if ($data['email']) {
            $notification->toLead($data);
        }
    }

    private function normalize($string)
    {
        return lcfirst(str_replace([':', '*'], '', $string));
    }
}