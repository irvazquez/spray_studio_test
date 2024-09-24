<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'items.*.id' => 'uuid|required',
                'items.*.noClasses' => 'integer|min:1|required'
            ], [
                'id' => [
                    'uuid' => 'Uno o más Ids ingresados no son válidos',
                    'requried' => 'Se requiere que todos los articulos cuenten con un Id válido'
                ],
                [
                    'noClasses' => [
                        'integer' => 'El número de clases debe de ser un número entero positivo',
                        'required' => 'Se necesita ingresar un numero de clases por cada actividad'
                    ]
                ]
            ]);
    
            $items = collect($validated['items']);
            $price = $items->reduce(function ($acc = 0, $item) {
                Activity::find($item['id'])->with('packages');
                $cost = totalPriceActivity($item);
                return $acc + $cost;
            });
    
            return $price;
        } catch (\Exception $e) {
            return response($e->getMessage(), 400);
        }
    }

}

function totalPriceActivity($item): float
{
    $totalPrice = 0;
    $requiredClasses = $item['noClasses'];
    $activity = Activity::where('id', $item['id'])->first();
    $packages = $activity->packages;
    $noClasses = $packages->map(function ($package) {
        return $package->no_classes;
    })->sort()->reverse();
    while ($requiredClasses !== 0) {
        if($requiredClasses <= $noClasses->min()) {
            $totalPrice += $packages->where('no_classes', $noClasses->min())->first()->price;
            $requiredClasses = 0;
        }
        if ($noClasses->contains($requiredClasses)) {
            $totalPrice += $packages->where('no_classes', $requiredClasses)->first()->price;
            $requiredClasses = 0;
        }
        foreach ($noClasses as $noClass) {
            if ($noClass <  $requiredClasses) {
                $totalPrice += $packages->where('no_classes', $noClass)->first()->price;
                $requiredClasses -= $noClass;
                break;
            }
        }
    }
    return $totalPrice;
}

