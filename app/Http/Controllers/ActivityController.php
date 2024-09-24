<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function findAll()
    {
        $activities = Activity::with('packages')->get();
        return $activities;
    }

    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'string|required|min:2',
                'no_classes' => 'integer|min:1|required',
                'price' => 'number|min:0|required'
            ]);
            $activity = new Activity(['name' => $validated['name']]);
            $activity->save();
            $activity
                ->packages()
                ->create([
                    'no_classes' => $validated['no_classes'],
                    'price' => $validated['price'],
                    'activity_id' => $activity->id
                ]);
            return $activity;
        } catch (\Exception $e) {
            return response($e->getMessage(), 400);
        }
    }
}
