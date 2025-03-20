<?php

declare(strict_types=1);

function get_username(object $pdo, string $username)
{
    $query = "SELECT username FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username, PDO::PARAM_STR); 
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_email(object $pdo, string $email)
{
    $query = "SELECT email FROM users WHERE email = :email;"; 
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR); 
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function set_user(object $pdo, string $pwd, string $username, string $email)
{
    $query = "INSERT into users (username, pwd, email) VALUES (:username, :pwd, :email)";
    $stmt = $pdo->prepare($query);

    $options = [
        'cost' => 12
    ];

    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
