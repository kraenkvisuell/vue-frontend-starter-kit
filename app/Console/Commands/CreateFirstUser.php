<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\User;

class CreateFirstUser extends Command
{
    protected $signature = 'shop:create-first-user';

    public function handle()
    {
        $user = User::make()
            ->email('cms@kraenk.de')
            ->data([
                'name' => 'cms',
                'password' => 'Lilien1898',
            ]);

        $user->makeSuper()
            ->save();

        $this->info('done creating first user.');
    }
}
