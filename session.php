<?php

session_start();


function isLoggedIn() {
    return isset($_SESSION['user_id']);
}


function authenticateUser($email, $password) {
    
    $validCredentials = false;
    $userId = null;

    
    $hardcodedUser = [
        'user_id' => 1,
        'email' => 'demo@example.com',
        'password' => password_hash('password123', PASSWORD_DEFAULT),
    ];

    if ($email === $hardcodedUser['email']) {
        
        if (password_verify($password, $hardcodedUser['password'])) {
            $validCredentials = true;
            $userId = $hardcodedUser['user_id'];
        }
    }
    if ($validCredentials) {
        $_SESSION['user_id'] = $userId;
    }

    return $validCredentials;
}


function logoutUser() {
    $_SESSION = array();

    
    session_destroy();
}
?>
