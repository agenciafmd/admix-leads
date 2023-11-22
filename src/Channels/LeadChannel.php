<?php

namespace Agenciafmd\Leads\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class LeadChannel
{
    public function send(mixed $notifiable, Notification $notification): void
    {
        $lines = collect($notification->data['introLines']);

        $data['source'] = $notifiable->slug;
        $data['name'] = null;
        $data['email'] = null;
        $data['phone'] = null;
        $data['message'] = null;

        foreach ($lines as $line) {
            $line = Str::of($line)
                ->replace('*', '')
                ->__toString();
            $normalizedLine = $this->normalize($line);
            if (Str::of($normalizedLine)
                ->startsWith(['nome'])) {
                $data['name'] = Str::of($line)
                    ->after(' ')
                    ->toString();
            } elseif (Str::of($normalizedLine)
                ->startsWith(['email', 'e-mail'])) {
                $data['email'] = Str::of($line)
                    ->after(' ')
                    ->toString();
            } elseif (Str::of($normalizedLine)
                ->startsWith(['telefone', 'celular'])) {
                $data['phone'] = Str::of($line)
                    ->after(' ')
                    ->toString();
            } else {
                $data['message'] .= "{$line} \n";
            }
        }

        if ($data['email']) {
            $notification->toLead($data);
        }
    }

    private function normalize(string $string): string
    {
        return Str::of($string)
            ->lower()
            ->replace([':', '*'], '')
            ->__toString();
    }
}
