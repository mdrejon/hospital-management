<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Checkout — {{ config('app.name', 'Hospital Management') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-lg w-full bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <!-- Top Banner / Header -->
        <div class="bg-gradient-to-r {{ $payment->gateway === 'bkash' ? 'from-pink-600 to-rose-700' : 'from-blue-700 to-indigo-800' }} p-6 text-white text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-white/20 backdrop-blur mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h1 class="text-xl font-bold tracking-tight">Secure Payment Gateway</h1>
            <p class="text-xs text-white/80 mt-1 uppercase tracking-widest font-semibold">
                {{ strtoupper($payment->gateway) }} ONLINE CHECKOUT
            </p>
        </div>

        <!-- Order Information Box -->
        <div class="p-6 space-y-5">
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200/70 space-y-2.5 text-xs">
                <div class="flex justify-between items-center text-gray-500">
                    <span>Payable Item:</span>
                    <span class="font-semibold text-gray-800 text-right">{{ $itemTitle }}</span>
                </div>
                <div class="flex justify-between items-center text-gray-500">
                    <span>Patient Name:</span>
                    <span class="font-medium text-gray-800">{{ $patientName }}</span>
                </div>
                <div class="flex justify-between items-center text-gray-500">
                    <span>Mobile Phone:</span>
                    <span class="font-mono text-gray-800">{{ $phone ?: 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center text-gray-500">
                    <span>Transaction ID:</span>
                    <span class="font-mono text-gray-700 bg-gray-200/70 px-1.5 py-0.5 rounded">{{ $payment->transaction_id }}</span>
                </div>
                <div class="pt-2 border-t border-gray-200 flex justify-between items-baseline">
                    <span class="text-xs font-bold text-gray-700 uppercase">Amount Due:</span>
                    <span class="text-2xl font-extrabold {{ $payment->gateway === 'bkash' ? 'text-pink-600' : 'text-blue-700' }}">
                        {{ $payment->currency }} {{ number_format($payment->amount, 2) }}
                    </span>
                </div>
            </div>

            <!-- Simulation / Interactive Checkout Actions -->
            <div class="bg-amber-50 rounded-xl p-4 border border-amber-200 text-amber-900 text-xs space-y-2">
                <div class="flex items-center gap-2 font-bold text-amber-800">
                    <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Sandbox Gateway Simulation</span>
                </div>
                <p class="text-2xs text-amber-700 leading-relaxed">
                    You are in test checkout mode for <strong>{{ strtoupper($payment->gateway) }}</strong>. Click below to simulate an instant payment completion, decline or cancellation.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-2.5 pt-2">
                <!-- Success -->
                <form action="{{ route('payment.sandbox.process', $payment->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="success">
                    <input type="hidden" name="return_url" value="{{ $returnUrl }}">
                    <button type="submit" class="w-full py-3 px-4 rounded-xl font-bold text-sm text-white shadow-md transition-all flex items-center justify-center gap-2 {{ $payment->gateway === 'bkash' ? 'bg-pink-600 hover:bg-pink-700' : 'bg-blue-600 hover:bg-blue-700' }}">
                        <span>Complete Payment ({{ $payment->currency }} {{ number_format($payment->amount, 2) }})</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </form>

                <!-- Cancel / Fail -->
                <div class="grid grid-cols-2 gap-2">
                    <form action="{{ route('payment.sandbox.process', $payment->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="fail">
                        <input type="hidden" name="return_url" value="{{ $returnUrl }}">
                        <button type="submit" class="w-full py-2 px-3 rounded-lg text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 transition-colors border border-red-200">
                            Simulate Decline
                        </button>
                    </form>

                    <form action="{{ route('payment.sandbox.process', $payment->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="cancel">
                        <input type="hidden" name="return_url" value="{{ $returnUrl }}">
                        <button type="submit" class="w-full py-2 px-3 rounded-lg text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors border border-gray-200">
                            Cancel & Return
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-100/70 p-3 text-center text-2xs text-gray-500 border-t border-gray-100">
            256-Bit SSL Encrypted Transaction • Safe & Secure Payment Portal
        </div>
    </div>
</body>
</html>
