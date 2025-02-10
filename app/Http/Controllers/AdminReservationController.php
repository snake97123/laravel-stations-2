<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Reservation;
use App\Models\Schedule;
use App\Models\Sheet;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class AdminReservationController extends Controller 
{
    public function index()
    {
      
      $reservations = Reservation::with(['schedule.movie', 'sheet'])
          ->whereHas('schedule', function($query) {
          $query->where('start_time', '>=', CarbonImmutable::now());
        })
        ->get();

      return view('admin.reservation.index', ['reservations' => $reservations]);
    }

    public function create()
    {
      $movies = Movie::all();
      $schedules = Schedule::where('start_time', '>=', CarbonImmutable::now())->get();
      $sheets = Sheet::all(); 
      $date = CarbonImmutable::now()->format('Y-m-d');
      return view('admin.reservation.create', ['movies' => $movies, 'schedules' => $schedules, 'sheets' => $sheets, 'date' => $date]);
    }

    public function getSchedules($movie_id)
    {
        $schedules = Schedule::where('movie_id', $movie_id)
                            ->where('start_time', '>=', CarbonImmutable::now())
                            ->get();

        return response()->json($schedules);
    }


    public function store(Request $request)
    {
       $request->validate([
        'movie_id' => 'required',
        'schedule_id' => 'required',
        'sheet_id' => 'required',
        'name' => 'required',
        'email' => 'required|email:strict,dns',
        // 'date' => 'required|date_format:Y-m-d'
       ]);
       

        $existReservation = Reservation::where('schedule_id', $request->schedule_id)
                                        ->where('sheet_id', $request->sheet_id)
                                        ->exists();

        if($existReservation) {
          return redirect("/admin/reservations/")
          ->with('flash_message', 'その座席はすでに予約済みです');
      }

      $reservation = new Reservation();
      $reservation->date = $request->date;
      $reservation->schedule_id = $request->schedule_id;
      $reservation->sheet_id = $request->sheet_id;
      $reservation->email = $request->email;
      $reservation->name = $request->name;
      $reservation->save();
      return redirect("/admin/reservations/")
      ->with('flash_message', '予約が完了しました');
    }

    public function show($id)
    {
      $reservation = Reservation::with(['schedule.movie', 'sheet'])->find($id);
      $movies = Movie::all();
      $schedules = Schedule::where('start_time', '>=', CarbonImmutable::now())->get();
      $sheets = Sheet::all(); 
      $date = CarbonImmutable::now()->format('Y-m-d');
      return view('admin.reservation.show', ['reservation' => $reservation, 'movies' => $movies, 'schedules' => $schedules, 'sheets' => $sheets, 'date' => $date]);
    }

    public function update(Request $request, $id)
    {
      $request->validate([
        'movie_id' => 'required',
        'schedule_id' => 'required',
        'sheet_id' => 'required',
        'name' => 'required',
        'email' => 'required|email:strict,dns',
        // 'date' => 'required|date_format:Y-m-d'
       ]);         
        $existReservation = Reservation::where('schedule_id', $request->schedule_id)
                                        ->where('sheet_id', $request->sheet_id)
                                        ->exists();

        if($existReservation) {
          return redirect("/admin/reservations/")
          ->with('flash_message', 'その座席はすでに予約済みです');
      }

      $reservation = Reservation::findOrFail($id);
      $reservation->date = $request->date;
      $reservation->schedule_id = $request->schedule_id;
      $reservation->sheet_id = $request->sheet_id;
      $reservation->email = $request->email;
      $reservation->name = $request->name;
      $reservation->save();
      return redirect("/admin/reservations/")
      ->with('flash_message', '予約を更新しました');
    }

    public function delete($id)
    {
      $reservation = Reservation::findOrFail($id);
      $reservation->delete();
      return redirect("/admin/reservations/")
      ->with('flash_message', '予約をキャンセルしました');
    }
}