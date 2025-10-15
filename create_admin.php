<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    $user = User::create([
        'name' => 'Admin User',
        'email' => 'admin@learnislam.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
        'membership_type' => 'paid',
    ]);
    
    echo "Admin user created successfully!\n";
    echo "Email: admin@learnislam.com\n";
    echo "Password: password\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
