<?php

namespace App\Actions;

use App\Models\JobApplication;

class StoreJobApplication
{
    public function __invoke(array $data): JobApplication
    {
        $jobApplication = JobApplication::create([
            'email' => $data['email'],
            'name' => $data['name'],
            'phone' => $data['phone'],
            'cover_letter' => $data['coverLetter'],
            'links' => $data['links'],
            'job_id' => $data['jobId'],
        ]);

        if (isset($data['files'])) {
            foreach ($data['files'] as $file) {
                $jobApplication->addMedia($file['file'])
                    ->toMediaCollection('files');
            }
        }

        return $jobApplication;
    }
}
