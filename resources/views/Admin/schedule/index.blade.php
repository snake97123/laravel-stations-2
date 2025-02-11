<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movie</title> 
</head>
<body>
   <h1>スケジュール一覧</h1>

   @foreach($movies as $movie)
      <h2>{{ $movie->title }}</h2>
      @if($movie->schedules->isNotEmpty())
        @foreach($movie->schedules as $schedule)
          <a href="{{ route('admin.movies.show', ['id' => $schedule->id]) }}">
        {{ $schedule->start_time }} ~ {{ $schedule->end_time }}
          </a>
          <form method="POST" action="{{ route('schedules.destroy', ['id' => $schedule->id]) }}" onsubmit="return confirm('本当に削除しますか？')">
                      @csrf
                      @method('DELETE')
                      <button type="submit">削除</button>
          </form>
        @endforeach
      @endif
    @endforeach
</body>
</html>