<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Movie;
use App\Models\Screen;
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
        $screens = Screen::all();
        return view('admin.schedule.create', ['movie' => $movie, 'screens' => $screens]);   
    }

    public function store(Request $request, $id)
    {
        $validatedData = $request->validate([
            'screen_id' => ['required', 'exists:screens,id',
            function($attribute, $value, $fail) {
                $start_time = new CarbonImmutable(request()->input('start_time_date') . ' ' . request()->input('start_time_time'));
                $end_time = new CarbonImmutable(request()->input('end_time_date') . ' ' . request()->input('end_time_time'));
                $screen_id = request()->input('screen_id');
                $duplicateData = Schedule::where('screen_id', $screen_id)
                    ->where(function($query) use ($start_time, $end_time) {
                        $query->whereBetween('start_time', [$start_time, $end_time])
                            ->orWhereBetween('end_time', [$start_time, $end_time]);
                    })
                    ->exists();
                if($duplicateData) {
                    $fail('指定されたスクリーンはすでにその時間帯に予約されています');
                }
            }],
            'start_time_date' => ['required', 'date_format:Y-m-d', 'before_or_equal:end_time_date'],
            'start_time_time' => ['required', 'date_format:H:i', 'before:end_time_time',
            function ($attribute, $value, $fail) use ($request) {
                $start_time = CarbonImmutable::createFromFormat('H:i', str_replace(['時', '分'], [':', ''], request()->input('start_time_time')));
                $end_time = CarbonImmutable::createFromFormat('H:i', str_replace(['時', '分'], [':', ''], request()->input('end_time_time')));
                if($start_time->diffInMinutes($end_time) < 6) {
                    $fail('開始時刻と終了時刻の差は6分以上にしてください');
                }
            }],
            'end_time_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_time_date'],
            'end_time_time' => ['required', 'date_format:H:i', 'after:start_time_time',
            function ($attribute, $value, $fail) {
                $start_time = CarbonImmutable::createFromFormat('H:i', str_replace(['時', '分'], [':', ''], request()->input('start_time_time')));
                $end_time = CarbonImmutable::createFromFormat('H:i', str_replace(['時', '分'], [':', ''], request()->input('end_time_time')));
                if($start_time->diffInMinutes($end_time) < 6) {
                    $fail('開始時刻と終了時刻の差は6分以上にしてください');
                }
            }],
        ]);
    

       
        $start_time = new CarbonImmutable($validatedData['start_time_date'] . ' ' . $validatedData['start_time_time']);
        $end_time = new CarbonImmutable($validatedData['end_time_date'] . ' ' . $validatedData['end_time_time']);
        $screen_id = $validatedData['screen_id'];

        // $duplicateData = Schedule::where('screen_id', $screen_id)
        //     ->where(function($query) use ($start_time, $end_time) {
        //         $query->whereBetween('start_time', [$start_time, $end_time])
        //             ->orWhereBetween('end_time', [$start_time, $end_time]);
        //     })
        //     ->exists();
        
        // if($duplicateData) {
        //     return redirect("/admin/movies/{$id}/schedules/create")->with('error', '指定されたスクリーンはすでにその時間帯に予約されています');
        // }

        $schedule = new Schedule();
        $schedule->movie_id = $id;
        $schedule->start_time = $start_time;
        $schedule->end_time = $end_time;
        $schedule->screen_id = $screen_id;
        $schedule->save();

        return redirect()->route('admin.movies.show', ['id' => $id]);
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
            'movie_id' => ['required', 'exists:movies,id'],
            'start_time_date' => ['required', 'date_format:Y-m-d', 'before_or_equal:end_time_date'],
            'start_time_time' => ['required', 'date_format:H:i', 'before:end_time_time',
            function ($attribute, $value, $fail) {
                $start_time = CarbonImmutable::createFromFormat('H:i', str_replace(['時', '分'], [':', ''], request()->input('start_time_time')));
                $end_time = CarbonImmutable::createFromFormat('H:i', str_replace(['時', '分'], [':', ''], request()->input('end_time_time')));
                if($start_time->diffInMinutes($end_time) < 6) {
                    $fail('開始時刻と終了時刻の差は6分以上にしてください');
                }
            }],
            'end_time_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_time_date'],
            'end_time_time' => ['required', 'date_format:H:i', 'after:start_time_time',
            function ($attribute, $value, $fail) {
                $start_time = CarbonImmutable::createFromFormat('H:i', str_replace(['時', '分'], [':', ''], request()->input('start_time_time')));
                $end_time = CarbonImmutable::createFromFormat('H:i', str_replace(['時', '分'], [':', ''], request()->input('end_time_time')));
                if($start_time->diffInMinutes($end_time) < 6) {
                    $fail('開始時刻と終了時刻の差は6分以上にしてください');
                }
            }],
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