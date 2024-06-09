<?php

namespace App\Http\Controllers;

use App\Actions\SendJobApplication;
use App\Actions\StoreJobApplication;
use App\Notifications\SkuIsAvailableAgain;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\JobApplicationsRequest;

class JobApplicationsController extends Controller
{
    public function store(JobApplicationsRequest $request, StoreJobApplication $store, SendJobApplication $send)
    {
        $jobApplication = $store(data: $request->validated());

        $send($jobApplication->fresh());

        return [
            'success' => true,
        ];
    }
}
