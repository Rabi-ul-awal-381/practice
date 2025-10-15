<?php

// Test database connection and create admin user
try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database connected successfully!\n";
    
    // Check if users table exists
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");
    if ($stmt->fetch()) {
        echo "Users table exists!\n";
        
        // Create admin user
        $password = password_hash('password', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT OR REPLACE INTO users (name, email, password, role, membership_type, created_at, updated_at) VALUES (?, ?, ?, ?, ?, datetime('now'), datetime('now'))");
        $stmt->execute(['Admin User', 'admin@learnislam.com', $password, 'admin', 'paid']);
        
        echo "Admin user created successfully!\n";
        echo "Email: admin@learnislam.com\n";
        echo "Password: password\n";
    } else {
        echo "Users table does not exist. Run migrations first.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
