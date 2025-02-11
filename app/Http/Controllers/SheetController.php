<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use App\Models\Reservation;
use App\Models\Movie;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class SheetController extends Controller
{
  public function index()
  {
    $sheets = Sheet::all();
    return view('sheet.index', ['sheets' => $sheets]);
  }

  public function show(Request $request, $movie_id, $schedule_id)
  {
      $date = $request->query('date');
      if(!$date) {
        abort(400);
      }

      $sheets = Sheet::all();

      $reservedSheetIds = Reservation::where('schedule_id', $schedule_id)
      ->where('date', $date)
      ->pluck('sheet_id')
      ->toArray();

      return view('sheet.show', ['sheets' => $sheets, 'movie_id' => $movie_id, 'schedule_id' => $schedule_id, 'date' => $date, 'reservedSheetIds' => $reservedSheetIds]);
  }

  public function create(Request $request, $movie_id, $schedule_id)
  {
    $sheetId = $request->query('sheetId');
    $date = $request->query('date');

    if(!$sheetId || !$date) {
      abort(400);
    }

    $existReservation = Reservation::where('schedule_id', $schedule_id)
    ->where('sheet_id', $sheetId)
    ->exists();
    

    if($existReservation) {
      abort(400);
    }

    $movie = Movie::findOrFail($movie_id);
    $schedule = Schedule::findOrFail($schedule_id);
    $sheet = Sheet::findOrFail($sheetId);
    

    return view('sheet.create', ['movie_id' => $movie_id, 'schedule_id' => $schedule_id, 'sheetId' => $sheetId, 'date' => $date, 'movie' => $movie, 'schedule' => $schedule, 'sheet' => $sheet]);
  }

  public function store(Request $request)
  {
    $request->validate([
      'schedule_id' => 'required',
      'sheet_id' => 'required',
      'name' => 'required',
      'email' => 'required|email:strict,dns',
      'date' => 'required|date_format:Y-m-d'
    ]);
    
    $date = $request->date;

    $existReservation = Reservation::where('schedule_id', $request->schedule_id)
    ->where('sheet_id', $request->sheet_id)
    ->exists();

    

    if($existReservation) {
      return redirect("/movies/{$request->movie_id}/schedules/{$request->schedule_id}/sheets?date={$date}")
      ->with('flash_message', 'その座席はすでに予約済みです');
    }

    $reservation = new Reservation();
    $reservation->date = $date;
    $reservation->schedule_id = $request->schedule_id;
    $reservation->sheet_id = $request->sheet_id;
    $reservation->email = $request->email;
    $reservation->name = $request->name;
    $reservation->save();

    return redirect("/movies/{$request->movie_id}/")
    ->with('flash_message', '予約が完了しました');
  }
}