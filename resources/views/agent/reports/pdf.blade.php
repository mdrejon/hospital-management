<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Income Report</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 24px; color: #2d3748; }
        .header p { margin: 5px 0; color: #718096; }
        .agent-info { margin-bottom: 20px; }
        .agent-info table { width: 100%; border: none; }
        .agent-info td { padding: 3px 0; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #e2e8f0; padding: 10px; text-align: left; }
        .table th { background-color: #f7fafc; font-weight: bold; color: #4a5568; text-transform: uppercase; font-size: 10px; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .total-row td { background-color: #f7fafc; font-size: 14px; }
        .footer { text-align: center; margin-top: 40px; font-size: 10px; color: #a0aec0; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Agent Income Report</h1>
        <p>Report Period: <strong>{{ $filterLabel }}</strong></p>
    </div>

    <div class="agent-info">
        <table>
            <tr>
                <td><strong>Agent Name:</strong> {{ $agent->user->name ?? 'N/A' }}</td>
                <td class="text-right"><strong>Generated On:</strong> {{ \Carbon\Carbon::now()->format('d M Y, h:i A') }}</td>
            </tr>
            <tr>
                <td><strong>Agent Code:</strong> {{ $agent->code ?? 'N/A' }}</td>
                <td class="text-right"><strong>Phone:</strong> {{ $agent->phone ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Source Type</th>
                <th>Reference</th>
                <th class="text-right">Amount (BDT)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($commissions as $comm)
                <tr>
                    <td>{{ $comm->created_at->format('d M Y') }}</td>
                    <td style="text-transform: capitalize;">{{ str_replace('_', ' ', $comm->source_type) }}</td>
                    <td>{{ $comm->booking_reference }}</td>
                    <td class="text-right">{{ number_format($comm->amount, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px; color: #a0aec0;">No income records found for this period.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" class="text-right font-bold">Total Filtered Income:</td>
                <td class="text-right font-bold">{{ number_format($total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        This is a computer-generated document. No signature is required.
    </div>

</body>
</html>
