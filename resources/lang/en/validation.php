<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'must be accepted.',
    'accepted_if' => 'must be accepted when :other is :value.',
    'active_url' => 'is not a valid URL.',
    'after' => 'must be a date after :date.',
    'after_or_equal' => 'must be a date after or equal to :date.',
    'alpha' => 'must only contain letters.',
    'alpha_dash' => 'must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'must only contain letters and numbers.',
    'array' => 'must be an array.',
    'before' => 'must be a date before :date.',
    'before_or_equal' => 'must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'must be between :min and :max.',
        'file' => 'must be between :min and :max kilobytes.',
        'string' => 'must be between :min and :max characters.',
        'array' => 'must have between :min and :max items.',
    ],
    'boolean' => 'field must be true or false.',
    'confirmed' => 'confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'is not a valid date.',
    'date_equals' => 'must be a date equal to :date.',
    'date_format' => 'does not match the format :format.',
    'declined' => 'must be declined.',
    'declined_if' => 'must be declined when :other is :value.',
    'different' => 'and :other must be different.',
    'digits' => 'must be :digits digits.',
    'digits_between' => 'must be between :min and :max digits.',
    'dimensions' => 'has invalid image dimensions.',
    'distinct' => 'field has a duplicate value.',
    'email' => 'must be a valid email address.',
    'ends_with' => 'must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'must be a file.',
    'filled' => 'field must have a value.',
    'gt' => [
        'numeric' => 'must be greater than :value.',
        'file' => 'must be greater than :value kilobytes.',
        'string' => 'must be greater than :value characters.',
        'array' => 'must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'must be greater than or equal to :value.',
        'file' => 'must be greater than or equal to :value kilobytes.',
        'string' => 'must be greater than or equal to :value characters.',
        'array' => 'must have :value items or more.',
    ],
    'image' => 'must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'field does not exist in :other.',
    'integer' => 'must be an integer.',
    'ip' => 'must be a valid IP address.',
    'ipv4' => 'must be a valid IPv4 address.',
    'ipv6' => 'must be a valid IPv6 address.',
    'json' => 'must be a valid JSON string.',
    'lt' => [
        'numeric' => 'must be less than :value.',
        'file' => 'must be less than :value kilobytes.',
        'string' => 'must be less than :value characters.',
        'array' => 'must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'must be less than or equal to :value.',
        'file' => 'must be less than or equal to :value kilobytes.',
        'string' => 'must be less than or equal to :value characters.',
        'array' => 'must not have more than :value items.',
    ],
    'mac_address' => 'must be a valid MAC address.',
    'max' => [
        'numeric' => 'must not be greater than :max.',
        'file' => 'must not be greater than :max kilobytes.',
        'string' => 'must not be greater than :max characters.',
        'array' => 'must not have more than :max items.',
    ],
    'mimes' => 'must be a file of type: :values.',
    'mimetypes' => 'must be a file of type: :values.',
    'min' => [
        'numeric' => 'must be at least :min.',
        'file' => 'must be at least :min kilobytes.',
        'string' => 'must be at least :min characters.',
        'array' => 'must have at least :min items.',
    ],
    'multiple_of' => 'must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'format is invalid.',
    'numeric' => 'must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'field must be present.',
    'prohibited' => 'field is prohibited.',
    'prohibited_if' => 'field is prohibited when :other is :value.',
    'prohibited_unless' => 'field is prohibited unless :other is in :values.',
    'prohibits' => 'field prohibits :other from being present.',
    'regex' => 'format is invalid.',
    'required' => 'field is required.',
    'required_array_keys' => 'field must contain entries for: :values.',
    'required_if' => 'field is required when :other is :value.',
    'required_unless' => 'field is required unless :other is in :values.',
    'required_with' => 'field is required when :values is present.',
    'required_with_all' => 'field is required when :values are present.',
    'required_without' => 'field is required when :values is not present.',
    'required_without_all' => 'field is required when none of :values are present.',
    'same' => 'and :other must match.',
    'size' => [
        'numeric' => 'must be :size.',
        'file' => 'must be :size kilobytes.',
        'string' => 'must be :size characters.',
        'array' => 'must contain :size items.',
    ],
    'starts_with' => 'must start with one of the following: :values.',
    'string' => 'must be a string.',
    'timezone' => 'must be a valid timezone.',
    'unique' => 'has already been taken.',
    'uploaded' => 'failed to upload.',
    'url' => 'must be a valid URL.',
    'uuid' => 'must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Statamic Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may validation messages for the custom rules provided by Statamic.
    |
    */

    'unique_entry_value' => 'This value has already been taken.',
    'unique_user_value' => 'This value has already been taken.',
    'duplicate_field_handle' => 'Field with a handle of :handle cannot be used more than once.',
    'one_site_without_origin' => 'At least one site must not have an origin.',
    'origin_cannot_be_disabled' => 'Cannot select a disabled origin.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
