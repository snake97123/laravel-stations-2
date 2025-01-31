<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Movie;
use Carbon\CarbonImmutable;

class AdminScheduleController extends Controller
{
    public function index()
    {
        $movies = Movie::with('schedules')->get();
        return view('admin.schedule.index', ['movies' => $movies]);
    }

    public function show($id)
    {
        $schedule = Schedule::find($id);
        return view('admin.schedule.show', ['schedule' => $schedule]);
    }

    public function create($id)
    {
        $movie = Movie::find($id);
        return view('admin.schedule.create', ['movie' => $movie]);
    }

    public function store(Request $request, $id)
    {
        $validatedData = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'start_time_date' => 'required|date_format:Y-m-d',
            'start_time_time' => 'required|date_format:H:i',
            'end_time_date' => 'required|date_format:Y-m-d',
            'end_time_time' => 'required|date_format:H:i',
        ]);

        $start_time = new CarbonImmutable($validatedData['start_time_date'] . ' ' . $validatedData['start_time_time']);
        $end_time = new CarbonImmutable($validatedData['end_time_date'] . ' ' . $validatedData['end_time_time']);


        $schedule = new Schedule();
        $schedule->movie_id = $id;
        $schedule->start_time = $start_time;
        $schedule->end_time = $end_time;
        $schedule->save();

        return redirect()->route('schedules.show', ['id' => $id]);
    }

    public function edit($id)
    {
        $schedule = Schedule::find($id);

        if(!$schedule) {
            abort(404);
        }
        
        return view('admin.schedule.edit', [
            'schedule' => $schedule,
            'start_time_date' => CarbonImmutable::parse($schedule->start_time)->format('Y-m-d'),
            'start_time_time' => CarbonImmutable::parse($schedule->start_time)->format('H:i'),
            'end_time_date' => CarbonImmutable::parse($schedule->end_time)->format('Y-m-d'),
            'end_time_time' => CarbonImmutable::parse($schedule->end_time)->format('H:i'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'start_time_date' => 'required|date_format:Y-m-d',
            'start_time_time' => 'required|date_format:H:i',
            'end_time_date' => 'required|date_format:Y-m-d',
            'end_time_time' => 'required|date_format:H:i',
        ]);

        $start_time = new CarbonImmutable($validatedData['start_time_date'] . ' ' . $validatedData['start_time_time']);
        $end_time = new CarbonImmutable($validatedData['end_time_date'] . ' ' . $validatedData['end_time_time']);

        $schedule = Schedule::find($id);

        if(!$schedule) {
            abort(404);
        }
       

        $schedule->start_time = $start_time;
        $schedule->end_time = $end_time;

        
        $schedule->save();

        return redirect()->route('schedules.index')->with('success', 'スケジュールを更新しました');
    }

    public function delete($id) 
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        return redirect('/admin/schedules')->with('success', 'スケジュールを削除しました');
    }
}