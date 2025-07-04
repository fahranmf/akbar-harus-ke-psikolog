<?php include 'views/templates/public2.php'; ?>
<script>
    const harga = <?= $harga_kamar ?>; // dari database

    function formatRupiah(angka) {
        return 'Rp. ' + angka.toLocaleString('id-ID');
    }

    function updateJumlahBayar() {
        const status = document.getElementById('jenis_pembayaran').value;
        const harga = parseFloat(document.getElementById('harga_kamar').value);
        const jumlahDisplay = document.getElementById('jumlah_bayar_display');
        const jumlahHidden = document.getElementById('jumlah_bayar');
        const tenggatInput = document.getElementById('tenggat_pembayaran');
        const tenggatWrapper = document.getElementById('tenggatWrapper');

        if (status === 'Lunas') {
            jumlahDisplay.value = formatRupiah(harga);
            jumlahHidden.value = harga;
            tenggatWrapper.style.display = 'none';
            tenggatInput.value = '';
        } else if (status === 'Cicil') {
            const cicilan = harga / 2;
            jumlahDisplay.value = formatRupiah(cicilan);
            jumlahHidden.value = cicilan;
            tenggatWrapper.style.display = 'block';

            const tanggal = new Date();
            tanggal.setDate(tanggal.getDate() + 14);
            tanggal.setHours(23, 59, 0, 0);

            const yyyy = tanggal.getFullYear();
            const mm = String(tanggal.getMonth() + 1).padStart(2, '0');
            const dd = String(tanggal.getDate()).padStart(2, '0');
            const hh = String(tanggal.getHours()).padStart(2, '0');
            const mi = String(tanggal.getMinutes()).padStart(2, '0');

            tenggatInput.value = `${yyyy}-${mm}-${dd}T${hh}:${mi}`;
        } else {
            jumlahDisplay.value = '';
            jumlahHidden.value = '';
            tenggatWrapper.style.display = 'none';
            tenggatInput.value = '';
        }
    }



</script>

<div class="card">
    <h2>Form Pembayaran</h2>

    <?php if (isset($_SESSION['errorMsg'])): ?>
        <p style="color:red; margin-bottom: 20px;">
            <?= htmlspecialchars($_SESSION['errorMsg']) ?>
            <?php unset($_SESSION['errorMsg']); ?>
        </p>
    <?php endif; ?>

    <form action="index.php?page=pembayaran&action=proses" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="jenis_pembayaran">Pilih Pembayaran</label>
            <select name="jenis_pembayaran" id="jenis_pembayaran" required onchange="updateJumlahBayar()">
                <option value="">-- Pilih --</option>
                <option value="Lunas">Lunas</option>
                <option value="Cicil">Cicil</option>
            </select>
        </div>

        <div class="form-group">
            <label for="jumlah_bayar">Jumlah Bayar</label>
            <input type="text" id="jumlah_bayar_display" readonly>
            <input type="hidden" id="jumlah_bayar" name="jumlah_bayar" required>
        </div>


        <!-- ✅ Tambahkan elemen hidden untuk menyimpan harga -->
        <input type="hidden" id="harga_kamar" value="<?= $harga_kamar ?>">

        <div class="form-group">
            <label for="metode_pembayaran">Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode_pembayaran" required>
                <option value="E-Wallet">E-Wallet</option>
                <option value="Transfer Bank">Transfer Bank</option>
                <option value="Cash">Cash</option>
            </select>
        </div>

        <div class="form-group" id="tenggatWrapper" style="display: none;">
            <label for="tenggat_pembayaran">Tenggat Pembayaran</label>
            <input type="datetime-local" id="tenggat_pembayaran" name="tenggat_pembayaran" readonly>
        </div>

        <div class="form-group">
            <label for="bukti_pembayaran">Bukti Pembayaran (upload file)</label>
            <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*,application/pdf">
        </div>

        <button type="submit" name="bayar">Bayar</button>
    </form>
</div>