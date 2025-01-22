<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movie</title>
</head>
<body>
      <!-- $movieをつけなかったらエラーになったので調べる。 -->
       <!-- 明示的に必要なデータを送る必要がある -->
      <form method="POST" action="{{ route('movies.update', $movie->id)}}">
        @csrf
        @method('PATCH')
        <div>
            <h1>編集</h1>
            <div>
                <label for="title">映画タイトル</label>
                <input id="title" type="text"
                    name="title" value="{{ $movie->title }}"required>
            </div>

            <div>
                <label for="image_url">画像URL</label>
                <input id="image_url" type="text"
                    name="image_url" value="{{ $movie->image_url }}"required>
            </div>

            <div>
                <label for="published_year">公開年</label>
                <input id="published_year" type="published_year"
                    name="published_year" value="{{ $movie->published_year }}" required>
            </div>

            <div>
                <label for="is_showing">上映中かどうか</label>
                <input type="hidden" name="is_showing" value="0">
                <!-- {{ $movie->is_showing ? 'checked' : '' }}を追加でできる理由を調べる。 -->
                <input id="is_showing" type="checkbox"
                    name="is_showing" value="1" {{ $movie->is_showing ? 'checked' : '' }}>
            </div>

            <div>
                <label for="description">概要</label>
                <textarea id="description" name="description" required>{{ $movie->description }}</textarea>
            </div>

            <div>
                <button type="submit">
                    更新
                </button>
            </div>
        </div>
      </form>    
</body>
</html>