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
            font-family: 'Montserrat', sans-serif;
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
<nav class="navbar navbar-fixed navbar-expand-lg  navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="images/logo.png" alt="" width="120" height="80" class="d-inline-block align-text-top">
    </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php"><strong>Blog do Arthur</strong></a>
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
