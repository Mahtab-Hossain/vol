<!DOCTYPE html>
<html>
<head>
    <title>{{ $cert->title }}</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .cert { border: 2px solid #4f46e5; padding: 50px; margin: 50px; border-radius: 10px; }
        .logo { font-size: 3rem; color: #4f46e5; }
    </style>
</head>
<body>
    <div class="cert">
        <h1 class="logo">🏆</h1>
        <h2>{{ $cert->title }}</h2>
        <p>{{ $cert->message }}</p>
        <p>Awarded to: {{ $user->name }}</p>
        <p>For: {{ $opp->title }}</p>
        <p>Organization: {{ $cert->organization->name }}</p>
        <p>Date: {{ now()->format('F d, Y') }}</p>
        <hr>
        <p>Thank you for making a difference!</p>
    </div>
</body>
</html>