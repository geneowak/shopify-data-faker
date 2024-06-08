<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\GenerateFakeData;
use App\Jobs\DeleteFakeProducts;

class FakeDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'productsCount' => [
                'integer', 'min:0', 'max:100',
                function (string $attribute, mixed $value, \Closure $fail) use ($request) {
                    if ($value <= 0 && $request->get('customersCount') <= 0) {
                        $fail('Slide either number of products or customers to at least 5 to proceed');
                    }
                },
            ],
            'customersCount' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);

        GenerateFakeData::dispatch($request->user(), $data['productsCount'], $data['customersCount']);

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DeleteFakeProducts::dispatch($request->user());

        return response()->noContent();
    }
}
