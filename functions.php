<?php

function getUsersList() {
    global $db;
    
    $stmt = $db->query('SELECT id, name, login, password FROM users');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function existsUser($login) {
    global $db;
    
    $stmt = $db->prepare('SELECT id FROM users WHERE login = :login');
    $stmt->execute(['login' => $login]);
    
    return $stmt->rowCount() > 0;
}

function checkPassword($login, $password) {
    global $db;
    
    $stmt = $db->prepare('SELECT password FROM users WHERE login = :login');
    $stmt->execute(['login' => $login]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        return password_verify($password, $result['password']);
    }
    
    return false;
}

function getCurrentUser() {
    session_start();
    
    if (isset($_SESSION['auth']) && $_SESSION['auth']) {
        return $_SESSION['user_name'] ?? null;
    }
    
    return null;
}



// Пример использования функций:
/*
require 'db.php';
require 'functions.php';

// Получаем список всех пользователей
$users = getUsersList();

// Проверяем существование пользователя
if (existsUser('test_login')) {
    echo 'Пользователь существует';
}

// Проверяем пароль пользователя
if (checkPassword('test_login', 'test_password')) {
    echo 'Пароль верный';
}

// Получаем текущего пользователя
$currentUser = getCurrentUser();
if ($currentUser) {
    echo 'Привет, ' . $currentUser;
} else {
    echo 'Вы не авторизованы';
}
*/