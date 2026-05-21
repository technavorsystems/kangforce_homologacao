<?php
// Configurações de conexão com o MariaDB do Kang Force
$host = '163.176.189.119';
$port = '3606'; 
$db   = 'kangforce_homologacao';
$user = 'root'; // Substitua pelo seu usuário do MariaDB
$pass = '';     // Substitua pela senha do seu MariaDB
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Erro de conexão com o banco de dados: " . $e->getMessage());
}
?>