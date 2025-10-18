@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-red-100 text-center">
    <div class="bg-white shadow-lg rounded-xl p-10 max-w-md">
        <h1 class="text-3xl font-bold text-red-700 mb-4">Payment Canceled</h1>
        <p class="text-gray-700 mb-6">You canceled the payment. You can try again anytime.</p>
        <a href="{{ route('payment.checkout') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700">Try Again</a>
    </div>
</div>
@endsection
