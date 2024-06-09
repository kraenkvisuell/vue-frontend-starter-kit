<?php

namespace Kraenkvisuell\Translatable\Traits;

trait HasTranslatables
{
    public function translate($key, $locale = null): mixed
    {
        $locale = $locale ?: app()->getLocale();
        $fallbackLocale = config('translatable.fallback_for_secondary') ?: 'en';

        if (isset($this->{'localized_'.$key})) {
            if (isset($this->{'localized_'.$key}[$locale]) && $this->{'localized_'.$key}[$locale]) {
                return $this->{'localized_'.$key}[$locale];
            }
            if (isset($this->{'localized_'.$key}[$fallbackLocale]) && $this->{'localized_'.$key}[$fallbackLocale]) {
                return $this->{'localized_'.$key}[$fallbackLocale];
            }
        }

        if (isset($this->{$key}[$locale]) && $this->{$key}[$locale]) {
            return $this->{$key}[$locale];
        }

        if (isset($this->{$key}[$fallbackLocale]) && $this->{$key}[$fallbackLocale]) {
            return $this->{$key}[$fallbackLocale];
        }

        return $this->{$key};
    }
}
