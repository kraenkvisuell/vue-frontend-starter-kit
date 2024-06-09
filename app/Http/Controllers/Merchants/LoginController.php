<?php

namespace App\Http\Controllers\Merchants;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchants\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::guard('merchants')->check()) {
            $merchant = Auth::guard('merchants')->user();
            $route = $merchant->has_seen_news ? 'order-form' : 'news';

            return redirect()->intended(route('merchants.' . $route));
        }

        return Inertia::render(
            'Merchants/Login',
        );
    }

    public function store(LoginRequest $request)
    {
        if (Auth::guard('merchants')->attempt($request->validated())) {
            return [];
        }

        return response()->json(['message' => __('shop.wrong_credentials')], 401);
    }
}
