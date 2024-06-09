<?php

namespace App\Actions;

use Statamic\Facades\GlobalSet;

class SeedStatamicGlobals
{
    public function __invoke(): void
    {
        $globals = GlobalSet::make('mails')->title('E-Mails');
        $variables = $globals->makeLocalization('default');

        $variables->data([
            'internal_order_recipients' => 'foo@bar.io, bar@foo.io',
        ]);

        $globals->addLocalization($variables);
        $globals->save();
    }
}
