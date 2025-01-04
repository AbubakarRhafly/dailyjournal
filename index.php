<?php
include "koneksi.php"; // Pastikan koneksi database

$sql = "SELECT * FROM article ORDER BY tanggal DESC";
$hasil = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Artikel</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-color: #fdfdfd;
            color: #333;
        }
        /* Navbar */
        .navbar {
            background-color: #6c63ff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
        }
        .nav-link {
            color: #fff !important;
        }
        /* Hero Section */
        header {
            background: linear-gradient(to right, #6c63ff, #b19cd9);
            color: white;
        }
        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
        /* Footer */
        .footer {
            background-color: #6c63ff;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">My Articles</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="text-center py-5">
        <div class="container">
            <h1>Selamat Datang di My Articles</h1>
            <p class="lead">Kumpulan artikel terbaru dan menarik</p>
        </div>
    </header>

    <!-- Articles Section -->
    <section id="articles" class="container my-5">
        <h2 class="text-center mb-5" style="color: #6c63ff;">Daftar Artikel</h2>
        <div class="row g-4">
            <?php while ($row = $hasil->fetch_assoc()) { ?>
                <div class="col-md-4">
                    <div class="card h-100">
                        <?php if (!empty($row["gambar"]) && file_exists('img/' . $row["gambar"])) { ?>
                            <img src="img/<?= $row["gambar"] ?>" class="card-img-top" alt="<?= htmlspecialchars($row["judul"]) ?>">
                        <?php } else { ?>
                            <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Placeholder">
                        <?php } ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($row["judul"]) ?></h5>
                            <p class="card-text"><?= substr(htmlspecialchars($row["isi"]), 0, 100) ?>...</p>
                            <div class="mt-auto">
                                <!-- Button Trigger Modal -->
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalArticle<?= $row["id"] ?>">
                                    Baca Selengkapnya
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Detail Article -->
                <div class="modal fade" id="modalArticle<?= $row["id"] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $row["id"] ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="modalLabel<?= $row["id"] ?>"><?= htmlspecialchars($row["judul"]) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-4">
                                    <?php if (!empty($row["gambar"]) && file_exists('img/' . $row["gambar"])) { ?>
                                        <img src="img/<?= $row["gambar"] ?>" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;" alt="<?= htmlspecialchars($row["judul"]) ?>">
                                    <?php } else { ?>
                                        <img src="https://via.placeholder.com/600x400" class="img-fluid rounded" alt="Placeholder">
                                    <?php } ?>
                                </div>
                                <p><?= nl2br(htmlspecialchars($row["isi"])) ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->
            <?php } ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-3 text-center">
        <div class="container">
            <p class="mb-0">&copy; 2024 My Articles. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
