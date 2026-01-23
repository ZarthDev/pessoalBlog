<?php
session_start();

$host = 'localhost';
$db   = 'blog_arthur';
$user = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Destaques
    $stmtDestaques = $conn->prepare("
        SELECT * FROM tb_artigos 
        ORDER BY textId DESC 
        LIMIT 4
    ");
    $stmtDestaques->execute();
    $artigosDestaque = $stmtDestaques->fetchAll(PDO::FETCH_ASSOC);

    // Paginação
    $limite = 6;
    $paginaAtual = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $offset = ($paginaAtual - 1) * $limite;

    $stmtTotal = $conn->query("SELECT COUNT(*) FROM tb_artigos");
    $totalArtigos = $stmtTotal->fetchColumn();
    $totalPaginas = ceil($totalArtigos / $limite);

    $stmtTodos = $conn->prepare("
        SELECT * FROM tb_artigos
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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (UM ÚNICO SCRIPT – ESSENCIAL) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="shortcut icon" href="images/logo.png">

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
            background-image: radial-gradient(#ffffff10 1px, transparent 1px); 
            background-size: 20px 20px; 
            opacity: 0.15; pointer-events: none; 
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

        #offcanvasMenu {
            background: url('images/offcanvas.jpg') center/cover;
        }
    </style>
</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <a class="navbar-brand" href="#">
            <img src="images/logo.png" width="120" height="80">
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link active" href="#"><strong>Blog do Arthur</strong></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="https://wa.me/5551986928804">Contato</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="https://github.com/ZarthDev">GitHub</a>
                </li>

                <!-- Pesquisa -->
                <li class="nav-item ms-lg-3">
                    <form action="pesquisa.php" method="post" class="d-flex">
                        <input class="form-control me-2" type="search" name="pesquisa" placeholder="Pesquisar">
                        <button class="btn btn-outline-success" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                        </button>
                    </form>
                </li>

                <!-- Botão Offcanvas -->
                <li class="nav-item ms-lg-3">
                    <button class="btn btn-outline-secondary"
                        type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasMenu">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-luggage-fill" viewBox="0 0 16 16">
                        <path d="M2 1.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V5h.5A1.5 1.5 0 0 1 8 6.5V7H7v-.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .5.5H4v1H2.5v.25a.75.75 0 0 1-1.5 0v-.335A1.5 1.5 0 0 1 0 13.5v-7A1.5 1.5 0 0 1 1.5 5H2zM3 5h2V2H3z"/>
                        <path d="M2.5 7a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0v-5a.5.5 0 0 1 .5-.5m10 1v-.5A1.5 1.5 0 0 0 11 6h-1a1.5 1.5 0 0 0-1.5 1.5V8H8v8h5V8zM10 7h1a.5.5 0 0 1 .5.5V8h-2v-.5A.5.5 0 0 1 10 7M5 9.5A1.5 1.5 0 0 1 6.5 8H7v8h-.5A1.5 1.5 0 0 1 5 14.5zm9 6.5V8h.5A1.5 1.5 0 0 1 16 9.5v5a1.5 1.5 0 0 1-1.5 1.5z"/>
                        </svg>
                        Fast Travel
                    </button>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- ================= OFFCANVAS ================= -->
<div class="offcanvas offcanvas-start"
     tabindex="-1"
     id="offcanvasMenu"
     data-bs-scroll="true"
     data-bs-backdrop="true">

    <div class="offcanvas-header bg-dark text-white">
        <h5 class="offcanvas-title">Viagem Rápida</h5>
        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas">
            <svg xmlns="http://www.w3.org/2000/svg" width="29" height="20" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
            </svg>
        </button>
    </div>

    <div class="offcanvas-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item bg-dark" style="border-radius: 10px 10px 0 0">
                <a class="btn link-light link-underline link-underline-opacity-10 link-offset-2" href="#">
                    Início 
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                    </svg>
                </a>
            </li>
                <li class="list-group-item bg-dark">
                    <form action="pesquisa.php" method="post">
                        <input type="hidden" name="pesquisa" value="filme">
                        <button type="submit" class="btn link-light link-underline link-underline-opacity-10 link-offset-2" href="#">
                        Cinema
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-film" viewBox="0 0 16 16">
                        <path d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm4 0v6h8V1zm8 8H4v6h8zM1 1v2h2V1zm2 3H1v2h2zM1 7v2h2V7zm2 3H1v2h2zm-2 3v2h2v-2zM15 1h-2v2h2zm-2 3v2h2V4zm2 3h-2v2h2zm-2 3v2h2v-2zm2 3h-2v2h2z"/>
                        </svg>
                        </button>
                    </form>
            </li>
                <li class="list-group-item bg-dark">
                    <form action="pesquisa.php" method="post">
                        <input type="hidden" name="pesquisa" value="HQ">
                        <button type="submit" class="btn link-light link-underline link-underline-opacity-10 link-offset-2" href="#">
                        HQs
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eyeglasses" viewBox="0 0 16 16">
                        <path d="M4 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4m2.625.547a3 3 0 0 0-5.584.953H.5a.5.5 0 0 0 0 1h.541A3 3 0 0 0 7 8a1 1 0 0 1 2 0 3 3 0 0 0 5.959.5h.541a.5.5 0 0 0 0-1h-.541a3 3 0 0 0-5.584-.953A2 2 0 0 0 8 6c-.532 0-1.016.208-1.375.547M14 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0"/>
                        </svg>
                        </button>
                    </form>
            </li>
                <li class="list-group-item bg-dark">
                    <form action="pesquisa.php" method="post">
                        <input type="hidden" name="pesquisa" value="filosofia">
                        <button type="submit" class="btn link-light link-underline link-underline-opacity-10 link-offset-2" href="#">
                        Filosofia
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-book-half" viewBox="0 0 16 16">
                        <path d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
                        </svg>
                        </button>
                    </form>
            </li>
                <li class="list-group-item bg-dark" style="border-radius: 0 0 10px 10px">
                    <form action="pesquisa.php" method="post">
                        <input type="hidden" name="pesquisa" value="literatura">
                        <button type="submit" class="btn link-light link-underline link-underline-opacity-10 link-offset-2" href="#">
                        Literatura
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                        <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                        <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                        <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                        </svg>
                        </button>
                    </form>
            </li>
        </ul>
        <br>
        <img src="images/instabanner.jpg" class="img-fluid rounded border border-3 border-dark" OnClick="window.location.href='https://www.instagram.com/arthdev_/';" style="cursor: pointer;"
        >
    </div>
</div>

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

<!-- ================= TODOS ================= -->
<section class="container my-5">
    <h2>Todos os Artigos</h2>

    <div class="row g-4">
        <?php foreach ($todosArtigos as $artigo): ?>
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="<?= htmlspecialchars($artigo['bannerImage']) ?>" class="card-img-top">
                    <div class="card-body">
                        <span class="badge bg-secondary">
                            <?= htmlspecialchars($artigo['typeText']) ?>
                        </span>
                        <h5><?= htmlspecialchars($artigo['nameText']) ?></h5>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= $i == $paginaAtual ? 'active' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
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
                <p class="footer-text"> Um espaço dedicado ao cinema, HQs, filosofia e narrativas que atravessam o imaginário humano — do real ao simbólico. </p> </div> <!-- Frase / Arcano -->
                    <div class="col-md-4"> 
                        <h5 class="footer-title">Franz Kafka</h5> <blockquote class="footer-quote"> “Só podia encontrar a felicidade se conseguisse subverter o mundo para o fazer entrar no verdadeiro, no puro, no imutável.” </blockquote> 
                    </div> 
                </div> 
                
                <hr class="footer-divider"> 
                <!-- Bottom --> 
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <span class="footer-copy"> © <?= date('Y') ?> Blog do Arthur — Todos os direitos reservados </span> 
                <div class="footer-social"> 
                    <a href="https://www.instagram.com/arthdev_" title="Instagram">Instagram</a> 
                    <a href="https://github.com/ZarthDev" title="GitHub">GitHub</a> </div> 
                </div> 
            </div> 
        </footer>
</body>
</html>
