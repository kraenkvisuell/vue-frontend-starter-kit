<?php

namespace App\Http\Controllers;

use App\Cached\CachedMatchingSkus;

class MatchingSkusController extends Controller
{
    public function index($locale, $id)
    {
        return (new CachedMatchingSkus)->get($id);
    }
}
