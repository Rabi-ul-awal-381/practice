@extends('layouts.app')

@section('title', 'Upgrade to Premium')

@section('content')
<section class="min-h-screen bg-gradient-to-r from-green-600 to-emerald-500 flex items-center justify-center">
    <div class="bg-white shadow-xl rounded-2xl p-10 max-w-md w-full text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Upgrade to Premium</h1>
        <p class="text-gray-600 mb-8">
            Get access to <span class="font-semibold">exclusive videos</span>, lectures, and Quran recitations.
        </p>

        <form action="{{ route('payment.session') }}" method="POST">
            @csrf
            <button 
                type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg font-semibold text-lg shadow-lg transition-all duration-300">
                Pay $5.00 with Card
            </button>
        </form>

        <p class="text-sm text-gray-500 mt-6">Secure payments powered by Stripe</p>
    </div>
</section>
@endsection
