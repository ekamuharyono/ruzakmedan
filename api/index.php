<?php
header('Content-Type: text/html; charset=utf-8');

// Ambil data menu dari file JSON
$jsonData = file_get_contents('../databases/menu.json');
$menuItems = json_decode($jsonData, true);

// Menyusun HTML untuk menampilkan menu
$html = "<!doctype html>
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Menu | Rujak Medan</title>
    <link href='/styles.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css'/>
    <script src='/scripts/script.js'></script>
  </head>
  <body>
    <section id='header' class='py-2 bg-primary'>
      <div class='container d-flex justify-content-between'>
        <div id='kiri'>
          <h1 class='fs-3 text-white'>RUZAK MEDAN</h1>
        </div>
        <div id='kanan' class='d-flex justify-content-center align-items-center'>
          <div class='mx-auto'>
            <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal'>
              <i onclick='tampilkanKeranjang()' class='fs-4 text-warning fa-solid fa-cart-shopping'></i>
            </button>
            <div class='modal fade' id='exampleModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
              <div class='modal-dialog'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='exampleModalLabel'>Keranjang</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                  </div>
                  <div class='modal-body'>
                    <div id='keranjang-container' class='list-group list-group-numbered'></div>
                  </div>
                  <div class='modal-footer'>
                    <a href='checkout.php' type='button' class='btn btn-primary'>Pesan Sekarang</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class='container mt-3 px-3'>
      <div id='Menu'>
        <div class='row row-gap-2 justify-content-arround'>";
        
foreach ($menuItems as $menu) {
    $html .= "<div class='col-6 col-md-3'>
                <div class='card'>
                  <img src='" . htmlspecialchars($menu['image']) . "' class='card-img-top' alt='" . htmlspecialchars($menu['nama_product']) . "' />
                  <div class='card-body'>
                    <h5 class='card-title'>" . htmlspecialchars($menu['nama_product']) . "</h5>
                    <p class='card-text'>Rp. " . htmlspecialchars($menu['harga']) . "</p>
                    <p href='' class='btn btn-primary' onclick='tambahKeranjang(\"" . htmlspecialchars($menu['nama_product']) . "\", \"" . htmlspecialchars($menu['harga']) . "\")'>Tambah Pesanan</p>
                  </div>
                </div>
              </div>";
}

$html .= "</div>
        </div>
      </section>
      <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'></script>
      <script>
        function tambahKeranjang(nama, harga) {
          let listPesanan = JSON.parse(localStorage.getItem('keranjang')) || [];
          let produkAda = listPesanan.find(pesanan => pesanan.nama === nama);
          if (produkAda) {
            produkAda.jumlah += 1;
          } else {
            let pesananBaru = {nama: nama, harga: harga, jumlah: 1};
            listPesanan.push(pesananBaru);
          }
          localStorage.setItem('keranjang', JSON.stringify(listPesanan));
        }

        function tampilkanKeranjang() {
          const container = document.getElementById('keranjang-container');
          container.innerHTML = '';
          let listPesanan = JSON.parse(localStorage.getItem('keranjang')) || [];
          if (listPesanan.length === 0) {
            container.innerHTML = '<p>Keranjang Anda kosong.</p>';
          } else {
            listPesanan.forEach(pesanan => {
              const pesananElement = document.createElement('div');
              pesananElement.classList.add('pesanan-item');
              pesananElement.innerHTML = `
                <div class='d-flex justify-content-between align-items-center'>
                  <div class='ms-2 me-auto'>
                    <div class='fw-bold'>${pesanan.nama}</div>
                    <div>Rp. ${pesanan.harga}</div>
                  </div>
                  <span class='badge text-bg-primary rounded-pill'>${pesanan.jumlah}</span>
                </div>
              `;
              container.appendChild(pesananElement);
            });
          }
          container.style.display = 'block';
        }
      </script>
  </body>
</html>";

echo $html;
