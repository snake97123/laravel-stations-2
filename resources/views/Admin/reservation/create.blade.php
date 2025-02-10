<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movie</title> 
</head>
<body>
<body>
      <h1>座席予約</h1>
      <form method="POST" action="{{ route('admin.reservations.store') }}">
        @csrf
        <div>
          <label>映画作品</label>
          <select name="movie_id">
            <option value="">選択してください</option>
            @foreach($movies as $movie)
              <option value="{{ $movie->id }}">{{ $movie->title }}</option>
            @endforeach
          </select>
        </div>
        <div>
              <label>上映スケジュール</label>
              <select name="schedule_id">
                <option value="">選択してください</option>
                @foreach($schedules as $schedule)
                  <option value="{{ $schedule->id }}">{{ $schedule->start_time }} ~ {{ $schedule->end_time }}</option>
                @endforeach
              </select>
        </div>
        <div>
          <label>座席</label>
          <select name="sheet_id">
            <option value="">選択してください</option>
            @foreach($sheets as $sheet)
              <option value="{{ $sheet->id }}">{{ $sheet->row }}{{ $sheet->column}}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label>日付</label>
          <input type="date" name="date" value='{{ $date }}' required>
        </div>

          <label for="name">予約者氏名：</label>
          <input id="name" type="text" name="name" required>
        </div>

        <div>
          <label for="email">メールアドレス：</label>
          <input id="email" type="email" name="email" required>
        </div>

        <div>
          <button type="submit">
              予約を確定する
          </button>
        </div>
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