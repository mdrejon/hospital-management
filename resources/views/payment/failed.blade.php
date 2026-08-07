<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed — {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-lg border border-gray-100 p-6 text-center space-y-4">
        <div class="w-14 h-14 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </div>
        <h1 class="text-xl font-bold text-gray-900">Payment Failed</h1>
        <p class="text-xs text-gray-500">{{ $message ?? 'The transaction could not be processed. Please check your payment details or try again.' }}</p>
        <div class="pt-4 flex gap-2">
            <a href="javascript:history.back()" class="flex-1 py-2.5 px-4 rounded-xl bg-blue-600 font-semibold text-xs text-white hover:bg-blue-700 transition-colors">
                Try Again
            </a>
            <a href="/" class="flex-1 py-2.5 px-4 rounded-xl bg-gray-100 font-semibold text-xs text-gray-700 hover:bg-gray-200 transition-colors">
                Go Home
            </a>
        </div>
    </div>
</body>
</html>
