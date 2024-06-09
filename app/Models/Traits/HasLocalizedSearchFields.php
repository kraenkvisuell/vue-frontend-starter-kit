<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\App;

trait HasLocalizedSearchFields
{
    public function getLocalizedFields(array $localizedFields): array
    {
        $fields = [];

        $cachedLanguage = App::getLocale();

        foreach ($localizedFields as $localizedField) {
            $arr = [];

            foreach (config('translatable.languages') as $language => $params) {
                App::setLocale($language);

                if (is_array($this->{$localizedField})) {
                    foreach ($this->{$localizedField} as $value) {
                        if (is_string($value)) {
                            $arr[] = strip_tags($value);
                        }
                    }
                } else {
                    $arr[] = strip_tags($this->{$localizedField});
                }
            }

            $fields[$localizedField] = trim(str_replace('[]', '', implode(' ', array_unique($arr))));
        }
        App::setLocale($cachedLanguage);

        return $fields;
    }
}
