<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Activity;
use App\Models\Package;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $items = collect($request->items);
        $price = $items->reduce(function ($acc = 0, $item) {
            $activity = Activity::find($item['id'])->with('packages');
            $cost = totalPriceActivity($item);
            return $acc + $cost;
        });

        return $price;
    }

}

function totalPriceActivity($item): int
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

