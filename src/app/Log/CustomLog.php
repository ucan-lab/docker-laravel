<?php

namespace App\Log;

use Illuminate\Support\Facades\Log;

class CustomLog extends Log
{
    /**
     * エラーメソッドのラッパー
     * @param string $message
     * @param array $context
     */
    public static function error(string $message, array $context = []): void
    {
        parent::error($message, $context);
    }
}