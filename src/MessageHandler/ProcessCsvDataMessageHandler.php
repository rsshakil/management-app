<?php

namespace App\MessageHandler;

use App\Message\ProcessCsvDataMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ProcessCsvDataMessageHandler
{
    public function __invoke(ProcessCsvDataMessage $message)
    {
        // do something with your message
    }
}
