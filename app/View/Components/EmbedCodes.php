<?php

namespace App\View\Components;

use App\Cached\CachedGlobals;
use Illuminate\View\Component;
use App\Cached\CachedCookieConsentGroups;

class EmbedCodes extends Component
{
    public $embedCodes = [];

    public function __construct(string $position)
    {

        $globals = (new CachedGlobals)->get();
        $consentGroups = (new CachedCookieConsentGroups)->get();

        $this->embedCodes = collect($globals['website']['embed_codes'] ?? [])
            ->filter(function ($embedCode) use ($position, $consentGroups) {
                $cookieConsentNeeded = '';
                if (count($embedCode['needs_cookie_consent'])) {
                    $cookieConsentNeeded = $embedCode['needs_cookie_consent'][0];
                    if (!$consentGroups->firstWhere('slug', $cookieConsentNeeded)['can_be_deactivated']) {
                        $cookieConsentNeeded = '';
                    }
                }

                $consentedTo = array_filter(explode(',', request()->cookie('has_consented_to')));

                return $embedCode['position']['value'] === $position
                    && (config('app.env') === 'production' || !$embedCode['only_in_production'])
                    && (!$cookieConsentNeeded || in_array($cookieConsentNeeded, $consentedTo));

            })
            ->map(function ($embedCode) {
                return $embedCode['code']['value'];
            });
    }

    public function render()
    {
        return view('components.embed-codes');
    }
}
