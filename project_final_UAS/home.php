<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "mydb";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$tanggal         = "";
$toilet_id       = "";
$kloset          = "";
$wastafel        = "";
$lantai          = "";
$dinding         = "";
$kaca            = "";
$bau             = "";
$sabun           = "";
$status           = "";
$sukses          = "";
$error           = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from checklist where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id              = $_GET['id'];
    $sql1            = "select * from checklist where id = '$id'";
    $q1              = mysqli_query($koneksi, $sql1);
    $r1              = mysqli_fetch_array($q1);
    $tanggal         = $r1['tanggal'];
    $toilet_id       = $r1['toilet_id'];
    $kloset          = $r1['kloset'];
    $wastafel        = $r1['wastafel'];
    $lantai          = $r1['lantai'];
    $dinding         = $r1['dinding'];
    $kaca            = $r1['kaca'];
    $bau             = $r1['bau'];
    $sabun           = $r1['sabun'];
    $status          = $r1['status'];

    if ($tanggal == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $tanggal            = $_POST['tanggal'];
    $toilet_id          = $_POST['toilet_id'];
    $kloset             = $_POST['kloset'];
    $wastafel           = $_POST['wastafel'];
    $lantai             = $_POST['lantai'];
    $dinding            = $_POST['dinding'];
    $kaca               = $_POST['kaca'];
    $bau                = $_POST['bau'];
    $sabun              = $_POST['sabun'];
    $status             = $_POST['status'];

    if ($tanggal && $toilet_id && $kloset && $wastafel && $lantai && $dinding && $kaca && $bau && $sabun && $status) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update checklist set tanggal = '$tanggal',toilet_id='$toilet_id',kloset = '$kloset',wastafel='$wastafel',lantai='$lantai',dindindg='$dinding',kaca='$kaca',bau='$bau',sabun='$sabun',status='$status' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into checklist(tanggal,toilet_id,kloset,wastafel,lantai,dinding,kaca,bau,sabun,status) values ('$tanggal','$toilet_id','$kloset','$wastafel','$lantai','$dinding','$kaca','$bau','$sabun','$status')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checklist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit checklist
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=home.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=home.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="tanggal" class="col-sm-2 col-form-label">TANGGAL</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?php echo $tanggal ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="toilet_id" class="col-sm-2 col-form-label">toilet_id</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="toilet_id" name="toilet_id" value="<?php echo $toilet_id ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="kloset" class="col-sm-2 col-form-label">Kloset</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="kloset" id="kloset">
                                <option value="">- Pilih Kondisi Kloset -</option>
                                <option value="bersih" <?php if ($kloset == "bersih") echo "selected" ?>>Bersih</option>
                                <option value="kotor" <?php if ($kloset == "kotor") echo "selected" ?>>Kotor</option>
                                <option value="rusak" <?php if ($kloset == "rusak") echo "selected" ?>>Rusak</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="wastafel" class="col-sm-2 col-form-label">Wastafel</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="wastafel" id="wastafel">
                                <option value="">- Pilih Kondisi Wastafel -</option>
                                <option value="bersih" <?php if ($wastafel == "bersih") echo "selected" ?>>Bersih</option>
                                <option value="kotor" <?php if ($wastafel == "kotor") echo "selected" ?>>Kotor</option>
                                <option value="rusak" <?php if ($wastafel == "rusak") echo "selected" ?>>Rusak</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="lantai" class="col-sm-2 col-form-label">Lantai</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="lantai" id="lantai">
                                <option value="">- Pilih Kondisi Lantai -</option>
                                <option value="bersih" <?php if ($lantai == "bersih") echo "selected" ?>>Bersih</option>
                                <option value="kotor" <?php if ($lantai == "kotor") echo "selected" ?>>Kotor</option>
                                <option value="rusak" <?php if ($lantai == "rusak") echo "selected" ?>>Rusak</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="dinding" class="col-sm-2 col-form-label">Dinding</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="dinding" id="dinding">
                                <option value="">- Pilih Kondisi Dinding -</option>
                                <option value="bersih" <?php if ($dinding == "bersih") echo "selected" ?>>Bersih</option>
                                <option value="kotor" <?php if ($dinding == "kotor") echo "selected" ?>>Kotor</option>
                                <option value="rusak" <?php if ($dinding == "rusak") echo "selected" ?>>Rusak</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="kaca" class="col-sm-2 col-form-label">Kaca</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="kaca" id="kaca">
                                <option value="">- Pilih Kondisi Kaca -</option>
                                <option value="bersih" <?php if ($kaca == "bersih") echo "selected" ?>>Bersih</option>
                                <option value="kotor" <?php if ($kaca == "kotor") echo "selected" ?>>Kotor</option>
                                <option value="rusak" <?php if ($kaca == "rusak") echo "selected" ?>>Rusak</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="bau" class="col-sm-2 col-form-label">Bau</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="bau" id="bau">
                                <option value="">- Pilih Kondisi Bau -</option>
                                <option value="ya" <?php if ($bau == "ya") echo "selected" ?>>Ya</option>
                                <option value="tidak" <?php if ($bau == "tidak") echo "selected" ?>>Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="sabun" class="col-sm-2 col-form-label">Sabun</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="sabun" id="sabun">
                                <option value="">- Pilih Kondisi Sabun -</option>
                                <option value="ada" <?php if ($sabun == "ada") echo "selected" ?>>Ada</option>
                                <option value="habis" <?php if ($sabun == "habis") echo "selected" ?>>Habis</option>
                                <option value="hilang" <?php if ($sabun == "hilang") echo "selected" ?>>Hilang</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="status" id="status">
                                <option value="">- Pilih Kondisi Status -</option>
                                <option value="aktif" <?php if ($status == "aktif") echo "selected" ?>>Aktif</option>
                                <option value="nonaktif" <?php if ($status == "nonaktif") echo "selected" ?>>Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Checklist
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Toilet_id</th>
                            <th scope="col">Kloset</th>
                            <th scope="col">Wastafel</th>
                            <th scope="col">Lantai</th>
                            <th scope="col">Dinding</th>
                            <th scope="col">Kaca</th>
                            <th scope="col">bau</th>
                            <th scope="col">Sabun</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from checklist order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id             = $r2['id'];
                            $tanggal        = $r2['tanggal'];
                            $toilet_id      = $r2['toilet_id'];
                            $kloset         = $r2['kloset'];
                            $wastafel       = $r2['wastafel'];
                            $lantai         = $r2['lantai'];
                            $dinding        = $r2['dinding'];
                            $kaca           = $r2['kaca'];
                            $bau            = $r2['bau'];
                            $sabun          = $r2['sabun'];
                            $status         = $r2['status'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $tanggal ?></td>
                                <td scope="row"><?php echo $toilet_id ?></td>
                                <td scope="row"><?php echo $kloset ?></td>
                                <td scope="row"><?php echo $wastafel ?></td>
                                <td scope="row"><?php echo $lantai ?></td>
                                <td scope="row"><?php echo $dinding ?></td>
                                <td scope="row"><?php echo $kaca ?></td>
                                <td scope="row"><?php echo $bau ?></td>
                                <td scope="row"><?php echo $sabun ?></td>
                                <td scope="row"><?php echo $status ?></td>
                                <td scope="row">
                                    <a href="home.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="home.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>in