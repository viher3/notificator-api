<?php

namespace App\Notification\Domain;

use Ramsey\Collection\AbstractCollection;

class PendingNotificationCollection extends AbstractCollection
{
    public function getType(): string
    {
        return PendingNotification::class;
    }

    public function serialize() : array
    {
        $response = [];

        /** @var PendingNotification $pendingNotification */
        foreach($this->data as $pendingNotification){
            $response[] = [
                'type' => $pendingNotification->getType()
            ];
        }

        return $response;
    }
}