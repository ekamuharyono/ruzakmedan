<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Script untuk AJAX -->
  <script src="ajax.js"></script>
</head>
<body>
  <section class="d-flex justify-content-between">
    <div id="kiri" class="col-5 mx-auto">
      <h1 class="text-center my-3">Detail Pemesanan</h1>
      <div id="keranjang-container" class="list-group list-group-numbered"></div>
    </div>
    <div id="kanan" class="col-5 container px-5 py-3">
      <div class="mt-5">
        <form id="orderForm">
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
          </div>
          <div class="mb-3">
            <label for="nomor" class="form-label">Nomor Handphone</label>
            <input type="text" class="form-control" id="nomor" name="nomor" required>
          </div>
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" required>
          </div>
          <a href="index.php" class="btn btn-danger">Cancel</a>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </section>

  <!-- BOOTSTRAP JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <script>
    // Menampilkan daftar pesanan dari LocalStorage
    const container = document.getElementById('keranjang-container');
    let listPesanan = JSON.parse(localStorage.getItem('keranjang')) || [];

    let totalHarga = 0;
    listPesanan.forEach(pesanan => {
      totalHarga += pesanan.harga * pesanan.jumlah;
      const pesananElement = document.createElement('div');
      pesananElement.classList.add('pesanan-item');
      pesananElement.innerHTML = `
        <li class="border-bottom p-2 d-flex align-items-center justify-content-between">
          <div id="kiri-list">
            <div>${pesanan.nama}</div>
            <div>x ${pesanan.jumlah} Pcs</div>
          </div>
          <div id="kanan-list">
            <span>Rp. ${pesanan.harga * pesanan.jumlah}</span>
          </div>
        </li>
      `;
      container.appendChild(pesananElement);
    });

    // Menampilkan total harga
    const totalElement = document.createElement('div');
    totalElement.innerHTML = `
      <li class="border-bottom p-2 d-flex align-items-center justify-content-between">
        <div id="kiri-list"><strong>Total Harga</strong></div>
        <div id="kanan-list"><span>Rp. ${totalHarga}</span></div>
      </li>
    `;
    container.appendChild(totalElement);

    // Menangani submit form dan kirim data ke Telegram
    $('#orderForm').submit(function(e) {
      e.preventDefault();

      const nama = $('#nama').val();
      const nomor = $('#nomor').val();
      const alamat = $('#alamat').val();

      // Kirim data ke PHP untuk diproses
      $.ajax({
        url: 'send_to_telegram.php',
        method: 'POST',
        data: {
          nama: nama,
          nomor: nomor,
          alamat: alamat,
          pesanan: JSON.stringify(listPesanan),
        },
        success: function(response) {
          alert(response); // Pesan sukses
        },
        error: function(xhr, status, error) {
          alert('Terjadi kesalahan, coba lagi!');
        }
      });
      localStorage.removeItem('keranjang');
      localStorage.removeItem('pesanan');
    });
  </script>
</body>
</html>
