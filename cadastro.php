<?php
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); 

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $senha]);
        
        echo "<div style='font-family: Arial, sans-serif; padding: 50px; text-align: center;'>";
        echo "<h2 style='color: #28a745;'>Cadastro no Kang Force realizado com sucesso!</h2>";
        echo "<br><br><a href='index.html' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Ir para o Login</a>";
        echo "</div>";
    } catch (PDOException $e) {
        echo "<div style='font-family: Arial, sans-serif; padding: 50px; text-align: center;'>";
        if ($e->getCode() == 23000) { 
            echo "<h2 style='color: #dc3545;'>Erro: Este email já está cadastrado no sistema.</h2>";
        } else {
            echo "<h2 style='color: #dc3545;'>Erro no cadastro: " . htmlspecialchars($e->getMessage()) . "</h2>";
        }
        echo "<br><a href='cadastro.html'>Tentar novamente</a>";
        echo "</div>";
    }
} else {
    header("Location: cadastro.html");
    exit;
}
?>