<?php
session_start();
include "koneksi.php";  

if (!isset($_SESSION['username'])) { 
    header("location:login.php"); 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Daily Journal | Admin</title>
    <link rel="icon" href="img/logo.png" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    /> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>  
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        body {
            background-color: #f8f9fa;
        }

        main {
            flex: 1;
        }

        nav {
            background: linear-gradient(45deg, #ff7675, #fab1a0);
        }

        nav .navbar-brand {
            font-weight: bold;
            color: #fff;
        }

        nav .nav-link {
            color: #fff;
            transition: 0.3s ease;
        }

        nav .nav-link:hover {
            color: #ffdc96;
        }

        footer {
            background: linear-gradient(45deg, #fab1a0, #ff7675);
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        footer a {
        margin: 0 15px; /* Mengatur jarak horizontal */
        display: inline-block; /* Pastikan ikon sejajar */
        text-decoration: none; /* Menghilangkan garis bawah */
        }

        footer i {
        vertical-align: middle; /* Ikon sejajar secara vertikal */
        }

        footer a {
            color: #fff;
            margin: 0 10px;
            font-size: 1.5rem;
            transition: 0.3s ease;
        }

        footer a:hover {
            color: #ffdc96;
        }

        footer div:last-child {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" target="_blank" href="#">My Daily Journal</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php?page=dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php?page=article">Article</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $_SESSION['username']?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li> 
                        </ul>
                    </li> 
                </ul>
            </div>
        </div>
    </nav>
    <!-- End of Navigation -->

    <!-- Content Section -->
    <main>
        <section id="content" class="p-5">
            <div class="container">
                <?php
                if(isset($_GET['page'])) {
                ?>
                    <h4 class="lead display-6 pb-2 border-bottom"><?= ucfirst($_GET['page'])?></h4>
                    <?php include($_GET['page'].".php"); ?>
                <?php
                } else {
                ?>
                    <h4 class="lead display-6 pb-2 border-bottom">Dashboard</h4>
                    <?php include("dashboard.php"); ?>
                <?php } ?>
            </div>
        </section>
    </main>
    <!-- End of Content Section -->

    <!-- Footer -->
    <footer p-5 bg-danger-subtle>
        <div>
            <a href="https://www.instagram.com/its.cat.r/">
                <i class="bi bi-instagram h2 p-2 text-dark"></i>
            </a>
            <a href="https://twitter.com/udinusofficial">
                <i class="bi bi-twitter h2 p-2 text-dark"></i>
            </a>
            <a href="https://wa.me/+62812685577">
                <i class="bi bi-whatsapp h2 p-2 text-dark"></i>
            </a>
        </div>
        <div>Caat &copy; 2024</div>
    </footer>
    <!-- End of Footer -->

    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"
    ></script>
</body>
</html>
