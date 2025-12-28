<?php
session_start(); 

// DB connection 
$host = 'localhost';
$db   = 'blog_arthur';
$user = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // TODOS OS ARTIGOS
    $stmtTodos = $conn->prepare("SELECT * FROM tb_artigos");
    $stmtTodos->execute();
    $todosArtigos = $stmtTodos->fetchAll(PDO::FETCH_ASSOC);

    // DESTAQUES (LIMIT 4)
    $stmtDestaques = $conn->prepare("SELECT * FROM tb_artigos ORDER BY textId DESC LIMIT 4");
    $stmtDestaques->execute();
    $artigosDestaque = $stmtDestaques->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog do Arthur | Cinema, HQs & Filosofia</title>

    <!-- bootstrap5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f7f7f7;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
        }
        .hero-section {
            background: url('https://images.unsplash.com/photo-1512820790803-83ca734da794') center/cover no-repeat;
            height: 50vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.6);
        }
        footer {
            background: #222;
            color: white;
        }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
    <div class="container">
        <a class="navbar-brand" href="#">Blog do Arthur</a>
    </div>
</nav>

<!-- Hero -->
<section class="hero-section text-center">
    <div>
        <h1>Explorando Ideias & Narrativas</h1>
        <p class="lead">Cinema, HQs, Filosofia, Livros e Filmes</p>
    </div>
</section>

<!-- ================= DESTAQUES ================= -->
<section id="destaques" class="container my-5">
    <h2 class="mb-4">Artigos em Destaque</h2>

    <div class="row g-4">
        <?php foreach ($artigosDestaque as $artigo): ?>
            <div class="col-md-3">
                <div class="card shadow-sm h-100">
                    <img 
                        src="<?= htmlspecialchars($artigo['bannerImage']) ?>" 
                        class="card-img-top" 
                        alt="Banner do artigo"
                    >
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold">
                            <?= htmlspecialchars($artigo['nameText']) ?>
                        </h6>
                        <a href="#" class="btn btn-primary btn-sm mt-auto">Ler mais</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ================= TODOS OS ARTIGOS ================= -->
<section id="todos-artigos" class="container my-5">
    <h2 class="mb-4">Todos os Artigos</h2>

    <div class="row g-4">
        <?php foreach ($todosArtigos as $artigo): ?>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <img 
                        src="<?= htmlspecialchars($artigo['bannerImage']) ?>" 
                        class="card-img-top" 
                        alt="Banner do artigo"
                    >
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-secondary mb-2">
                            <?= htmlspecialchars($artigo['typeText']) ?>
                        </span>

                        <h5 class="card-title fw-bold">
                            <?= htmlspecialchars($artigo['nameText']) ?>
                        </h5>

                        <a href="#" class="btn btn-outline-dark btn-sm mt-auto">
                            Ler artigo
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Footer -->
<footer class="text-center py-4">
    <p class="mb-0">Feito com 💻 por Arthur ✨</p>
</footer>

</body>
</html>
