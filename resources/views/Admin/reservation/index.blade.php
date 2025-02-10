<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movie</title> 
</head>
<body>
   <h1>予約一覧</h1>
   @foreach($reservations as $reservation)
      <h2>作品名：{{ $reservation->schedule->movie->title }}</h2>
      <p>座席：{{ $reservation->sheet->row}}{{ $reservation->sheet->column }}</p>
      <p>日時：{{ $reservation->date}}</p>
      <p>名前：{{ $reservation->name }}</p>
      <p>メールアドレス：{{ $reservation->email }}</p>
      <button onclick="location.href=`{{ route('reservations.show', ['id' => $reservation->id ]) }}`">編集</button>
    @endforeach
</body>
</html>