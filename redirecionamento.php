<?php 
    session_start();

    $host = 'localhost';
    $db   = 'blog_arthur';
    $user = 'root';
    $pass = '';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $query = 'SELECT * FROM tb_artigos WHERE textId = :textId';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':textId', $_POST['artigoId']);
        $stmt->execute();
        $artigo = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['artigo_atual'] = $artigo;
        header('Location: leitura.php');
        exit();
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>