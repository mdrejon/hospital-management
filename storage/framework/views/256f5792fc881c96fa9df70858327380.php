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
        <p>Report Period: <strong><?php echo e($filterLabel); ?></strong></p>
    </div>

    <div class="agent-info">
        <table>
            <tr>
                <td><strong>Agent Name:</strong> <?php echo e($agent->user->name ?? 'N/A'); ?></td>
                <td class="text-right"><strong>Generated On:</strong> <?php echo e(\Carbon\Carbon::now()->format('d M Y, h:i A')); ?></td>
            </tr>
            <tr>
                <td><strong>Agent Code:</strong> <?php echo e($agent->code ?? 'N/A'); ?></td>
                <td class="text-right"><strong>Phone:</strong> <?php echo e($agent->phone ?? 'N/A'); ?></td>
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
            <?php $__empty_1 = true; $__currentLoopData = $commissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($comm->created_at->format('d M Y')); ?></td>
                    <td style="text-transform: capitalize;"><?php echo e(str_replace('_', ' ', $comm->source_type)); ?></td>
                    <td><?php echo e($comm->booking_reference); ?></td>
                    <td class="text-right"><?php echo e(number_format($comm->amount, 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px; color: #a0aec0;">No income records found for this period.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" class="text-right font-bold">Total Filtered Income:</td>
                <td class="text-right font-bold"><?php echo e(number_format($total, 2)); ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        This is a computer-generated document. No signature is required.
    </div>

</body>
</html>
<?php /**PATH /home/hostlive/modern-hospital.hostdivine.com/resources/views/agent/reports/pdf.blade.php ENDPATH**/ ?>