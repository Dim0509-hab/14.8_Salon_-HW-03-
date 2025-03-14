<?php
session_start();

// Массив пользователей 
$users = [
    'admin' => [
        'password' => password_hash('12345', PASSWORD_DEFAULT),
        'role' => 'admin'
    ],
    'user' => [
        'password' => password_hash('54321', PASSWORD_DEFAULT),
        'role' => 'user'
    ]
];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if(isset($users[$login])) {
        if(password_verify($password, $users[$login]['password'])) {
            $_SESSION['auth'] = true;
            $_SESSION['user'] = $login;
            $_SESSION['role'] = $users[$login]['role'];
            $_SESSION['login_time'] = time(); // Сохраняем время входа
            header('Location: index.php');
            exit();
        }
        
    }
    
    $_SESSION['error'] = 'Неверный логин или пароль';
    header('Location: index.php');
    exit();
    
}
?>