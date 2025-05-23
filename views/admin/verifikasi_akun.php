<?php require_once 'views/templates/header_admin_daftarkos.php'; ?>

<div class="dashboard-container">
    <!-- Include Sidebar -->
    <?php include('sidebar.php'); ?>

    <!-- Main content area untuk Daftar Kos -->
    <div class="main-content">
        <div class="kamar-container">
            <table class="kamar-table">
                <thead>
                    <tr>
                        <th>Id Penyewa</th>
                        <th>Id Pembayaran</th>
                        <th>Email Penyewa</th>
                        <th>Jumlah Bayar</th>
                        <th>Bukti Pembayaran</th>
                        <th>Status Pembayaran</th>
                        <th>Status Akun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($verifList as $verif): ?>
                        <tr>
                            <td><?= number_format($verif['id_penyewa']) ?></td>
                            <td><?= number_format($verif['id_pembayaran']) ?></td>
                            <td><?= htmlspecialchars($verif['email_penyewa']) ?></td>
                            <td>Rp <?= number_format($verif['jumlah_bayar'], 0, ',', '.') ?></td>
                            <td>
                                <img src="uploads/bukti_pembayaran/<?= htmlspecialchars($verif['bukti_pembayaran']) ?>"
                                    alt="Bukti Pembayaran" class="foto-kamar"
                                    style="width:100px; height:100px; cursor:pointer" onclick="showModal(this.src)">
                            </td>
                            <td class="<?= $verif['status_pembayaran'] == 'Lunas' ? 'lunas' : 'cicil' ?>">
                                <?= htmlspecialchars($verif['status_pembayaran']) ?>
                            </td>
                            <td
                                class="<?= $verif['status_akun'] == 'Terverifikasi' ? 'terverifikasi' : 'menunggu_verifikasi' ?>">
                                <?= htmlspecialchars($verif['status_akun']) ?>
                            <td class="aksi">
                                <div class="action-buttons">
                                    <!-- Tombol Edit dengan Icon Font Awesome -->
                                    <a href="#" class="btn-edit"
                                        onclick="openEditModal(<?= $verif['id_penyewa'] ?>, '<?= $verif['status_akun'] ?>')">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal buat tampilin gambar gede -->
<div id="myModal">
    <span onclick="closeModal()" style="position:absolute;top:20px;right:45px;color:white;font-size:40px;font-weight:bold;cursor:pointer">&times;</span>
    <img id="imgModal" style="margin:auto;display:block;max-width:90%;max-height:80%">
</div>


<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeEditModal()">&times;</span>
        <h3>Edit Status Akun</h3>
        <form action="index.php?page=admin_update_status_akun" method="POST">
            <input type="hidden" name="id_penyewa" id="edit_id_feedback">

            <label for="edit_status_feedback">Status</label>
            <select name="status_akun" id="edit_status_feedback" required>
                <option value="Terverifikasi">Terverifikasi</option>
                <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                <option value="Umum">Umum</option>
            </select>

            <div class="modal-buttons">
                <button type="submit" class="btn-save">Simpan</button>
                <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
            </div>
        </form>
    </div>
</div>