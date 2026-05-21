<?php
session_start();
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha_digitada = $_POST['senha'];

    try {
        $stmt = $pdo->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        echo "<div style='font-family: Arial, sans-serif; padding: 50px; text-align: center;'>";
        if ($usuario && password_verify($senha_digitada, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            echo "<h2 style='color: #28a745;'>Autenticado com sucesso! Bem-vindo ao Kang Force, " . htmlspecialchars($usuario['nome']) . ".</h2>";
        } else {
            echo "<h2 style='color: #dc3545;'>Acesso Negado: Email ou senha incorretos!</h2>";
            echo "<br><a href='index.html'>Tentar novamente</a>";
        }
        echo "</div>";
    } catch (PDOException $e) {
        echo "Erro de sistema: " . htmlspecialchars($e->getMessage());
    }
} else {
    header("Location: index.html");
    exit;
}
?>