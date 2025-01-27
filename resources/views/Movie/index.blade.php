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
<h1>一覧表示</h1>
  <form method="GET" action="{{ route('movies.index') }}">
        <input type="text" name="keyword">
        <input type="radio" name="is_showing" value="" {{ old("is_showing", "") == "" ? "checked": ""}}>すべて
        <input type="radio" name="is_showing" value="1">公開中
        <input type="radio" name="is_showing" value="0">公開予定
        <button type="submit">検索</button>
      </form>
      <form method="GET" action="{{ route('movies.create') }}">
  <ul>
    @foreach ($movies as $movie)
      <li>タイトル：{{ $movie->title }}</li>
      <li>{{ $movie->image_url }}</li>
    @endforeach
  </ul>
  <div id="pagination">
    {{ $movies->links() }}
  </div>
</body>
</html>