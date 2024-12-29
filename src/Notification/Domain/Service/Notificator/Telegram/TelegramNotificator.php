<?php

namespace App\Notification\Domain\Service\Notificator\Telegram;

use App\Notification\Domain\Exception\SendNotificationException;
use App\Notification\Domain\Notification;
use App\Notification\Domain\Service\Notificator\Notificator;

class TelegramNotificator implements Notificator
{
    private const API_URL = "https://api.telegram.org/bot{botToken}/sendMessage";

    public function send(Notification $notification): void
    {
        $botToken = $notification->getFrom();
        $chatId = $notification->getTo();
        $telegramApiUrl = str_replace('{botToken}', $botToken, self::API_URL);

        $data = [
            'chat_id' => $chatId,
            'text' => $notification->getMessage()
        ];

        $ch = curl_init($telegramApiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpCode !== 200){
            $decoredResponse = json_decode($response, true);

            if(!isset($decoredResponse['ok']) || false === $decoredResponse['ok']){
                throw new SendNotificationException(
                    'Error sending Telegram notification: ' . $response
                );
            }
        }
    }
}