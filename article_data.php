<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th class="w-25">Judul</th>
                <th class="w-75">Isi</th>
                <th class="w-25">Gambar</th>
                <th class="w-25">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "koneksi.php";

            $hlm = (isset($_POST['hlm'])) ? $_POST['hlm'] : 1;
            $limit = 3;
            $limit_start = ($hlm - 1) * $limit;
            $no = $limit_start + 1;

            $sql = "SELECT * FROM article ORDER BY tanggal DESC LIMIT $limit_start, $limit";
            $hasil = $conn->query($sql);

            $no = 1;
            while ($row = $hasil->fetch_assoc()) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td>
                        <strong><?= $row["judul"] ?></strong>
                        <br>pada: <?= $row["tanggal"] ?>
                        <br>oleh: <?= $row["username"] ?>
                    </td>
                    <td><?= $row["isi"] ?></td>
                    <td>
                        <?php if (!empty($row["gambar"]) && file_exists('img/' . $row["gambar"])) { ?>
                            <img src="img/<?= $row["gambar"] ?>" width="100">
                        <?php } ?>
                    </td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <!-- Delete Button -->
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </td>
                </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditLabel<?= $row["id"] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-dark">
                            <h5 class="modal-title" id="modalEditLabel<?= $row["id"] ?>"><i class="bi bi-pencil-square"></i> Edit Artikel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                <div class="mb-3">
                                    <label class="form-label">Judul</label>
                                    <input type="text" class="form-control" name="judul" value="<?= $row["judul"] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Isi</label>
                                    <textarea class="form-control" name="isi" rows="5" required><?= $row["isi"] ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="formGroupExampleInput2" class="form-label">Ganti Gambar</label>
                                    <input type="file" class="form-control" name="gambar">
                                </div>
                                <div class="mb-3">
                                    <label for="formGroupExampleInput3" class="form-label">Gambar Lama</label>
                                    <?php
                                    if ($row["gambar"] != '') {
                                        if (file_exists('img/' . $row["gambar"] . '')) {
                                    ?>
                                            <br><img src="img/<?= $row["gambar"] ?>" width="100">
                                    <?php
                                        }
                                    }
                                    ?>
                                    <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="simpan" class="btn btn-warning">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Modal Edit -->

                <!-- Modal Hapus -->
            <div class="modal fade" id="modalHapus<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalHapusLabel<?= $row["id"] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="modalHapusLabel<?= $row["id"] ?>"><i class="bi bi-trash"></i> Hapus Artikel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="">
                            <div class="modal-body">
                                <p>Apakah Anda yakin ingin menghapus artikel "<strong><?= $row["judul"] ?></strong>"?</p>
                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Modal Hapus -->
        <?php } ?>
        </tbody>
    </table>
</div>

<?php 
$sql1 = "SELECT * FROM article";
$hasil1 = $conn->query($sql1); 
$total_records = $hasil1->num_rows;
?>
<p>Total article : <?php echo $total_records; ?></p>
<div class="mb-2">
    <ul class="pagination justify-content-end">
    <?php
        $jumlah_page = ceil($total_records / $limit);
        $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
        $start_number = ($hlm > $jumlah_number)? $hlm - $jumlah_number : 1;
        $end_number = ($hlm < ($jumlah_page - $jumlah_number))? $hlm + $jumlah_number : $jumlah_page;

        if($hlm == 1){
            echo '<li class="page-item disabled"><a class="page-link" href="#">First</a></li>';
            echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
        } else {
            $link_prev = ($hlm > 1)? $hlm - 1 : 1;
            echo '<li class="page-item halaman" id="1"><a class="page-link" href="#">First</a></li>';
            echo '<li class="page-item halaman" id="'.$link_prev.'"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
        }

        for($i = $start_number; $i <= $end_number; $i++){
            $link_active = ($hlm == $i)? ' active' : '';
            echo '<li class="page-item halaman '.$link_active.'" id="'.$i.'"><a class="page-link" href="#">'.$i.'</a></li>';
        }

        if($hlm == $jumlah_page){
            echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
            echo '<li class="page-item disabled"><a class="page-link" href="#">Last</a></li>';
        } else {
        $link_next = ($hlm < $jumlah_page)? $hlm + 1 : $jumlah_page;
            echo '<li class="page-item halaman" id="'.$link_next.'"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
            echo '<li class="page-item halaman" id="'.$jumlah_page.'"><a class="page-link" href="#">Last</a></li>';
        }
    ?>
    </ul>
</div>