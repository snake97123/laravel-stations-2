<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movie</title>
</head>
<body>
  <h1>スケジュールの編集</h1>
      <form method="POST" action="{{ route('reservations.update', ['id' => $reservation->id]) }}">
      @csrf
      @method('PATCH')

      @csrf
        <div>
          <label>映画作品</label>
          <select name="movie_id">
            <option value="">選択してください</option>
            @foreach($movies as $movie)
              <option value="{{ $movie->id }}" {{ $movie->id == old('movie_id', $reservation->schedule->movie->id ?? '') ? 'selected' : ''}}>{{ $movie->title }}</option>
            @endforeach
          </select>
        </div>
        <div>
              <label>上映スケジュール</label>
              <select name="schedule_id">
                <option value="">選択してください</option>
                @foreach($schedules as $schedule)
                  <option value="{{ $schedule->id }}" {{ $schedule->id == old('schedule_id', $reservation->schedule_id ?? '') ? 'selected' : ''}}>{{ $schedule->start_time }} ~ {{ $schedule->end_time }}</option>
                @endforeach
              </select>
        </div>
        <div>
          <label>座席</label>
          <select name="sheet_id">
            <option value="">選択してください</option>
            @foreach($sheets as $sheet)
              <option value="{{ $sheet->id }}" {{ $sheet->id == old('sheet_id', $reservation->sheet_id ?? '') ? 'selected' : ''}}>{{ $sheet->row }}{{ $sheet->column}}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label>日付</label>
          <input type="date" name="date" value='{{ $date }}' required>
        </div>

          <label for="name">予約者氏名：</label>
          <input id="name" type="text" name="name" value='{{ $reservation->name }}' required>
        </div>

        <div>
          <label for="email">メールアドレス：</label>
          <input id="email" type="email" name="email" value='{{ $reservation->email }}' required>
        </div>

    <button type="submit">更新</button>
  </form>
  <form method="POST" action="{{ route('reservations.destroy', ['id' => $reservation->id]) }}" onsubmit="return confirm('本当に削除しますか？')">
    @csrf
    @method('DELETE')
    <button type="submit">削除</button>
  </form> 
</body>
<script>
  document.addEventListener("DOMContentLoaded", function () {
      const movieSelect = document.querySelector('select[name="movie_id"]');
      const scheduleSelect = document.querySelector('select[name="schedule_id"]');

      movieSelect.addEventListener("change", function () {
          const movieId = this.value;
          scheduleSelect.innerHTML = '<option value="">選択してください</option>';

          if (movieId) {
              fetch(`/admin/reservations/schedules/${movieId}`)
                  .then(response => response.json())
                  .then(data => {
                      data.forEach(schedule => {
                          const startDate = new Date(schedule.start_time).toISOString().split('T')[0]; 
                          const endDate = new Date(schedule.end_time).toISOString().split('T')[0]; 
                          const option = document.createElement("option");
                          option.value = schedule.id;
                          option.textContent = `${startDate} ~ ${endDate}`;
                          scheduleSelect.appendChild(option);
                      });
                  })
                  .catch(error => console.error("エラー:", error));
          }
      });
  });
</script>
</html>