<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Day;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;

class SlotTimeController extends Controller
{
    public function index()
    {
        $weekDays = Day::all();
        return view(
            'admin-views.delivery-slot-time.index',
            compact('weekDays')
        );
    }
    public function list()
    {
        $slots = TimeSlot::all();

        // Define day names for mapping day_id to actual day names
        $days = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        ];

        // Initialize dayWiseSlots to maintain the order of days
        $dayWiseSlots = array_fill_keys(array_values($days), []);

        // Organize slots by day using the $days order
        foreach ($slots as $slot) {
            $dayName = $days[$slot->day_id] ?? 'Unknown'; // Handle undefined day_ids
            if (array_key_exists($dayName, $dayWiseSlots)) {
                $dayWiseSlots[$dayName][] = $slot;
            }
        }

        // Filter out empty days if no slots exist for them
        $dayWiseSlots = array_filter($dayWiseSlots);

        // $weekDays = Day::all();
        return view(
            'admin-views.delivery-slot-time.list',
            compact('dayWiseSlots')
        );
    }
    public function store(Request $request)
    {
        if (isset($request->slots)) {
            $dayId = intval($request->slots['day_id']);

            // Create an array to store converted slots
            $slots = [];

            // Loop through the original data to extract time intervals
            foreach ($request->slots as $key => $interval) {
                if (is_numeric($key)) {
                    // Convert time format from HH:MM to HH:MM
                    $startTime = substr_replace(
                        $interval['start_time'],
                        ':',
                        2,
                        0
                    );
                    $endTime = substr_replace($interval['end_time'], ':', 2, 0);

                    // Create a slot array and add it to the slots array
                    $slot = [
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                    ];
                    $slots[] = $slot;
                }
            }

            // Create the final converted JSON format
            $convertedData = [
                'day_id' => $dayId,
                'slots' => $slots,
            ];

            // 'start_time' => str_replace("::", ":", $slo['start_time']),
            // 'end_time' => str_replace("::", ":", $slo['end_time']),
            // $validatedData = $request->validate([
            //     'day_id' => 'required|exists:days,id',
            //     'slots' => 'required|array',
            //     'slots.*.start_time' => 'required|date_format:H:i',
            //     'slots.*.end_time' => [
            //         'required',
            //         'date_format:H:i',
            //         function ($attribute, $value, $fail) use ($request) {
            //             $index = preg_replace('/[^0-9]/', '', $attribute);
            //             $startTimeInput = str_replace("::", ":", $slots[$index]['start_time']);
            //             $endTimeInput = $value;

            //             $startCarbon = Carbon::createFromFormat('H:i:s', $startTimeInput . ':00');
            //             $endCarbon = Carbon::createFromFormat('H:i:s', $endTimeInput . ':00');

            //             if (!$endCarbon->gt($startCarbon)) {
            //                 $fail('The end time must be strictly after the start time.');
            //             }

            //             // Check for overlapping time slots
            //             $overlaps = TimeSlot::where('day_id', $dayId)
            //                 ->where(function($query) use ($startCarbon, $endCarbon) {
            //                     $query->where(function($q) use ($startCarbon, $endCarbon) {
            //                         $q->where('start_time', '<', $endCarbon)
            //                           ->where('end_time', '>', $startCarbon);
            //                     });
            //                 })
            //                 ->exists();

            //             if ($overlaps) {
            //                 $fail('The time slot overlaps with an existing slot.');
            //             }
            //         },
            //     ],
            // ]);
            foreach ($slots as $slo) {
                TimeSlot::create([
                    'day_id' => $dayId,
                    'start_time' => str_replace('::', ':', $slo['start_time']),
                    'end_time' => str_replace('::', ':', $slo['end_time']),
                ]);
            }
            Toastr::success('Slots added successfully');
            return redirect()->route('admin.slot-lists');
        }
    }

    public function edit($id)
    {
        $slot = TimeSlot::findOrFail($id);
        return view('admin-views.delivery-slot-time.edit', compact('slot'));
    }

    public function destroy($id)
    {
        $slot = TimeSlot::findOrFail($id);
        $slot->delete();
        Toastr::success('Slots Deleted successfully');
        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $slot = TimeSlot::findOrFail($id);
        $slot->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);
        Toastr::success('Slots updated successfully');
        return redirect()
            ->route('admin.slot-lists')
            ->with('success', 'Slot updated successfully.');
    }

}
