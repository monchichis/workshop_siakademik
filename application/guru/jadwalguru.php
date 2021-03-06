<!-- Menampilkan Data Jadwal Guru (Indah) -->
<section class="content-header">
    <div class='alert alert-warning alert-dismissible fade in' role='alert'> 
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>×</span></button> 
    <strong>Perhatian!</strong> <br>Silahkan Pilih semester dan tahun akademik  dulu !!!
    </div>
</section>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?php if (isset($_GET[tahun])) {
                                        echo "Jadwal Mengajar Anda";
                                    } else {
                                        echo "Jadwal Mengajar Anda " . date('Y');
                                    } ?></h3>
            <form style='margin-right:5px; margin-top:0px' class='pull-right' action='' method='GET'>
                <input type='hidden' name='view' value='jadwalguru'>
                <select name='tahun' style='padding:4px'>
                <!-- Filter Tahun Akademik (Indah) -->
                    <?php
                    echo "<option value=''>- Pilih Tahun Akademik -</option>";
                    $tahun = mysqli_query($koneksi, "SELECT * FROM tahun_akademik");
                    while ($k = mysqli_fetch_array($tahun)) {
                        if ($_GET[tahun] == $k[id_tahun_akademik]) {
                            echo "<option value='$k[id_tahun_akademik]' selected>$k[nama_tahun]</option>";
                        } else {
                            echo "<option value='$k[id_tahun_akademik]'>$k[nama_tahun]</option>";
                        }
                    }
                    ?>
                </select>
                <input type="submit" style='margin-top:-4px' class='btn btn-success btn-sm' value='Lihat'>
            </form>

        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style='width:20px'>No</th>
                        <th>Kode Pelajaran</th>
                        <th>Jadwal Pelajaran</th>
                        <th>Kelas</th>
                        <th>Guru</th>
                        <th>Hari</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Ruangan</th>
                        <th>Semester</th>
                    </tr>
                </thead>
                <tbody>
                <!-- Relasi Mapel dan Guru -->
                    <?php
                    if (isset($_GET[tahun])) {
                        $tampil = mysqli_query($koneksi, "SELECT a.*, e.nama_kelas, b.namamatapelajaran, b.kode_pelajaran, c.nama_guru, d.nama_ruangan FROM jadwal_pelajaran a 
                                            JOIN mata_pelajaran b ON a.kode_pelajaran=b.kode_pelajaran
                                              JOIN guru c ON a.nip=c.nip 
                                                JOIN ruangan d ON a.kode_ruangan=d.kode_ruangan
                                                  JOIN kelas e ON a.kode_kelas=e.kode_kelas 
                                                  where a.nip='$_SESSION[id]' AND a.id_tahun_akademik='$_GET[tahun]' ORDER BY a.hari DESC");
                    } else {
                        $tampil = mysqli_query($koneksi, "SELECT a.*, e.nama_kelas, b.namamatapelajaran, b.kode_pelajaran, c.nama_guru, d.nama_ruangan FROM jadwal_pelajaran a 
                                            JOIN mata_pelajaran b ON a.kode_pelajaran=b.kode_pelajaran
                                              JOIN guru c ON a.nip=c.nip 
                                                JOIN ruangan d ON a.kode_ruangan=d.kode_ruangan
                                                JOIN kelas e ON a.kode_kelas=e.kode_kelas 
                                                  where a.nip='$_SESSION[id]' AND a.id_tahun_akademik LIKE '" . date('Y') . "%' ORDER BY a.hari DESC");
                    }
                    $no = 1;
                    while ($r = mysqli_fetch_array($tampil)) {
                        echo "<tr><td>$no</td>
                              <td>$r[kode_pelajaran]</td>
                              <td>$r[namamatapelajaran]</td>
                              <td>$r[nama_kelas]</td>
                              <td>$r[nama_guru]</td>
                              <td>$r[hari]</td>
                              <td>$r[jam_mulai]</td>
                              <td>$r[jam_selesai]</td>
                              <td>$r[nama_ruangan]</td>";
                              if ($_SESSION[level] != 'kepala') {
                                //   Lihat Absen (Indah)
                                echo "<td><a class='btn btn-xs btn-warning' href='index_guru.php?view=absensi_siswa'>Buka Absensi Siswa</a></td>";
                              }
                          echo"</tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div>
</div>