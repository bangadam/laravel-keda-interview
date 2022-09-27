<?php

namespace App\Repositories\Message;

interface IMessageRepository
{
    public function getMyMessages($request): array;
    public function doSendMessage($request): bool;
}
