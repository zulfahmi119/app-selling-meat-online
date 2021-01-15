<?php 
// Database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'daging_online';

$conn = mysqli_connect($host, $user, $password, $dbname);


// query
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

// Data Produk
function tambahProduk($data)
{
    global $conn;

    $name = htmlspecialchars($data["name"]);
    $price = $data["price"];
    $unit = $data["unit"];
    $category = $data["category"];
    $stock = $data["stock"];
    $descriptions = $data["descriptions"];

    $query = "INSERT INTO products
                VALUES
                ('', '$name', '$unit', '$price', '$descriptions', '$category', '$stock')
            ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function updateProduk($data)
{
    global $conn;

    $id = $data["id"];
    $name = htmlspecialchars($data["name"]);
    $price = $data["price"];
    $unit = $data["unit"];
    $category = $data["category"];
    $stock = $data["stock"];
    $descriptions = $data["descriptions"];

    $query = "UPDATE products SET
                product_name = '$name',
                unit_id = '$unit',
                price = '$price',
                descriptions = '$descriptions',
                category_id = '$category',
                stock = '$stock'
                WHERE id_product = $id
            ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapusProduk($id) 
{
    global $conn;

    mysqli_query($conn, "DELETE FROM products WHERE id_product = $id");
    return mysqli_affected_rows($conn);

}

// Data Gallery

function tambahGaleri($data)
{
    global $conn;
    $name = $data["name"];
    $photo = upload();
    if (!$photo) {
        return false;
    }

    $query = "INSERT INTO products_galleries
                VALUES
                ('', '$photo', '$name')
            ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function updateGaleri($data)
{
    global $conn;

    $id = $data["id"];
    $name = $data["name"];
    $photoLama = $data["photoLama"];
    if ($_FILES['photo']['error'] === 4) {
        $photo = $photoLama;
    } else {
        $photo = upload();
        if (!$photo) {
            return false;
        }
    }

    $query = "UPDATE products_galleries SET
                photos = '$photo',
                product_id = '$name'
                WHERE id_gallery = $id
            ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapusGallery($id) 
{
    global $conn;

    mysqli_query($conn, "DELETE FROM products_galleries WHERE id_gallery = $id");
    return mysqli_affected_rows($conn);

}

// Category

function tambahCategory($data)
{
    global $conn;
    $name = $data["name"];
    $slug = slug($name);

    $query = "INSERT INTO categories
                VALUES
                ('', '$name', '$slug')
            ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function updateCategory($data)
{
    global $conn;

    $id = $data["id"];
    $name = $data["name"];
    $slug = slug($name);

    $query = "UPDATE categories SET
                category_name = '$name',
                slug = '$slug'
                WHERE id = $id
            ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapusCategories($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM categories WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function upload()
{
    $namaFile = $_FILES['photo']["name"];
    $size = $_FILES['photo']["size"];
    $error = $_FILES['photo']["error"];
    $tmpName = $_FILES['photo']["tmp_name"];

    if ($error === 4) {
        echo "<script>
            alert('Pilih Gambar Terlebih dahulu');
          </script>";
        return false;
    }

    $ekstensiGambarValid = ['png', 'jpg', 'jpeg'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                    alert('format gambar Harus (png, jpg atau jpeg)');
                </script>";
        return false;
    }

    if ($size > 10000000) {
        echo "<script>
                    alert('Ukuran file gambar harus < 10 Mb');
                </script>";
        return false;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;
    move_uploaded_file($tmpName, '../assets/images/' . $namaFileBaru);
    return $namaFileBaru;

}

function slug($text) 
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    $text = preg_replace('~[^-\w]+~', '', $text);

    $text = trim($text, '-');

    $text = preg_replace('~-+~', '-', $text);

    $text = strtolower($text);

    return $text;
}

?>