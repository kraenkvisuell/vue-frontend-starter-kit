<?php

namespace Kraenkvisuell\HasStatamicFields\Traits;

use Illuminate\Support\Str;

trait IsStatamicEditable
{
    public function isInStatamic(): bool
    {
        return Str::startsWith(request()->path(), config('statamic.cp.route').'/');
    }
}
