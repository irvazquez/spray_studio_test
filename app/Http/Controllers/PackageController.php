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
        try {
            $validated = $request->validate([
                'no_classes' => 'integer|min:1|required',
                'price' => 'numeric|min:0|required',
                'activity_id' => 'uuid|required'
            ]);
            $packageExist = Package::where([
                ['activity_id', '=', $validated['activity_id']],
                ['no_classes', '=', $validated['no_classes']]
            ])->first();
            if ($packageExist) {
                return response('El paquete ya existe.', 409);
            }
            $package = new Package(['no_classes' => $request['no_classes'], 'price' => $request['price'], 'activity_id' => $activity_id]);
            $package->save();
            return $package;
        } catch (\Exception $e) {
            return response($e->getMessage(), 400);
        }
    }
}
