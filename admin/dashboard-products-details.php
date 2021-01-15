<?php 
require '../config/config.php';

$id = $_GET["id"];

$product = query("SELECT * FROM products WHERE id_product = $id")[0];

if (isset($_POST["updateProduk"])) {
  if (updateProduk($_POST) > 0) {
    echo "<script>
            alert('Produk Berhasil Diubah');
            document.location.href = '?page=products';
          </script>";
  } else {
    echo "<script>
            alert('Produk Gagal Diubah');
            document.location.href = '?page=products';
          </script>";
  }
}

?>
<nav
  class="navbar navbar-expand-lg navbar-light navbar-store fixed-top"
  data-aos="fade-down"
>
  <div class="container-fluid">
    <button
      class="btn btn-secondary d-md-none mr-auto mr-2"
      id="menu-toggle"
    >
      &laquo; Menu
    </button>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarResponsive"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collpase navbar-collapse" id="navbarResponsive">
      <!-- dekstop menu -->
      <ul class="navbar-nav d-none d-lg-flex ml-auto">
        <li class="nav-item dropdown">
          <a
            href="#"
            class="nav-link"
            id="navbarDropdown"
            role="button"
            data-toggle="dropdown"
          >
            <img
              src="../assets/images/user_pc.png"
              alt="profile"
              class="rounded-circle mr-2 profile-picture"
            />
            Hi, Hafizh
          </a>
          <div class="dropdown-menu">
            <a href="/dashboard.html" class="dropdown-item"
              >Dashboard</a
            >
            <a href="/dashboard-account.html" class="dropdown-item"
              >Settings</a
            >
            <div class="dropdown-divider"></div>
            <a href="/" class="dropdown-item">logout</a>
          </div>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link d-inline-bloc mt-2">
            <img
              src="../assets/images/shopping-cart-filled.svg"
              alt="cart-empty"
            />
            <div class="cart-badge">7</div>
          </a>
        </li>
      </ul>

      <!-- mobile app -->
      <ul class="navbar-nav d-block d-lg-none">
        <li class="nav-item">
          <a href="" class="nav-link"> Hi, Hafizh </a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link d-inline-block"> Cart </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div
  class="section-content section-dashboard-home"
  data-aos="fade-up"
>
  <div class="container-fluid">
    <div class="dashboard-heading">
      <h2 class="dashboard-title"><?= $product["product_name"]; ?></h2>
      <p class="dashboard-subtitle">Product Details</p>
    </div>
    <div class="dashboard-content">
      <div class="row">
        <div class="col-12 mt-2">
          <form action="" method="POST">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                  <input type="hidden" value="<?= $product["id_product"]; ?>" name="id">
                    <div class="form-group">
                      <label for="name">Nama Produk</label>
                      <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        value="<?= $product["product_name"]; ?>"
                      />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="price">Harga Produk</label>
                      <input
                        type="number"
                        name="price"
                        id="price"
                        class="form-control"
                        value="<?= $product["price"]; ?>"
                      />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="unit">Satuan Produk</label>
                      <?php 
                        $units = query("SELECT * FROM units");
                      ?>
                      <select
                        name="unit"
                        id="unit"
                        class="form-control"
                      >
                      <?php foreach ($units as $unit) : ?>
                        <option value="<?= $unit["id"]; ?>" <?= $unit["id"] == $product["unit_id"] ? 'selected' : ''; ?>><?= $unit["unit_name"]; ?></option>
                      <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="category">Category</label>
                      <?php 
                        $categories = query("SELECT * FROM categories");
                      ?>
                      <select
                        name="category"
                        id="category"
                        class="form-control"
                      >
                      <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category["id"]; ?>" <?= $category["id"] == $product["category_id"] ? 'selected' : ''; ?>><?= $category["category_name"]; ?></option>
                      <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="stock">Stok Produk</label>
                      <select name="stock" id="stock" class="form-control">
                        <option value="<?= $product["stock"]; ?>" selected><?= $product["stock"]; ?></option>
                        <option value="STOCK">STOCK</option>
                        <option value="SOLD OUT">SOLD OUT</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Descriptions</label>
                      <textarea name="descriptions" id="editor"><?= $product["descriptions"]; ?></textarea>
                    </div>
                  </div>
                </div>
                <div class="row my-3">
                  <div class="col-12">
                    <button
                      type="submit"
                      name="updateProduk"
                      class="btn btn-success btn-block py-2"
                    >
                      Update Product
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="card my-4">
              <div class="card-body">
                <div class="row mt-2">
                  <div class="col-md-4 mb-3">
                    <div class="gallery-container">
                      <img
                        src="../assets/images/1.jpg"
                        alt=""
                        class="w-100"
                      />
                      <a href="#" class="delete-gallery">
                        <img
                          src="../assets/images/icon-delete.svg"
                          alt=""
                        />
                      </a>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="gallery-container">
                      <img
                        src="../assets/images/2.jpg"
                        alt=""
                        class="w-100"
                      />
                      <a href="#" class="delete-gallery">
                        <img
                          src="../assets/images/icon-delete.svg"
                          alt=""
                        />
                      </a>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="gallery-container">
                      <img
                        src="../assets/images/3.jpg"
                        alt=""
                        class="w-100"
                      />
                      <a href="#" class="delete-gallery">
                        <img
                          src="../assets/images/icon-delete.svg"
                          alt=""
                        />
                      </a>
                    </div>
                  </div>
                </div>
                <div class="row my-3">
                  <div class="col-12">
                    <input
                      type="file"
                      name="file"
                      id="file"
                      style="display: none"
                      multiple
                    />
                    <button
                      type="button"
                      name="save"
                      class="btn btn-secondary btn-block py-2"
                      onclick="thisFileUpload()"
                    >
                      Add Photo
                    </button>
                  </div>
                </div>
              </div>
            </div> -->
          </form>
        </div>
      </div>
    </div>
  </div>
</div>