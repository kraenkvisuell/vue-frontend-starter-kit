<?php

namespace App\Notifications;

use App\Models\Sku;
use App\Models\JobApplication;
use Statamic\Facades\GlobalSet;
use App\Service\GlobalsCacheService;
use Illuminate\Bus\Queueable;
use App\Models\AvailabilityReminder;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SomeoneAppliedForJob extends Notification
{
    use Queueable;

    public $jobApplication;

    public function __construct(JobApplication $jobApplication)
    {
        $this->jobApplication = $jobApplication;
        $this->queue = 'notifications';
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {

        return (new MailMessage)
            ->subject('Jobanfrage: ' . $this->jobApplication->job?->title)
            ->markdown('mail.someone-applied-for-job', [
                'jobApplication' => $this->jobApplication,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'job_application_id' => $this->jobApplication->id,
            'recipients' => GlobalSet::findByHandle('jobs')->in($this->jobApplication->site)
                ->get('job_application_recipients'),
        ];
    }
}
