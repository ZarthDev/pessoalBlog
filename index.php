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

    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">

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
            background: url('images/wallpaper.jpg') center/cover no-repeat;
            height: 50vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 3px 3px 4px #000000b3;
        }

        .navbar-fixed {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
        }

        .lead {
            background-color: #000000b3;
        }

        footer {
            background: #222;
            color: white;
        }

        .footer-arcane {
            background: radial-gradient(circle at top, #1b1f2a, #0e1117);
            color: #cfd3ec;
            position: relative;
            overflow: hidden;
        }

        .footer-arcane::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: 
                radial-gradient(#ffffff10 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.15;
            pointer-events: none;
        }

        .footer-title {
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 15px;
            color: #f1f1f1;
        }

        .footer-text {
            font-size: 0.95rem;
            line-height: 1.6;
            color: #bfc5ff;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 8px;
        }

        .footer-links a {
            color: #bfc5ff;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: #ffd369;
            padding-left: 5px;
        }

        .footer-quote {
            font-style: italic;
            font-size: 0.95rem;
            color: #ffd369;
            border-left: 3px solid #ffd369;
            padding-left: 12px;
        }

        .footer-divider {
            border-color: #ffffff20;
            margin: 30px 0;
        }

        .footer-copy {
            font-size: 0.85rem;
            color: #9aa0ff;
        }

        .footer-social a {
            margin-left: 15px;
            font-size: 0.9rem;
            text-decoration: none;
            color: #bfc5ff;
            position: relative;
        }

        .footer-social a::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 1px;
            background: #ffd369;
            transition: width 0.3s ease;
        }

        .footer-social a:hover {
            color: #ffd369;
        }

        .footer-social a:hover::after {
            width: 100%;
        }

    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-fixed navbar-expand-lg  navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="images/logo.png" alt="" width="120" height="80" class="d-inline-block align-text-top">
    </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#"><strong>Blog do Arthur</strong></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
                <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                </svg>
                Contato
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
            </svg>
            GitHub
        </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero -->
<section class="hero-section text-center mt-5">
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
                        <form action="redirecionamento.php" method="post">
                            <input type="hidden" name="artigoId" value="<?= htmlspecialchars($artigo['textId']) ?>">
                            <button type="submit" class="btn btn-primary btn-sm mt-auto">Ler mais</button>
                        </form>
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

                        <form action="redirecionamento.php" method="post">
                            <input type="hidden" name="artigoId" value="<?= htmlspecialchars($artigo['textId']) ?>">
                            <button type="submit" class="btn btn-outline-dark btn-sm mt-auto">Ler mais</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Footer -->
<footer class="footer-arcane mt-5">
    <div class="container py-5">
        <div class="row g-4">

            <!-- Sobre -->
            <div class="col-md-4">
                <h5 class="footer-title">Blog do Arthur</h5>
                <p class="footer-text">
                    Um espaço dedicado ao cinema, HQs, filosofia e narrativas
                    que atravessam o imaginário humano — do real ao simbólico.
                </p>
            </div>

            <!-- Frase / Arcano -->
            <div class="col-md-4">
                <h5 class="footer-title">Arcano</h5>
                <blockquote class="footer-quote">
                    “Toda narrativa é um espelho.  
                    Algumas refletem, outras devoram.”
                </blockquote>
            </div>

        </div>

        <hr class="footer-divider">

        <!-- Bottom -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <span class="footer-copy">
                © <?= date('Y') ?> Blog do Arthur — Todos os direitos reservados
            </span>

            <div class="footer-social">
                <a href="#" title="Instagram">Instagram</a>
                <a href="#" title="GitHub">GitHub</a>
            </div>
        </div>
    </div>
</footer>


</body>
</html>
