<?php

use Inertia\Testing\AssertableInertia as Assert;

it('renders home page', function () {
    $this->get('/')
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page->component('Page'));
});

it('renders test page', function () {
    $this->get('/de/test')
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page->component('Page'));
});

it('renders shop page', function () {
    $this->get('/de/shop')
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page->component('Shop'));
});
