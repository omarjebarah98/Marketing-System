<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Campaign Statistics - {{ $campaign->title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width:100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f3f3f3; }
        h1 { font-size: 18px; margin-bottom: 0; }
        .meta { margin-top: 4px; color: #555; }
    </style>
</head>
<body>
    <h1>Campaign Statistics</h1>
    <div class="meta">
        <strong>Title:</strong> {{ $campaign->title }}<br>
        <strong>Template:</strong> {{ optional($campaign->template)->name ?? 'N/A' }}<br>
        <strong>Start:</strong> {{ optional($campaign->start_date)->toDateString() }} &nbsp;
        <strong>End:</strong> {{ optional($campaign->end_date)->toDateString() }}<br>
        <strong>Status:</strong> {{ $campaign->status }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Metric</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Total Sent</td><td>{{ $campaign->sends()->count() }}</td></tr>
            <tr><td>Delivered</td><td>{{ $campaign->sends()->where('status','delivered')->count() }}</td></tr>
            <tr><td>Failed</td><td>{{ $campaign->sends()->where('status','failed')->count() }}</td></tr>
            <tr><td>Open Rate (%)</td><td>{{ $campaign->openRateCalculation() }}</td></tr>
            <tr><td>Click Rate (%)</td><td>{{ $campaign->clickRateCalculation() }}</td></tr>
            <tr><td>Total Cost</td><td>{{ number_format($campaign->sends()->sum('cost'), 2) }}</td></tr>
        </tbody>
    </table>
</body>
</html>
