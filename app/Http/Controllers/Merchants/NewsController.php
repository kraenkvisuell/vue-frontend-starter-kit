<?php

namespace App\Http\Controllers\Merchants;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function index()
    {
        $merchant = Auth::guard('merchants')->user();
        $merchant->update(['has_seen_news' => true]);

        return Inertia::render(
            'Merchants/News',
        );
    }
}
