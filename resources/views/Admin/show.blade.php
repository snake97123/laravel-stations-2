<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movie</title> 
</head>
<body>
  <h1>映画詳細</h1>
  <p>映画タイトル: {{ $movie->title }}</p>
  <p>画像URL: {{ $movie->image_url }}</p>
  <p>公開年: {{ $movie->published_year }}</p>
  @if ($movie->is_showing === 1)
    <p>上映中</p>
  @else
    <p>上映予定</p>
  @endif
  <p>概要: {{ $movie->description }}</p>
  <p>ジャンル: {{ $movie->genre }}</p>
  <p>スケジュール</p>
  <ul>
  @foreach ($schedules as $schedule)
  <li>
  <a href="{{ route('admin.movies.show', ['id' => $movie->id]) }}">{{ $schedule->start_time}} ~ {{ $schedule->end_time}}</a>
  </li>
  @endforeach
  </ul>
</body>
</html>