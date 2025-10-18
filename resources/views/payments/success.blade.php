@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-green-100 text-center">
    <div class="bg-white shadow-lg rounded-xl p-10 max-w-md">
        <h1 class="text-3xl font-bold text-green-700 mb-4">🎉 Payment Successful!</h1>
        <p class="text-gray-700 mb-6">Your account has been upgraded to <strong>Premium</strong>.</p>
        <a href="{{ route('dashboard') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">Go to Dashboard</a>
    </div>
</div>
@endsection
