<!DOCTYPE html>
<html>
<head>
    <title>{{ $cert->title }}</title>
    <style>
        body { font-family: Arial; text-align: center; padding: 40px; }
        .certificate { border: 2px solid #333; padding: 20px; }
        .title { font-size: 24px; margin-bottom: 20px; }
        .content { font-size: 18px; margin: 20px 0; }
        .signature { margin-top: 40px; }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="title">{{ $cert->title }}</div>
        <div class="content">
            This is to certify that<br>
            <strong>{{ $volunteer->name }}</strong><br>
            has successfully completed the task:<br>
            "{{ $opp->title }}"<br>
            with {{ $org->name }}
        </div>
        <div class="signature">
            {{ $org->name }}<br>
            {{ date('F j, Y') }}
        </div>
    </div>
</body>
</html>