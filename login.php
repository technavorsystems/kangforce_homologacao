<?php
session_start();

// Configurações do seu banco de dados MariaDB (Ambiente de Homologação)
$db_host = "163.176.189.119";
$db_name = "kangforce_homologacao";
$db_user = "seu_usuario"; // Substitua pelo usuário correto do banco
$db_pass = "sua_senha_segura"; // Substitua pela senha correta do banco

try {
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 5,
    ];
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, $options);
} catch (PDOException $e) {
    die("Erro crítico de infraestrutura. Não foi possível conectar ao banco de dados.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuarioInput = trim($_POST['usuario']);
    $senhaInput = trim($_POST['senha']);

    if (!empty($usuarioInput) && !empty($senhaInput)) {
        $sql = "SELECT id, username, email, password_hash FROM users WHERE email = :input OR username = :input LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':input', $usuarioInput, PDO::PARAM_STR);
        $stmt->execute();
        
        $user = $stmt->fetch();

        if ($user && password_verify($senhaInput, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            header("Location: dashboard.php");
            exit;
        } else {
            echo "<script>alert('Usuário ou senha incorretos.'); window.location.href='index.html';</script>";
        }
    }
}
?>
