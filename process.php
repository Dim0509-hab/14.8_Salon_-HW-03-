<?php 
session_start();

// Массив пользователей (для примера)
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
    $birthdate = $_POST['birthdate'] ?? null;
    
    if(isset($users[$login])) {
        if(password_verify($password, $users[$login]['password'])) {
            $_SESSION['auth'] = true;
            $_SESSION['user'] = $login;
            $_SESSION['role'] = $users[$login]['role'];
            
            // Сохраняем дату рождения, если она была указана
            if($birthdate) {
                $_SESSION['birthdate'] = $birthdate;
            }
            
            $_SESSION['login_time'] = time();
            header('Location: index.php');
            exit();
        }
    }
    
    $_SESSION['error'] = 'Неверный логин или пароль';
    header('Location: index.php');
    exit();
}