<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogController extends Controller
{
    public function index(): View
    {
        $events = Activity::query()
            ->select('event')
            ->whereNotNull('event')
            ->distinct()
            ->orderBy('event')
            ->pluck('event');

        return view('activity-logs.index', compact('events'));
    }

    public function table(Request $request): JsonResponse
    {
        $activitiesQuery = Activity::query()
            ->with(['causer', 'subject'])
            ->latest();

        $range = $request->get('range');

        if ($range && str_contains($range, ' - ')) {
            [$from, $to] = explode(' - ', $range, 2);
            $request->merge([
                'from' => $from,
                'to' => $to,
            ]);
        }

        if ($request->filled('from')) {
            $activitiesQuery->whereDate('created_at', '>=', $request->get('from'));
        }

        if ($request->filled('to')) {
            $activitiesQuery->whereDate('created_at', '<=', $request->get('to'));
        }

        if ($request->filled('event')) {
            $activitiesQuery->where('event', $request->get('event'));
        }

        if ($request->filled('causer_id')) {
            $activitiesQuery->where('causer_id', $request->get('causer_id'));
        }

        return DataTables::of($activitiesQuery)
            ->addColumn('when', function (Activity $activity) {
                return $activity->created_at->toDateTimeString();
            })
            ->addColumn('subject_label', function (Activity $activity) {
                if (! $activity->subject) {
                    return '-';
                }

                return $activity->subject->name
                    ?? class_basename($activity->subject_type).' #'.$activity->subject_id;
            })
            ->addColumn('causer_label', function (Activity $activity) {
                return $activity->causer?->name ?? '-';
            })
            ->addColumn('properties_json', function (Activity $activity) {
                return json_encode($activity->properties->toArray());
            })
            ->toJson();
    }
}
