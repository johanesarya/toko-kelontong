<?php
$conn = mysqli_connect("localhost", "root", "", "dbkelontong");

if (isset($_POST['addnewbarang'])) {
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];

    $addtotable = mysqli_query($conn, "INSERT INTO tb_stok (namabrg, deskripsi,harga, stok) VALUES ('$namabarang','$deskripsi','$harga','$stock')");
    if ($addtotable) {
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

if (isset($_POST['barangmasuk'])) {
    $barang = $_POST['barang'];
    $qty = $_POST['qty']; // Menggunakan huruf besar POST

    $cekstoksekarang = mysqli_query($conn, "SELECT * FROM tb_stok WHERE idbrg='$barang'");
    $ambildata = mysqli_fetch_array($cekstoksekarang);
    $stoksekarang = $ambildata['stok'];
    $tambahstok = $stoksekarang + $qty;


    $addtomasuk = mysqli_query($conn, "INSERT INTO tb_masuk(idbrg, qty) VALUES('$barang', '$qty')");
    $updatemasuk = mysqli_query($conn, "UPDATE tb_stok SET stok='$tambahstok' WHERE idbrg='$barang'");
    if ($addtomasuk && $updatemasuk) {
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}

if (isset($_POST['barangkeluar'])) {
    $barang = $_POST['barang'];
    $qty = $_POST['qty']; // Menggunakan huruf besar POST

    $cekstoksekarang = mysqli_query($conn, "SELECT * FROM tb_stok WHERE idbrg='$barang'");
    $ambildata = mysqli_fetch_array($cekstoksekarang);
    $stoksekarang = $ambildata['stok'];
    $tambahstok = $stoksekarang - $qty;


    $addtomasuk = mysqli_query($conn, "INSERT INTO tb_keluar(idbrg, qty) VALUES('$barang', '$qty')");
    $updatemasuk = mysqli_query($conn, "UPDATE tb_stok SET stok='$tambahstok' WHERE idbrg='$barang'");
    if ($addtomasuk && $updatemasuk) {
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
}

if (isset($_POST['update'])) {
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    $update = mysqli_query($conn, "UPDATE tb_stok SET namabrg = '$namabarang',deskripsi='$deskripsi',harga='$harga' WHERE idbrg = '$idb'");
    if ($update) {
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

if (isset($_POST['hapus'])) {
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "DELETE FROM tb_stok WHERE idbrg='$idb'");
    if ($hapus) {
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

if (isset($_POST['updatemasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $namabarang = $_POST['namabarang'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM tb_stok WHERE idbrg = '$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stocksekarang = $stocknya['stok'];

    $qtyskrg = mysqli_query($conn, "SELECT * FROM tb_masuk WHERE idmasuk ='$idm");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if ($qty > $qtykrg) {
        $selisih = $qty - $qtyskrg;
        $kurangi = $stocksekarang + $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE tb_stock SET stok='$kurangi' WHERE idbrg = '$idb' ");
        $updatenya = mysqli_query($conn, "UPDATE tb_masuk SET qty = '$qty' WHERE idmasuk = '$idm'");
        if ($kurangistocknya && $updatenya) {
            header('location:masuk.php');
        } else {
            echo 'Gagal';
            header('location:masuk.php');
        }
    } else {
        $selisih = $qtyskrg - $qty;
        $kurangi = $stocksekarang - $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE tb_stock SET stok='$kurangi' WHERE idbrg = '$idb' ");
        $updatenya = mysqli_query($conn, "UPDATE tb_masuk SET qty = '$qty' WHERE idmasuk = '$idm'");
        if ($kurangistocknya && $updatenya) {
            header('location:masuk.php');
        } else {
            echo 'Gagal';
            header('location:masuk.php');
        }
    }
}

if (isset($_POST['hapusmasuk'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "SELECT * FROM tb_stok WHERE idbrg = '$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stok'];

    $selisih = $stock - $qty;

    $update = mysqli_query($conn, "UPDATE stok SET stok ='$selisih' WHERE idbrg = '$idbrg'");
    $hapusdata = mysqli_query($conn, "DELETE FROM tb_masuk WHERE idmasuk='$idm'");
    if ($update && $hapusdata) {
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}

if (isset($_POST['updatekeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $namabarang = $_POST['namabarang'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM tb_stok WHERE idbrg = '$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stocksekarang = $stocknya['stok'];

    $qtyskrg = mysqli_query($conn, "SELECT * FROM tb_keluar WHERE idkeluar ='$idk");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if ($qty > $qtykrg) {
        $selisih = $qty - $qtyskrg;
        $kurangi = $stocksekarang - $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE tb_stock SET stok='$kurangi' WHERE idbrg = '$idb' ");
        $updatenya = mysqli_query($conn, "UPDATE tb_keluar SET qty = '$qty' WHERE idkeluar = '$idk'");
        if ($kurangistocknya && $updatenya) {
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    } else {
        $selisih = $qtyskrg - $qty;
        $kurangi = $stocksekarang + $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE tb_stock SET stok='$kurangi' WHERE idbrg = '$idb' ");
        $updatenya = mysqli_query($conn, "UPDATE tb_keluar SET qty = '$qty' WHERE idkeluar = '$idk'");
        if ($kurangistocknya && $updatenya) {
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    }
}

if (isset($_POST['hapuskeluar'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn, "SELECT * FROM tb_stok WHERE idbrg = '$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stok'];

    $selisih = $stock + $qty;

    $update = mysqli_query($conn, "UPDATE stok SET stok ='$selisih' WHERE idbrg = '$idbrg'");
    $hapusdata = mysqli_query($conn, "DELETE FROM tb_keluar WHERE idkeluar='$idk'");
    if ($update && $hapusdata) {
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
}
