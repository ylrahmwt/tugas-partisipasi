<?php

    session_start();

    require "../fungsi.php";

    if(!isset($_SESSION['login'])){
        header("Location: ../login.php");
        exit;
    }

    if($_SESSION['peran'] != "pelamar"){
        header("Location: ../login.php");
        exit;
    }

    if(isset($_POST['registrasi'])){

    $hasil = registrasi($_POST);

    if($hasil > 0){
        echo "<script>
        alert('Data berhasil disimpan');
        document.location.href='registrasi.php';
        </script>";
    }else{
        echo "<script>alert('Data gagal disimpan');</script>";
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi siswa baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/style.css">
    
    <style>
        /* --- CSS Tampilan Polos & Minimalis (Sesuai Gambar 1.png) --- */
        body {
            background-color: #f4f6f9; /* Background luar abu-abu datar */
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #333333;
        }

        /* Container Pembungkus Card */
        .wrapper-registrasi {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 15px;
            min-height: calc(100vh - 56px);
        }

        /* Card Putih Polos */
        .card-form {
            background: #ffffff;
            max-width: 650px; /* Lebar dibatasi agar tidak full screen */
            width: 100%;
            padding: 30px;
            border-radius: 4px; /* Sudut kotak tegas minimalis */
            border: 1px solid #d2d6de; /* Garis tepi tipis standar */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); /* Shadow sangat tipis */
        }

        /* Desain Input Polos */
        .form-group-simple {
            margin-bottom: 18px;
        }

        .form-group-simple label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            font-size: 14px;
            color: #444444;
        }

        .form-group-simple input:not([type="radio"]), 
        .form-group-simple select, 
        .form-group-simple textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
            color: #555555;
            background-color: #ffffff;
            transition: border-color 0.15s ease-in-out;
        }

        /* Highlight Hijau saat Input Aktif */
        .form-group-simple input:focus, 
        .form-group-simple select:focus, 
        .form-group-simple textarea:focus {
            border-color: #00a65a;
            outline: 0;
        }

        /* Baris Sejajar untuk Tempat & Tanggal Lahir */
        .row-inline {
            display: flex;
            gap: 15px;
        }
        .row-inline .form-group-simple {
            flex: 1;
        }

        /* Desain Radio Box Pilihan Jenis Kelamin */
        .radio-group {
            display: flex;
            gap: 20px;
            padding: 8px 0;
        }

        /* Tombol Hijau Khas e-SPMB */
        .btn-green {
            background-color: #00a65a;
            color: #ffffff;
            border: 1px solid #008d4c;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 3px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.1s ease-in-out;
        }

        .btn-green:hover {
            background-color: #008d4c;
            color: #ffffff;
        }

        /* Footer Form */
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #f4f4f4;
        }

        .form-footer a {
            color: #3c8dbc;
            text-decoration: none;
            font-size: 14px;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        /* Tampilan Box Data Jika Sudah Terdaftar */
        .data-box-simple {
            border: 1px solid #d2d6de;
            background-color: #fafafa;
            padding: 15px;
            border-radius: 3px;
            margin-bottom: 20px;
        }

        .data-box-simple h5 {
            border-bottom: 1px solid #eeeeee;
            padding-bottom: 8px;
            margin-bottom: 12px;
            font-weight: 600;
            color: #444;
        }

        .data-list-simple {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .data-list-simple li {
            font-size: 14px;
            padding: 5px 0;
            color: #555;
        }

        .data-list-simple strong {
            display: inline-block;
            width: 150px;
            color: #333;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ASPMB</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link active" href="registrasi.php">Registrasi</a></li>
                    <li class="nav-item"><a class="nav-link active" href="dokumen.php">Dokumen</a></li>
                    <li class="nav-item"><a class="nav-link active" href="kelulusan.php">Kelulusan</a></li>
                    <li class="nav-item"><a class="nav-link active" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="wrapper-registrasi">
        <div class="card-form">

            <?php 
                $username = $_SESSION['username'];
                
                // JIKA BELUM REGISTRASI
                if(cekRegistrasi($username) == 0):
            ?>
                
                <h4 class="text-center" style="font-weight: 600; margin-bottom: 5px;">Formulir Registrasi</h4>
                <p class="text-center text-muted" style="font-size: 14px; margin-bottom: 25px;">Silahkan lengkapi informasi biodata Anda di bawah ini.</p>

                <form action="" method="POST">
                    <input type="hidden" name="username" value="<?= $username; ?>">
                    
                    <div class="form-group-simple">
                        <label for="namaDepan">Nama Depan</label>
                        <input type="text" name="namaDepan" id="namaDepan" placeholder="Nama Depan" required>
                    </div>

                    <div class="form-group-simple">
                        <label for="namaBelakang">Nama Belakang</label>
                        <input type="text" name="namaBelakang" id="namaBelakang" placeholder="Nama Belakang">
                    </div>

                    <div class="row-inline">
                        <div class="form-group-simple">
                            <label for="tempatLahir">Tempat Lahir</label>
                            <input type="text" name="tempatLahir" id="tempatLahir" placeholder="Tempat Lahir" required>
                        </div>
                        <div class="form-group-simple">
                            <label for="tglLahir">Tanggal Lahir</label>
                            <input type="date" name="tglLahir" id="tglLahir" required>
                        </div>
                    </div>

                    <div class="form-group-simple">
                        <label>Jenis Kelamin</label>
                        <div class="radio-group">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenisKelamin" id="Laki-laki" value="Laki-laki" required>
                                <label class="form-check-label" for="Laki-laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="jenisKelamin" id="Perempuan" value="Perempuan" required>
                                <label class="form-check-label" for="Perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-simple">
                        <label for="nisn">NISN</label>
                        <input type="text" name="nisn" id="nisn" maxlength="10" placeholder="Nomor NISN (10 Digit)" required>
                    </div>

                    <div class="form-group-simple">
                        <label for="agama">Agama</label>
                        <select name="agama" id="agama" required>
                            <option value="">-- Pilih Agama --</option>
                            <option value="Islam">Islam</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Protestan">Protestan</option>
                            <option value="Katholik">Katholik</option>
                            <option value="Budha">Budha</option>
                        </select>
                    </div>

                    <div class="form-group-simple">
                        <label for="asalSekolah">Asal Sekolah</label>
                        <input type="text" name="sekolahAsal" id="asalSekolah" placeholder="Nama Asal Sekolah" required>
                    </div>

                    <div class="form-group-simple">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3" placeholder="Alamat Lengkap Rumah" required></textarea>
                    </div>

                    <div class="form-group-simple">
                        <label for="telepon">Telepon/WA</label>
                        <input type="text" name="telepon" id="telepon" placeholder="Nomor Telepon Aktif" required>
                    </div>

                    <h5 style="border-bottom: 1px solid #eee; padding-bottom: 8px; margin: 25px 0 15px 0; font-weight: 600;">Data Orang Tua</h5>

                    <div class="form-group-simple">
                        <label for="namaAyah">Nama Ayah</label>
                        <input type="text" name="namaAyah" id="namaAyah" placeholder="Nama Lengkap Ayah" required>
                    </div>

                    <div class="form-group-simple">
                        <label for="pekerjaanAyah">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaanAyah" id="pekerjaanAyah" placeholder="Pekerjaan Ayah" required>
                    </div>

                    <div class="form-group-simple">
                        <label for="penghasilanAyah">Penghasilan Ayah</label>
                        <input type="number" name="penghasilanAyah" id="penghasilanAyah" placeholder="Nominal Penghasilan Ayah" required>
                    </div>

                    <div class="form-group-simple">
                        <label for="namaIbu">Nama Ibu</label>
                        <input type="text" name="namaIbu" id="namaIbu" placeholder="Nama Lengkap Ibu" required>
                    </div>

                    <div class="form-group-simple">
                        <label for="pekerjaanIbu">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaanIbu" id="pekerjaanIbu" placeholder="Pekerjaan Ibu" required>
                    </div>

                    <div class="form-group-simple">
                        <label for="penghasilanIbu">Penghasilan Ibu</label>
                        <input type="number" name="penghasilanIbu" id="penghasilanIbu" placeholder="Nominal Penghasilan Ibu" required>
                    </div>

                    <div class="form-footer">
                        <a href="index.php"> Kembali ke Beranda</a>
                        <button type="submit" name="registrasi" class="btn-green">Registrasi</button>
                    </div>

                </form>

            <?php 
                // JIKA SUDAH REGISTRASI (TAMPILKAN DATA HASIL REGISTRASI)
                else:
            ?>
                <h4 style="font-weight: 600; margin-bottom: 5px;">Data Hasil Registrasi</h4>
                <p class="text-muted" style="font-size: 14px; margin-bottom: 20px;">Anda sudah melengkapi formulir pendaftaran. Berikut adalah rincian data Anda:</p>
                
                <?php 
                    $dataPendaftar = tampilPendaftar($username);
                    foreach($dataPendaftar as $pendaftar):
                ?>
                    
                    <div class="data-box-simple">
                        <h5>Data Pelamar</h5>
                        <ul class="data-list-simple">
                            <li><strong>Nama Depan</strong>: <?= htmlspecialchars($pendaftar['namaDepan']); ?></li>
                            <li><strong>Nama Belakang</strong>: <?= htmlspecialchars($pendaftar['namaBelakang']); ?></li>
                            <li><strong>Tempat Lahir</strong>: <?= htmlspecialchars($pendaftar['tempatLahir']); ?></li>
                            <li><strong>Tanggal Lahir</strong>: <?= htmlspecialchars($pendaftar['tglLahir']); ?></li>
                            <li><strong>Jenis Kelamin</strong>: <?= htmlspecialchars($pendaftar['jenisKelamin']); ?></li>
                            <li><strong>NISN</strong>: <?= htmlspecialchars($pendaftar['nisn']); ?></li>
                            <li><strong>Agama</strong>: <?= htmlspecialchars($pendaftar['agama']); ?></li>
                            <li><strong>Asal Sekolah</strong>: <?= htmlspecialchars($pendaftar['sekolahAsal']); ?></li>
                            <li><strong>Alamat</strong>: <?= htmlspecialchars($pendaftar['alamat']); ?></li>
                            <li><strong>Telepon/WA</strong>: <?= htmlspecialchars($pendaftar['telepon']); ?></li>
                        </ul>
                    </div>

                    <div class="data-box-simple">
                        <h5>Data Orang Tua</h5>
                        <ul class="data-list-simple">
                            <li><strong>Nama Ayah</strong>: <?= htmlspecialchars($pendaftar['namaAyah']); ?></li>
                            <li><strong>Pekerjaan Ayah</strong>: <?= htmlspecialchars($pendaftar['pekerjaanAyah']); ?></li>
                            <li><strong>Penghasilan Ayah</strong>: Rp <?= number_format($pendaftar['penghasilanAyah'], 0, ',', '.'); ?></li>
                            <li><strong>Nama Ibu</strong>: <?= htmlspecialchars($pendaftar['namaIbu']); ?></li>
                            <li><strong>Pekerjaan Ibu</strong>: <?= htmlspecialchars($pendaftar['pekerjaanIbu']); ?></li>
                            <li><strong>Penghasilan Ibu</strong>: Rp <?= number_format($pendaftar['penghasilanIbu'], 0, ',', '.'); ?></li>
                        </ul>
                    </div>

                <?php
                    endforeach;
                endif;
                ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>         
</body>
</html>