<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function findAll(): View
    {
        $activities = Activity::with('packages')->get();
        $packages = new Collection();   
        foreach ($activities as $activity) {
            foreach ($activity->packages as $package) {
                if (!$packages->contains($package->no_classes))
                {
                    $packages->push($package->no_classes);
                }
            }
        }
        $noClasses = $packages->sort();
        return view('activities.index', compact('activities', 'noClasses'));
    }

    public function create(Request $request)
    {
        $activity = new Activity(['name' => $request['name']]);
        $activity->save();
        $activity->packages()->create(['no_classes' => $request['no_classes'], 'price' => $request['price'], 'activity_id' => $activity->id]);
        return redirect()->route('activities.all');
    }
}
