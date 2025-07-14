<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    <title>Test</title>
</head>
<body>
<h1>Vous avez sélectionné : {{ $selectNumber }}</h1>
<form>
    @csrf
    <select name="number" onchange="this.form.submit()">
        @for ($i = 15,$iMax = count($computers); $i <= $iMax; $i+=15)
            <option value="{{ $i }}" {{ $selectNumber  ==  $i ? 'selected' : ''}}>{{ $i }}</option>
        @endfor
    </select>
</form>
</body>