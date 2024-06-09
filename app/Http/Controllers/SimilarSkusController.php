<?php

namespace App\Http\Controllers;

use App\Cached\CachedSimilarSkus;

class SimilarSkusController extends Controller
{
    public function index($locale, $id)
    {
        return (new CachedSimilarSkus)->get($id);
    }
}
