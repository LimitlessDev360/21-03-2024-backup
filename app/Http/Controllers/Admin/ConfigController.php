<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Day;
use App\Models\TimeSlot;
use Carbon\Carbon;

class ConfigController extends Controller
{

    public function getSlots(Request $request)
    {
        if($request['day_id'] != null){
            $slot = TimeSlot::where('day_id', $request['day_id'])->get();
            return response()->json([
                'status'=> true,
                'message'=> "Slots have been successfully added!",
                'slots'=> $slot
            ]);

        }else{

        $slot = TimeSlot::all();

        return response()->json([
                'status'=> true,
                'message'=> "Slots have been successfully added!",
                'slots'=> $slot
            ]);
        }
        


    }

    public function storeSlots(Request $request)
    {
        $validatedData = $request->validate([
            'day_id' => 'required|exists:days,id',
            'slots' => 'required|array',
            'slots.*.start_time' => 'required|date_format:H:i',
            'slots.*.end_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    $index = preg_replace('/[^0-9]/', '', $attribute);
                    $startTimeInput = $request->input("slots.$index.start_time");
                    $endTimeInput = $value;
    
                    $startCarbon = Carbon::createFromFormat('H:i:s', $startTimeInput . ':00');
                    $endCarbon = Carbon::createFromFormat('H:i:s', $endTimeInput . ':00');
    
                    if (!$endCarbon->gt($startCarbon)) {
                        $fail('The end time must be strictly after the start time.');
                    }
    
                    // Check for overlapping time slots
                    $overlaps = TimeSlot::where('day_id', $request->day_id)
                        ->where(function($query) use ($startCarbon, $endCarbon) {
                            $query->where(function($q) use ($startCarbon, $endCarbon) {
                                $q->where('start_time', '<', $endCarbon)
                                  ->where('end_time', '>', $startCarbon);
                            });
                        })
                        ->exists();
    
                    if ($overlaps) {
                        $fail('The time slot overlaps with an existing slot.');
                    }
                },
            ],
        ]);
    
        foreach ($request->slots as $slot) {
            TimeSlot::create([
                'day_id' => $request->day_id,
                'start_time' => $slot['start_time'],
                'end_time' => $slot['end_time'],
            ]);
        }

        return response()->json([
            'status'=> true,
            'message'=> "Slots have been successfully added!",
        ]);
    
        // return back()->with('success', 'Slots have been successfully added!');
    }

public function updateSlot(Request $request, $slotId)
{
    $request->validate([
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
    ]);

    $slot = TimeSlot::findOrFail($slotId);
    $newStart = Carbon::createFromFormat('H:i:s', $request->start_time . ':00');
    $newEnd = Carbon::createFromFormat('H:i:s', $request->end_time . ':00');

    // Check for overlapping slots excluding the current slot
    $overlap = TimeSlot::where('id', '!=', $slotId)
                        ->where('day_id', $slot->day_id)
                        ->where(function ($query) use ($newStart, $newEnd) {
                            $query->where(function ($q) use ($newStart, $newEnd) {
                                $q->where('start_time', '<', $newEnd)
                                  ->where('end_time', '>', $newStart);
                            });
                        })
                        ->first();

    if ($overlap) {
        // Return with error and possibly show the conflicting slot details
        return back()->with('error', 'The updated time slot overlaps with another slot from ' 
          . $overlap->start_time . ' to ' . $overlap->end_time . '.');
    }

    // Proceed with update if no overlaps
    $slot->start_time = $request->start_time;
    $slot->end_time = $request->end_time;
    $slot->save();
    return response()->json([
        'status'=> true,
        'message'=> "Time slot updated successfully.",
    ]);

    // return back()->with('success', 'Time slot updated successfully.');
    }

    public function deleteSlot(Request $request)
    {
        $slot = TimeSlot::find($request->slot_id);

        if (!$slot) {
            return response()->json(['message' => 'Time slot not found'], 404);
        }

        $slot->delete();

        return response()->json(['message' => 'Time slot deleted successfully'], 200);
    }
}
