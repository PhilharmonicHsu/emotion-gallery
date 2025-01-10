<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Analysis</title>
</head>
<body>
<h1>Text Analysis</h1>
<form action="{{ route('text.analyze') }}" method="POST">
    @csrf
    <label for="text">Enter your text:</label><br>
    <textarea name="text" id="text" rows="5" cols="50" required></textarea><br>
    <button type="submit">Analyze Text</button>
</form>

@if (session('analysis'))
    <h2>Analysis Results:</h2>
    <h3>Sentiment:</h3>
    <p>Score: {{ session('analysis')['sentiment']['score'] }}</p>
    <p>Magnitude: {{ session('analysis')['sentiment']['magnitude'] }}</p>

    <h3>Entities:</h3>
    <ul>
        @foreach (session('analysis')['entities'] as $entity)
            <li>{{ $entity['name'] }} (Type: {{ $entity['type'] }}, Salience: {{ $entity['salience'] }})</li>
        @endforeach
    </ul>
@endif
</body>
</html>
