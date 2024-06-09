<?php

namespace App\Http\Controllers;

use App\Models\AvailabilityReminder;
use App\Http\Requests\MessageWhenAvailableRequest;

class MessageWhenAvailableController
{
    public function store(MessageWhenAvailableRequest $request)
    {
        AvailabilityReminder::updateOrCreate([
            'email' => $request->email,
            'sku_number' => $request->slug,
            'site' => config('app.current_site'),
            'locale' => $request->get('locale'),
            'notified_at' => null,
        ], ['updated_at' => now()]);

        return [];
    }
}
