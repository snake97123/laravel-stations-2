<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movie</title>
</head>
<body>
<h1>座席配置</h1>
<table>
        <thead>
          <tr>
            <th scope="col">・</th>
            <th scope="col">・</th>
            <th scope="col">スクリーン</th>
            <th scope="col">・</th>
            <th scope="col">・</th>
          </tr>
        </thead>
           @php
              $groupedSheets = $sheets->groupBy('row');
           @endphp
           <tbody>
      @foreach ($groupedSheets as $rowSheets)
        <tr>
          @foreach ($rowSheets as $sheet)
            <td>
              @if(in_array($sheet->id, $reservedSheetIds))
              <div class="reserved">
                <span>{{ $sheet->row }}-{{ $sheet->column }}</span>
                </div>
              @else
              <a href="/movies/{{ $movie_id }}/schedules/{{ $schedule_id }}/reservations/create?date={{ $date }}&sheetId={{ $sheet->id }}">
                {{ $sheet->row }}-{{ $sheet->column }}
              </a>
              @endif
            </td>
          @endforeach
        </tr>
      @endforeach
    </tbody>
      </table>
</body>
</html>