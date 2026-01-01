<?php
session_start();

/* =======================
   CONEXÃO COM O BANCO
======================= */
$host = 'localhost';
$db   = 'blog_arthur';
$user = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmtDestaques = $conn->prepare("
        SELECT * 
        FROM tb_artigos 
        ORDER BY textId DESC 
        LIMIT 4
    ");
    $stmtDestaques->execute();
    $artigosDestaque = $stmtDestaques->fetchAll(PDO::FETCH_ASSOC);

    $limite = 6; 
    $paginaAtual = isset($_GET['pagina']) && is_numeric($_GET['pagina'])
        ? (int) $_GET['pagina']
        : 1;

    $offset = ($paginaAtual - 1) * $limite;

    // Total de artigos
    $stmtTotal = $conn->query("SELECT COUNT(*) FROM tb_artigos");
    $totalArtigos = $stmtTotal->fetchColumn();

    $totalPaginas = ceil($totalArtigos / $limite);

    // Artigos da página atual
    $stmtTodos = $conn->prepare("
        SELECT * 
        FROM tb_artigos 
        ORDER BY textId DESC 
        LIMIT :limite OFFSET :offset
    ");
    $stmtTodos->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmtTodos->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmtTodos->execute();
    $todosArtigos = $stmtTodos->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Blog do Arthur</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">

    <style>
        body { background:#f7f7f7; }
        .hero-section {
            background: url('images/wallpaper.jpg') center/cover;
            height: 50vh;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            text-shadow:2px 2px 6px #000;
        }

        footer {
            background: #222;
            color: #ccc;
            margin-top: 80px;
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
<nav class="navbar navbar-fixed navbar-expand-lg navbar-dark bg-dark"> 
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
                    <a class="nav-link active" aria-current="page" href="#">
                        <strong>Blog do Arthur</strong>
                    </a> 
                </li> 
                <li class="nav-item"> 
                    <a class="nav-link" href="#"> 
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16"> 
                            <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/> <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/> 
                        </svg> Contato 
                    </a> 
                </li> 
                <li class="nav-item"> 
                    <a class="nav-link" href="#"> 
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16"> <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/> </svg> GitHub 
                    </a> 
                </li> 
            <form action="pesquisa.php" method="post" class="d-flex" role="search">     
                    <input class="form-control ms-2 me-2" type="search" name="pesquisa" placeholder="Pesquisar" aria-label="Search"/> 
                    <button class="btn btn-outline-success" type="submit"> 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"> <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/> 
                    </svg> 
                </button> 
            </form> 
        </ul> 
    </div> 
</div> 
</nav>
<!-- ================= HERO ================= -->
<section class="hero-section text-center">
    <div>
        <h1>Explorando Ideias & Narrativas</h1>
        <p class="lead bg-dark bg-opacity-75 px-3 py-1">
            Cinema • HQs • Filosofia • Literatura
        </p>
    </div>
</section>

<!-- ================= DESTAQUES ================= -->
<section class="container my-5">
    <h2 class="mb-4">Artigos em Destaque</h2>

    <div class="row g-4">
        <?php foreach ($artigosDestaque as $artigo): ?>
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">
                    <img src="<?= htmlspecialchars($artigo['bannerImage']) ?>" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                        <h6 class="fw-bold"><?= htmlspecialchars($artigo['nameText']) ?></h6>

                        <form action="redirecionamento.php" method="post" class="mt-auto">
                            <input type="hidden" name="artigoId" value="<?= $artigo['textId'] ?>">
                            <button class="btn btn-primary btn-sm">Ler mais</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="container my-5">
    <h2 class="mb-4">Todos os Artigos</h2>

    <div class="row g-4">
        <?php foreach ($todosArtigos as $artigo): ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="<?= htmlspecialchars($artigo['bannerImage']) ?>" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-secondary mb-2">
                            <?= htmlspecialchars($artigo['typeText']) ?>
                        </span>

                        <h5 class="fw-bold"><?= htmlspecialchars($artigo['nameText']) ?></h5>

                        <form action="redirecionamento.php" method="post" class="mt-auto">
                            <input type="hidden" name="artigoId" value="<?= $artigo['textId'] ?>">
                            <button class="btn btn-outline-dark btn-sm">Ler mais</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <nav class="mt-5">
        <ul class="pagination justify-content-center">

            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= $i == $paginaAtual ? 'active' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

        </ul>
    </nav>
</section>

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
                    <h5 class="footer-title">Franz Kafka</h5>
                    <blockquote class="footer-quote">
                        “Só podia encontrar a felicidade 
                        se conseguisse subverter o mundo 
                        para o fazer entrar no verdadeiro, 
                        no puro, no imutável.”
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
