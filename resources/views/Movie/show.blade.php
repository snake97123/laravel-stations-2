<!DOCTYPE html>
<html lang="en">
<head>
  <!-- cssファイルの取り込み -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movie</title>
</head>
<body>
    <h1>詳細表示</h1>
    <p>タイトル：{{ $movie->title }}</p>
    <img src="{{ $movie->image_url }}" alt="">
    <p>公開年:{{ $movie->published_year}}</p>
    @if ($movie->is_showing === 1)
        <p>上映中</p>
    @else
        <p>上映予定</p>
    @endif
    <p>概要：{{ $movie->description }}</p>
    <p>ジャンル：{{ $movie->genre_name }}</p>
    @foreach ($schedules as $schedule)
        <p>開始時間：{{ $schedule->start_time->format('H:i') }}</p>
        <p>終了時間：{{ $schedule->end_time->format('H:i') }}</p>
    @endforeach
</body>
</html>