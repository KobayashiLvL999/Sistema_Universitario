<?php
$host = 'localhost';
$db   = 'gestao_universitaria'; // Verifique se o nome está idêntico ao seu banco
$user = 'root';
$pass = ''; // <--- COLOQUE A SENHA QUE VOCÊ CRIOU AQUI
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}