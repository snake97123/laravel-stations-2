<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use App\Models\Reservation;
use Illuminate\Http\Request;


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
      return view('sheet.show', ['sheets' => $sheets, 'movie_id' => $movie_id, 'schedule_id' => $schedule_id, 'date' => $date]);
  }

  public function create(Request $request, $movie_id, $schedule_id)
  {
    $sheetId = $request->query('sheetId');
    $date = $request->query('date');

    if(!$sheetId || !$date) {
      abort(400);
    }

    return view('sheet.create', ['movie_id' => $movie_id, 'schedule_id' => $schedule_id, 'sheetId' => $sheetId, 'date' => $date]);
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
    ->first();

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