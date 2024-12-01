<?php
// This would output HTML to the client directly
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu | Rujak Medan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      // Function to fetch menu items from the API
      function loadMenu() {
          fetch('/api/menu.php')
              .then(response => response.json())
              .then(data => {
                  // Render menu items on the page
                  let menuHTML = '';
                  data.forEach(item => {
                      menuHTML += `
                          <div class="col-6 col-md-3">
                              <div class="card">
                                  <img src="${item.image}" class="card-img-top" alt="${item.nama_product}" />
                                  <div class="card-body">
                                      <h5 class="card-title">${item.nama_product}</h5>
                                      <p class="card-text">Rp. ${item.harga}</p>
                                      <button class="btn btn-primary" onclick="tambahKeranjang('${item.nama_product}', ${item.harga})">Tambah Pesanan</button>
                                  </div>
                              </div>
                          </div>
                      `;
                  });
                  document.getElementById('menu-container').innerHTML = menuHTML;
              });
      }

      window.onload = loadMenu;
    </script>
</head>
<body>
    <div class="container mt-3">
        <div class="row" id="menu-container"></div>
    </div>
</body>
</html>
