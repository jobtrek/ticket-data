<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    <title>Test</title>
</head>
<body>
<form action="{{ route('test') }}" method="POST">
    @csrf
    <select name="number" onchange="this.form.submit()">
        @for ($i = 1; $i <= 15; $i++)
                <option value="{{ $i }}" {{ $selectNumber  ==  $i ? 'selected' : ''}}>{{ $i }}</option>
        @endfor
    </select>
</form>
</body>