<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movie</title>
</head>
<body>
      <h1>座席予約</h1>
      <form method="POST" action="{{ route('reservations.store') }}">
        @csrf
        <div>
          <label>映画作品：</label>
          <span>{{ $movie->title }}</span>
          <input type="hidden" name="movie_id" value="{{ $movie_id }}">
        </div>

        <div>
          <label>上映スケジュール：</label>
          <span>{{ $schedule->start_time->format('Y-m-d') }}~{{ $schedule->end_time->format('Y-m-d') }}</span>
          <input type="hidden" name="schedule_id" value="{{ $schedule_id }}">
        </div>

        <div>
          <label>座席：</label>
          <span>{{ $sheet->row }}{{ $sheet->column }}</span>
          <input type="hidden" name="sheet_id" value="{{ $sheetId }}">
        </div>

        <div>
          <label>日付:</label>
          <span> {{ $date }}</span>
          <input type="hidden" name="date" value="{{ $date }}">
        </div>

        <div>
          <label for="name">予約者氏名：</label>
          <input id="name" type="text" name="name" required>
        </div>

        <div>
          <label for="email">メールアドレス：</label>
          <input id="email" type="email" name="email" required>
        </div>

        <div>
          <button type="submit">
              予約を確定する
          </button>
        </div>
      </form>  
</body>
</html>
