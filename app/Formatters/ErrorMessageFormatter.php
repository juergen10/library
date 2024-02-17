<?php

namespace App\Formatters;

use Illuminate\Support\MessageBag;

class ErrorMessageFormatter
{
    public static function format(MessageBag $errors)
    {
        $messages = [];

        $errors = $errors->toArray();

        foreach ($errors as $field => $validations) {
            $messages[] = ['field' => $field, 'error' => $validations[0]];
        }

        return $messages;
    }
}
