<?php 
    session_start(); 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Título dinâmico -->
    <title>Leitura | Blog do Arthur</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Merriweather', serif;
        }

        .navbar-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        .banner-artigo {
            width: 100%;
            height: 55vh;
            object-fit: cover;
            filter: brightness(0.75);
        }

        .artigo-container {
            max-width: 820px;
            background: #fff;
            margin-top: -120px;
            position: relative;
            z-index: 10;
            border-radius: 8px;
            padding: 50px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .artigo-titulo {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 2.4rem;
            margin-bottom: 20px;
        }

        .artigo-meta {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            color: #777;
            margin-bottom: 30px;
        }

        .artigo-conteudo {
            font-size: 1.1rem;
            line-height: 1.9;
            color: #222;
            white-space: pre-line;
        }

        footer {
            background: #222;
            color: #ccc;
            margin-top: 80px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand" href="index.php">Blog do Arthur</a>
        </div>
    </nav>

    <!-- Banner -->
    <section>
        <img 
            src="<?= isset($_SESSION['artigo_atual']['bannerImage']) ? htmlspecialchars($_SESSION['artigo_atual']['bannerImage']) : 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba' ?>" 
            alt="Banner do artigo"
            class="banner-artigo"
        >
    </section>

    <!-- Conteúdo do artigo -->
    <main class="container d-flex justify-content-center">
        <article class="artigo-container">

            <!-- Título -->
            <h1 class="artigo-titulo">
                <?= isset($_SESSION['artigo_atual']['nameText']) ? htmlspecialchars($_SESSION['artigo_atual']['nameText']) : 'Título do Artigo' ?>
            </h1>

            <!-- Meta -->
            <div class="artigo-meta">
                <?= isset($_SESSION['artigo_atual']['typeText']) ? ucfirst(htmlspecialchars($_SESSION['artigo_atual']['typeText'])) : 'Artigo' ?> • 
            </div>

            <!-- Texto -->
            <div class="artigo-conteudo">
                <?= isset($_SESSION['artigo_atual']['textContent']) ? nl2br(htmlspecialchars($_SESSION['artigo_atual']['textContent'])) : 'Conteúdo do artigo...' ?>
            </div>

        </article>
    </main>

    <!-- Footer -->
    <footer class="text-center py-4">
        <p class="mb-1">© <?= date('Y') ?> • Blog do Arthur</p>
        <small>Cinema, HQs, Filosofia e Literatura</small>
    </footer>

</body>
</html>
