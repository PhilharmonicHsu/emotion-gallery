<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Analyzer</title>
</head>
<body>
<h1>Upload an Image</h1>
<form action="{{ route('image.analyze') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" required>
    <button type="submit">Analyze Image</button>
</form>

@if (session('labels'))
    <h2>Analysis Results:</h2>
    <ul>
        @foreach (session('labels') as $label)
            <li>{{ $label }}</li>
        @endforeach
    </ul>
@endif
</body>
</html>
