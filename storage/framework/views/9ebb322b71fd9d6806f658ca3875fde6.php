<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt — <?php echo e(config('app.name', 'Hospital Management')); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .receipt-card { box-shadow: none !important; border: none !important; max-width: 100% !important; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4 sm:p-6">
    <div class="max-w-xl w-full bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden receipt-card">
        <!-- Receipt Header -->
        <div class="bg-emerald-600 p-6 text-white text-center">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-white text-emerald-600 mb-3 shadow-md">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight">Payment Successful!</h1>
            <p class="text-xs text-emerald-100 mt-1">Thank you. Your booking and payment have been confirmed.</p>
        </div>

        <!-- Receipt Body -->
        <div class="p-6 sm:p-8 space-y-6">
            <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                <div>
                    <div class="text-2xs uppercase tracking-wider text-gray-400 font-bold">Receipt Amount</div>
                    <div class="text-2xl font-black text-gray-900 mt-0.5">
                        <?php echo e($payment->currency); ?> <?php echo e(number_format($payment->amount, 2)); ?>

                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 uppercase tracking-wide">
                        Paid
                    </span>
                    <div class="text-2xs text-gray-400 mt-1"><?php echo e($payment->paid_at ? $payment->paid_at->format('d M, Y h:i A') : now()->format('d M, Y h:i A')); ?></div>
                </div>
            </div>

            <!-- Transaction Details Table -->
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200/70 space-y-2.5 text-xs">
                <div class="flex justify-between items-center text-gray-600">
                    <span>Transaction ID:</span>
                    <span class="font-mono font-bold text-gray-900"><?php echo e($payment->transaction_id); ?></span>
                </div>
                <div class="flex justify-between items-center text-gray-600">
                    <span>Payment Gateway / Method:</span>
                    <span class="font-semibold text-gray-800 uppercase"><?php echo e($payment->payment_method ?: $payment->gateway); ?></span>
                </div>

                <?php if($payable instanceof \App\Models\Appointment): ?>
                <div class="flex justify-between items-center text-gray-600">
                    <span>Service:</span>
                    <span class="font-medium text-gray-900">Doctor Appointment (Serial #<?php echo e($payable->serial_number ?: $payable->id); ?>)</span>
                </div>
                <div class="flex justify-between items-center text-gray-600">
                    <span>Doctor:</span>
                    <span class="font-medium text-gray-900"><?php echo e($payable->doctor?->name ?: 'Assigned Doctor'); ?></span>
                </div>
                <div class="flex justify-between items-center text-gray-600">
                    <span>Patient Name:</span>
                    <span class="font-semibold text-gray-900"><?php echo e($payable->name); ?></span>
                </div>
                <div class="flex justify-between items-center text-gray-600">
                    <span>Appointment Date:</span>
                    <span class="font-medium text-gray-900"><?php echo e($payable->appointment_date ? $payable->appointment_date->format('d M, Y') : 'Scheduled'); ?></span>
                </div>
                <?php elseif($payable instanceof \App\Models\MedicalTestBooking): ?>
                <div class="flex justify-between items-center text-gray-600">
                    <span>Booking Number:</span>
                    <span class="font-mono font-bold text-purple-700"><?php echo e($payable->booking_number); ?></span>
                </div>
                <div class="flex justify-between items-center text-gray-600">
                    <span>Patient Name:</span>
                    <span class="font-semibold text-gray-900"><?php echo e($payable->patient_name); ?></span>
                </div>
                <div class="flex justify-between items-center text-gray-600">
                    <span>Total Tests:</span>
                    <span class="font-medium text-gray-900"><?php echo e($payable->items->count()); ?> Tests</span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Actions (Print, Return) -->
            <div class="flex flex-col sm:flex-row gap-3 pt-2 no-print">
                <button onclick="window.print()" class="flex-1 py-2.5 px-4 rounded-xl border border-gray-300 font-semibold text-xs text-gray-700 hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    <span>Print Receipt</span>
                </button>

                <?php if(auth()->check() && (auth()->user()->isAgent() || auth()->user()->agentProfile)): ?>
                <a href="<?php echo e(route('agent.bookings.index')); ?>" class="flex-1 py-2.5 px-4 rounded-xl bg-blue-600 font-semibold text-xs text-white hover:bg-blue-700 transition-colors text-center">
                    Back to Bookings &rarr;
                </a>
                <?php elseif(auth()->check() && in_array(auth()->user()->role?->slug, ['admin', 'super-admin'])): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex-1 py-2.5 px-4 rounded-xl bg-blue-600 font-semibold text-xs text-white hover:bg-blue-700 transition-colors text-center">
                    Back to Dashboard &rarr;
                </a>
                <?php else: ?>
                <a href="<?php echo e(route('home')); ?>" class="flex-1 py-2.5 px-4 rounded-xl bg-blue-600 font-semibold text-xs text-white hover:bg-blue-700 transition-colors text-center">
                    Return to Home &rarr;
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 p-4 text-center text-2xs text-gray-400 border-t border-gray-100">
            For any queries regarding this transaction, please contact hospital support with your Transaction ID.
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\laragon-new\laragon\www\hospital-management\resources\views/payment/receipt.blade.php ENDPATH**/ ?>