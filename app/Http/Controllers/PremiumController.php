<?php

namespace App\Http\Controllers;

use Osiset\ShopifyApp\Util;
use Illuminate\Http\Request;
use Osiset\ShopifyApp\Storage\Models\Plan;

class PremiumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json(['hasPremium' => $request->user()->plan?->price > 0]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $shop = $request->user();

        if ($shop->plan?->price > 0) {
            return response()->json();
        }

        $planId = Plan::where('price', '>', 0)->first()?->id;

        if (! $planId) {
            throw new \RuntimeException('No premium plan found');
        }

        $redirectUrl = route(
            Util::getShopifyConfig('route_names.billing'),
            [
                'shop' => $shop->getDomain()->toNative(),
                'host' => $request->get('host'),
                'plan' => $planId,
            ]
        );

        return response()->json(['redirectUrl' => $redirectUrl]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $shop = $request->user();

        if ($shop->plan?->price <= 0) {
            return response()->json();
        }

        $redirectUrl = route(
            Util::getShopifyConfig('route_names.billing'),
            [
                'shop' => $shop->getDomain()->toNative(),
                'host' => $request->get('host'),
            ]
        );

        return response()->json(['redirectUrl' => $redirectUrl]);
    }
}
