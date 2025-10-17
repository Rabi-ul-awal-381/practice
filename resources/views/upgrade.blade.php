@extends('layouts.app')

@section('title', 'Upgrade to Premium')

@section('content')
<div class="max-w-4xl mx-auto text-center py-20">
    <h1 class="text-4xl font-bold text-yellow-900 mb-4">Upgrade to Premium 🌟</h1>
    <p class="text-lg text-gray-700 mb-10">
        Unlock exclusive Quran recitations, deep Islamic courses, and ad-free learning.
    </p>

    <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-xl p-10 shadow-lg">
        <ul class="text-left text-yellow-900 text-lg mb-8 space-y-3">
            <li>✅ Access to all premium videos</li>
            <li>✅ Ad-free experience</li>
            <li>✅ Exclusive live sessions</li>
            <li>✅ Early access to new lessons</li>
        </ul>

        <a href="#" 
           class="bg-yellow-900 text-white px-10 py-4 rounded-lg font-bold hover:bg-yellow-800 transition-all duration-300 shadow-lg">
           Contact Support to Upgrade
        </a>
    </div>
</div>
@endsection
