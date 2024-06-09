<?php

namespace App\Actions\Merchants;

use App\Models\Merchant;

class UpdateAccount
{
    public function __invoke(Merchant $merchant, array $data): void
    {
        $updateData = [];

        if ($data['password']) {
            $updateData['password'] = bcrypt($data['password']);
        }

        $merchant->update($updateData);
    }
}
