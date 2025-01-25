<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movie</title> 
</head>
<body>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
  <h1>一覧表示</h1>
      <button onclick="location.href=`{{ route('movies.create') }}`">新規作成</button>
      <table>
        <thead>
          <tr>
            <th scope="col">映画タイトル</th>
            <th scope="col">画像URL</th>
            <th scope="col">公開年</th>
            <th scope="col">上映中かどうか</th>
            <th scope="col">概要</th>
            <th scope="col">ジャンル</th>
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
                  <td>{{ $movie->genre }}</td>
                  <td><button onclick="location.href=`{{ route('movies.edit', ['id' => $movie->id]) }}`">編集</button></td>
                  <td>
                    <form method="POST" action="{{ route('movies.destroy', ['id' => $movie->id]) }}" onsubmit="return confirm('本当に削除しますか？')">
                      @csrf
                      @method('DELETE')
                      <button type="submit">削除</button>
                    </form>
                  </td>
                </tr>
              </tbody>
           </thread>
            @endforeach
      </table>
          
</body>
</html>