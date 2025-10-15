<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Video;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Quran Recitation', 'slug' => 'quran-recitation'],
            ['name' => 'Tafseer', 'slug' => 'tafseer'],
            ['name' => 'Hadith', 'slug' => 'hadith'],
            ['name' => 'Islamic History', 'slug' => 'islamic-history'],
            ['name' => 'Fiqh', 'slug' => 'fiqh'],
            ['name' => 'Arabic Language', 'slug' => 'arabic-language'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@learnislam.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'membership_type' => 'paid',
        ]);

        // Create regular users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'membership_type' => 'free',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'membership_type' => 'paid',
        ]);

        // Create sample videos
        $quranCategory = Category::where('slug', 'quran-recitation')->first();
        $tafseerCategory = Category::where('slug', 'tafseer')->first();

        Video::create([
            'title' => 'Beautiful Quran Recitation - Surah Al-Fatiha',
            'description' => 'A beautiful recitation of the opening chapter of the Quran with proper tajweed.',
            'video_url' => 'https://www.youtube.com/embed/example1',
            'category_id' => $quranCategory->id,
            'access_level' => 'free',
            'views' => 1250,
        ]);

        Video::create([
            'title' => 'Tafseer of Surah Al-Baqarah - Part 1',
            'description' => 'Detailed explanation of the second chapter of the Quran.',
            'video_url' => 'https://www.youtube.com/embed/example2',
            'category_id' => $tafseerCategory->id,
            'access_level' => 'paid',
            'views' => 890,
        ]);
    }
}