<?php
    //Koneksi Database
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "dblatihan";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

    //jika tombol simpan di klik
    if(isset($_POST['bsimpan']))
    {
        //pengujian apakah data akan di edit atau disimpan baru
        if($_GET['hal'] == "edit")
        {
            //data akan di edit
            $edit = mysqli_query($koneksi, "UPDATE tmhs set 
                                              nis = '$_POST[tnis]',
                                              nama = '$_POST[tnama]',
                                              alamat = '$_POST[talamat]',
                                              prodi = '$_POST[tprodi]'
                                            WHERE id_mhs = '$_GET[id]'
                                           ");
            if($edit) //jika edit sukses    
            {
                echo "<script>
                        alert('Edit Data Suksess!');
                        document.location='index.php';
                     </script>";
            }     
            else
            {
                echo "<script>
                        alert('Edit Data Gagal!!');
                        document.location='index.php';
                     </script>"; 
            }
        }
        else
        {
            //data akan disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nis, nama, alamat, prodi)
                                              VALUES ('$_POST[tnis]',
                                                      '$_POST[tnama]',
                                                      '$_POST[talamat]',
                                                      '$_POST[tprodi]')
                                        ");
            if($simpan) //jika simpan sukses    
            {
                echo "<script>
                        alert('Simpan Data Suksess!');
                        document.location='index.php';
                     </script>";
            }     
            else
            {
                echo "<script>
                        alert('Simpan Data Gagal!!');
                        document.location='index.php';
                     </script>"; 
            }  
        }


                        
    }

    //pengujian jika tombol edit atau hapus di klik
    if(isset($_GET['hal']))
    {
        //pengujian jika edit data
        if($_GET['hal'] == "edit")
        {
            //tampilkan data yang akan di edit
            $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                //jika data ditemukan maka data ditampung ke dalam variabel
                $vnis = $data['nis'];
                $vnama = $data['nama'];
                $valamat = $data['alamat'];
                $vprodi = $data['prodi'];
            }
        }
        else if ($_GET['hal'] == "hapus")
        {
            //persiapan hapus data
            $hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]' ");
            if($hapus){
                echo "<script>
                        alert('Hapus Data Suksess!!');
                        document.location='index.php';
                     </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD BIODATA SISWA</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
   <h1 class="text-center">CRUD BIODATA SISWA</h1>
   <h2 class="text-center">SMK Negeri 1 Purwosari</h2>   

<!-- ini awal curd form -->
   <div class="card mt-8">
     <div class="card-header bg-primary text-white">
    Form Input Data Siswa
     </div>
     <div class="card-body">
       <form method="post" action="">
           <div class="form group">
               <label>Nis</label>
               <input type="text" name="tnis" value="<?=@$vnis?>" class="form-control" placeholder="Input Nis Anda Disini!" required>
           </div>
           <div class="form group">
               <label>Nama</label>
               <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama Anda Disini!" required>
           </div>
           <div class="form group">
               <label>Alamat</label>
               <textarea class="form-control" name="talamat" placeholder="Input Alamat Anda Disini!"><?=@$valamat?></textarea>
           </div>
           <div class="form group">
               <label>Prodi</label>
               <select class="form-control" name="tprodi">
                   <option value="<?=@$vprodi?>"><?=@$vprodi?></option>
                   <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                   <option value="Multimedia">Multimedia</option>
                   <option value="Mekatronika">Mekatronika</option>
                   <option value="Tehnik Komputer Jaringan">Tehnik Komputer Jaringan</option>
               </select>
           </div>

           <button type="submit" class="btn btn-success mt-2" name="bsimpan">Simpan</button>
           <button type="reset" class="btn btn-danger mt-2" name="breset">Kosongkan</button>

       </form>
     </div>
   </div>
<!-- akhir card form -->

<!-- ini awal curd table -->
<div class="card mt-8">
     <div class="card-header bg-success text-white">
    Daftar Siswa
     </div>
     <div class="card-body">
       
       <table class="table table-bordered table-striped">
           <tr>
               <th>No.</th>
               <th>Nis</th>
               <th>Nama</th>
               <th>Alamat</th>
               <th>Prodi</th>
               <th>Aksi</th>
           </tr>
           <?php
               $no = 1;
               $tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_mhs desc")or die(mysqli_error($koneksi));
               while($data = mysqli_fetch_array($tampil)) :

           ?>
           <tr>
               <td><?=$no++;?></td>
               <td><?=$data['nis']?></td>
               <td><?=$data['nama']?></td>
               <td><?=$data['alamat']?></td>
               <td><?=$data['prodi']?></td>
               <td>
                   <a href="index.php?hal=edit&id=<?=$data['id_mhs']?>" class="btn btn-warning"> Edit </a>
                   <a href="index.php?hal=hapus&id=<?=$data['id_mhs']?>" onclick="return confirm('Apakah Yakin Ingin Menghapus Data Ini?')" class="btn btn-danger"> Hapus </a>
               </td>
           </tr>
           <?php endwhile; //penutup perulangan while ?>
       </table>

     </div>
   </div>
<!-- akhir card table -->

</div>

<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>