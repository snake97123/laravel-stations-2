<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movie</title> 
</head>
<body>
  <h1>スケジュール作成</h1>
  <form action="{{ route('schedules.store', ['id' => $movie->id])}}" method="POST">
    @csrf
    <label for="start_time_date">開始日付</label>
    <input type="date" name="start_time_date" id="start_time_date" required>
    
    <label for="start_time_time">開始時間</label>
    <input type="time" name="start_time_time" id="start_time_time" required>
    
    <label for="end_time_date">終了日付</label>
    <input type="date" name="end_time_date" id="end_time_date" required>
    
    <label for="end_time_time">終了時間</label>
    <input type="time" name="end_time_time" id="end_time_time" required>

    <label for="screen_id">スクリーン</label>
    <select name="screen_id" id="screen_id">
      @foreach($screens as $screen)
        <option value="{{ $screen->id }}">{{ $screen->name }}</option>
      @endforeach
    </select>
    <button type="submit">作成</button>
  </form>
</body>
</html>