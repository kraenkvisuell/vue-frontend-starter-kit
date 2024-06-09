<?php

namespace App\Actions;

class AddFlashMessage
{
    public function __invoke(string $message)
    {
        $messages = session('flashMessages') ?: [];
        $messages[] = $message;
        request()->session()->flash('flashMessages', $messages);
    }
}
