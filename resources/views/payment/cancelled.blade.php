<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled — {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-lg border border-gray-100 p-6 text-center space-y-4">
        <div class="w-14 h-14 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h1 class="text-xl font-bold text-gray-900">Payment Cancelled</h1>
        <p class="text-xs text-gray-500">{{ $message ?? 'You have cancelled the payment checkout session.' }}</p>
        <div class="pt-4 flex gap-2">
            <a href="javascript:history.back()" class="flex-1 py-2.5 px-4 rounded-xl bg-blue-600 font-semibold text-xs text-white hover:bg-blue-700 transition-colors">
                Return to Booking
            </a>
            <a href="/" class="flex-1 py-2.5 px-4 rounded-xl bg-gray-100 font-semibold text-xs text-gray-700 hover:bg-gray-200 transition-colors">
                Go Home
            </a>
        </div>
    </div>
</body>
</html>
