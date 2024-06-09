<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class)->beforeEach(function () {
    $this->withoutExceptionHandling();
    Storage::fake(config('statamic.search.indexes.default.driver'));
    $this->artisan('db:seed', ['--class' => 'StatamicTestSeeder']);
})->in('Feature');
