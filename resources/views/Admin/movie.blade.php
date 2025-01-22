<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movie</title>
  <h1>一覧表示</h1>
</head>
<body>
      <table>
        <thead>
          <tr>
            <th scope="col">映画タイトル</th>
            <th scope="col">画像URL</th>
            <th scope="col">公開年</th>
            <th scope="col">上映中かどうか</th>
            <th scope="col">概要</th>
          </tr>
        </thead>
           @foreach ($movies as $movie)
              <tbody>
                <tr>
                  <td>{{ $movie->title }}</td>
                  <td>{{ $movie->image_url }}</td>
                  <td>{{ $movie->published_year }}</td>
                  @if ($movie->is_showing === 1)
                    <td>上映中</td>
                  @else
                    <td>上映予定</td>
                  @endif
                  <td>{{ $movie->description }}</td>
                  <td><a href="{{ route('movies.edit', ['id' => $movie->id]) }}">編集</a></td>
                </tr>
              </tbody>
            @endforeach
      </table>
          
</body>
</html>