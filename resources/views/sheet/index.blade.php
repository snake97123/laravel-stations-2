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
           @foreach ($groupedSheets as $sheets)
              <tbody>
                <tr>
                  @foreach ($sheets as $sheet)
                    <td>{{ $sheet->row }}-{{ $sheet->column }}</td>
                  @endforeach
                </tr>
                @endforeach
              </tbody>
      </table>
</body>
</html>