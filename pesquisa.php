<?php 
session_start();

$search = trim($_POST['pesquisa']);
$search = mb_strtolower($search, 'UTF-8');

$host = 'localhost';
$db   = 'blog_arthur';
$user = 'root';
$pass = '';

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "
        SELECT * FROM tb_artigos
        WHERE 
            LOWER(nameText) LIKE :search
            OR LOWER(typeText) LIKE :search
            OR LOWER(textContent) LIKE :search
    ";

    $stmt = $conn->prepare($query);

    $likeSearch = '%' . $search . '%';
    $stmt->bindParam(':search', $likeSearch);

    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['resultados_pesquisa'] = $resultados;
    $_SESSION['termo_pesquisa'] = $search;

    header('Location: resultados.php');
    exit();

} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
