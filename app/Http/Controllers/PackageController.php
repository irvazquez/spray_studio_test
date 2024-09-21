<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Package;

class PackageController extends Controller
{
    public function findAllForActivity(string $activity_id): View
    {
        $packages = Package::where('activity_id', $activity_id)->get();
        return view('packages.activity', compact('packages', 'activity_id'));
    }

    public function create(Request $request, string $activity_id)
    {
        $package = new Package(['no_classes' => $request['no_classes'], 'price' => $request['price'], 'activity_id' => $activity_id]);
        $package->save();
        return redirect()->route('packages.activity', $activity_id);
    }
}
