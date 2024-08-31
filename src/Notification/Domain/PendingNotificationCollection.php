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
                'id' => $pendingNotification->getId(),
                'type' => $pendingNotification->getType(),
                'message' => $pendingNotification->getMessage(),
                'to' => $pendingNotification->getTo(),
                'from' => $pendingNotification->getFrom(),
                'subject' => $pendingNotification->getSubject(),
                'createdAt' => $pendingNotification->getCreatedAt()->toDateTimeString(),
                'options' => $pendingNotification->getOptions(),
            ];
        }

        return $response;
    }
}