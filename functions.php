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


