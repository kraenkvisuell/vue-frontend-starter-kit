<?php

namespace App\Actions;

use App\Models\JobApplication;
use Statamic\Facades\GlobalSet;
use App\Notifications\SomeoneAppliedForJob;
use Illuminate\Support\Facades\Notification;

class SendJobApplication
{
    public function __invoke(JobApplication $jobApplication): void
    {
        $recipients = GlobalSet::findByHandle('jobs')->in($jobApplication->site)->get('job_application_recipients');
        $recipients = array_map('trim', explode(',', $recipients));

        foreach ($recipients as $recipient) {
            Notification::route('mail', $recipient)
                ->notify(new SomeoneAppliedForJob($jobApplication));
        }
    }
}
