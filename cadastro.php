<?php
// Configurações do seu banco MariaDB (Ambiente de Homologação)
$db_host = "163.176.189.119";
$db_name = "kangforce_homologacao";
$db_user = "seu_usuario"; // Substitua pelo usuário correto do banco
$db_pass = "sua_senha_segura"; // Substitua pela senha correta do banco

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erro de conexão com a base de homologação.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (!empty($username) && !empty($email) && !empty($senha)) {
        
        // Validar duplicidade
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :user OR email = :email");
        $stmt->execute([':user' => $username, ':email' => $email]);
        
        if ($stmt->fetch()) {
            echo "<script>alert('Erro: Usuário ou E-mail já cadastrados!'); window.history.back();</script>";
            exit;
        }

        // Criptografar senha usando padrão seguro
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Inserir no banco
        $sql = "INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)";
        $insertStmt = $pdo->prepare($sql);
        
        try {
            $insertStmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password_hash' => $senhaHash
            ]);
            
            echo "<script>alert('Cadastro realizado com sucesso! Agora você pode fazer login.'); window.location.href='index.html';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Erro ao registrar no banco de dados.'); window.history.back();</script>";
        }
    }
}
?>
