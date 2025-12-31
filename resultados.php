<?php 
    session_start();
    $resultados = $_SESSION['resultados_pesquisa'] ?? [];
    unset($_SESSION['resultados_pesquisa']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resultados da Pesquisa | Blog do Arthur</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f5f5f5;
        }

        .page-header {
            background: linear-gradient(135deg, #111, #222);
            color: #fff;
            padding: 3rem 1rem;
            margin-bottom: 3rem;
        }

        .page-header h1 {
            font-weight: 700;
        }

        .result-card img {
            height: 180px;
            object-fit: cover;
        }

        .badge-type {
            background-color: #0d6efd;
        }

        .no-results {
            background-color: #fff;
            border-radius: 8px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 0 10px rgba(0,0,0,.05);
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

<!-- HEADER -->
<section class="page-header text-center">
    <div class="container">
        <h1>Resultados da Pesquisa</h1>
        <p class="text-secondary mt-2">
            Exibindo resultados para pesquisa solicitada
        </p>
    </div>
</section>

<!-- RESULTADOS -->
<section class="container mb-5">

    <?php if (!empty($resultados)): ?>
        <div class="row g-4">

            <?php foreach ($resultados as $artigo): ?>
                <div class="col-md-4">
                    <div class="card result-card shadow-sm h-100">

                        <img 
                            src="<?= htmlspecialchars($artigo['bannerImage']) ?>" 
                            class="card-img-top" 
                            alt="Banner do artigo"
                        >

                        <div class="card-body d-flex flex-column">
                            <span class="badge badge-type mb-2">
                                <?= htmlspecialchars($artigo['typeText']) ?>
                            </span>

                            <h5 class="card-title fw-bold">
                                <?= htmlspecialchars($artigo['nameText']) ?>
                            </h5>

                            <p class="card-text text-muted">
                                <?= substr(strip_tags($artigo['textContent']), 0, 120) ?>...
                            </p>

                            <form action="redirecionamento.php" method="post" class="mt-auto">
                                <input type="hidden" name="artigoId" value="<?= $artigo['textId'] ?>">
                                <button type="submit" class="btn btn-dark btn-sm w-100">
                                    Ler artigo
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>

        </div>

    <?php else: ?>
        <!-- SEM RESULTADOS -->
        <div class="no-results">
            <h3 class="fw-bold mb-3">Nenhum resultado encontrado</h3>
            <p class="text-muted">
                Tente pesquisar por outro termo ou explore os artigos recentes.
            </p>
            <a href="index.php" class="btn btn-outline-dark mt-3">
                Voltar para a página inicial
            </a>
        </div>
    <?php endif; ?>

</section>

<!-- FOOTER -->
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
