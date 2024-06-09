<?php

namespace App\View\Components;

use Facades\App\Service\Translations as TranslationsService;
use Illuminate\View\Component;

class Translations extends Component
{
    public $translations = [];

    public function __construct()
    {
        $this->translations = TranslationsService::cachedAll();
    }

    public function render()
    {
        return view('components.translations');
    }
}
