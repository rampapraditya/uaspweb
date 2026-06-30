<div>
    <div class="bg-body-tertiary p-5 rounded">
        <div class="col-sm-12 mx-auto">
            <h1>Data Produk</h1>
            <hr>
            <button type="button" class="btn btn-primary" onclick="add()">
                Tambah Data
            </button>

            <table class="table" style="margin-top: 20px;">
                <thead>
                    <tr>
<<<<<<< HEAD
                        <th scope="col">Kode Produk</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Harga Jual</th>
                         <th scope="col">Harga Beli</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conn, "select * from produk");
                    while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                        <tr>
                            <th><?php echo $row['id'] ?></th>
                            <td><?php echo $row['nama'] ?></td>
                            <td><?php echo $row['satuan'] ?></td>
                            <td><?php echo $row['hargabeli'] ?></td>
                            <td><?php echo $row['hargajual'] ?></td>
                            <td>
                                <button type="button" class="btn btn-warning" onclick="edit()">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-danger">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
=======
                        <th scope="col" style="text-align: center;">Kode</th>
                        <th scope="col" style="text-align: center;">Nama Produk</th>
                        <th scope="col" style="text-align: center;">Satuan</th>
                        <th scope="col" style="text-align: center;">Harga Beli</th>
                        <th scope="col" style="text-align: center;">Harga Jual</th>
                        <th scope="col" style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="data-produk">
>>>>>>> b9d8ac8ae3d159a0e466a7d31d673e32e26ef033
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <div class="mb-3">
                        <label>Kode Produk</label>
<<<<<<< HEAD
                        <input type="text" name="kode_produk" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label>Satuan</label>
                        <input type="text" name="satuan" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label>Harga Jual</label>
                        <input type="text" name="harga_jual" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label>Harga Beli</label>
                        <input type="text" name="harga_beli" class="form-control" autocomplete="off">
=======
                        <input type="text" id="kode" name="kode" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label>Nama Produk</label>
                        <input type="text" id="nama" name="nama" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label>Satuan</label>
                        <input type="text" id="satuan" name="satuan" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label>Harga Beli</label>
                        <input type="text" id="hargabeli" name="hargabeli" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label>Harga Jual</label>
                        <input type="text" id="hargajual" name="hargajual" class="form-control" autocomplete="off">
>>>>>>> b9d8ac8ae3d159a0e466a7d31d673e32e26ef033
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="simpan()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
<<<<<<< HEAD
    function add() {
        $('#form')[0].reset();
        $('#exampleModal').modal('show');
        $('.modal-title').text('Tambah Produk');
    }

    function edit() {
        $('#form')[0].reset();
        $('#exampleModal').modal('show');
        $('.modal-title').text('Ganti Produk');
    }

    function hapus() {

    }

    function simpan(){
         $('#form')[0].reset();
        $('#exampleModal').modal('show');
        $('.modal-title').text('simpan produk');
        
    }
=======
    let save_method = "";

    $(document).ready(function() {
        loadData();
    });

    function loadData() {
        $.ajax({
            url: 'pages/produk/proses.php',
            type: 'POST',
            data: {
                aksi: 'tampil_data'
            },
            success: function(response) {
                $('#data-produk').html(response);
            },
            error: function(xhr, status, error) {
                $('#data-produk').html("<tr><td colspan='6' style='text-align:center; color:red;'>Gagal memuat data dari server.</td></tr>");
            }
        });
    }

    function add() {
        $('#form')[0].reset();
        save_method = "add";
        $('#exampleModal').modal('show');
        $('.modal-title').text('Tambah Produk');
        $('#kode').attr('readonly', false);
    }

    function simpan() {
        let kode = document.getElementById('kode').value;
        let nama = document.getElementById('nama').value;
        let satuan = document.getElementById('satuan').value;
        let hargabeli = document.getElementById('hargabeli').value;
        let hargajual = document.getElementById('hargajual').value;

        if (kode == "") {
            alert("Kode produk tidak boleh kosong");
        } else if (nama == "") {
            alert("Nama produk tidak boleh kosong");
        } else if (satuan == "") {
            alert("Satuan tidak boleh kosong");
        } else if (hargabeli == "") {
            alert("Harga beli tidak boleh kosong");
        } else if (hargajual == "") {
            alert("Harga jual tidak boleh kosong");
        } else {

            var form_data = new FormData();

            if (save_method === 'add') {
                form_data.append('aksi', "simpan");
            } else {
                form_data.append('aksi', "ganti");
            }

            form_data.append('kode', kode);
            form_data.append('nama', nama);
            form_data.append('satuan', satuan);
            form_data.append('hargabeli', hargabeli);
            form_data.append('hargajual', hargajual);

            $.ajax({
                url: "pages/produk/proses.php",
                dataType: 'TEXT',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function(response, status, xhr) {
                    alert(response);
                    $('#exampleModal').modal('hide');
                    loadData();
                },
                error: function(response, status, xhr) {
                    alert(status);
                }
            });
        }
    }

    function edit(id) {
        $('#form')[0].reset();
        $('#exampleModal').modal('show');
        $('.modal-title').text('Ganti Produk');

        let form_data = new FormData();
        form_data.append('aksi', 'ambil_data');
        form_data.append('kode', id);

        // Jalankan AJAX
        $.ajax({
            url: 'pages/produk/proses.php',
            type: 'POST',
            data: form_data,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function(response) {
                if (response.status === 'sukses') {
                    $('#kode').attr('readonly', true); // biar tidak bisa di edit
                    $('#kode').val(response.data.id);
                    $('#nama').val(response.data.nama);
                    $('#satuan').val(response.data.satuan);
                    $('#hargabeli').val(response.data.hargabeli);
                    $('#hargajual').val(response.data.hargajual);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Gagal mengambil data untuk edit:', error);
            }
        });
    }

    function hapus(id, nama) {
        if (confirm("Apakah Anda yakin ingin menghapus produk '" + nama + "' (Kode: " + id + ")?")) {
            let form_data = new FormData();
            form_data.append('aksi', 'hapus_data');
            form_data.append('kode', id);

            $.ajax({
                url: "pages/produk/proses.php",
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                dataType: 'TEXT',
                success: function(response) {
                    alert(response);
                    loadData();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(textStatus);
                }
            });
        }
    }

>>>>>>> b9d8ac8ae3d159a0e466a7d31d673e32e26ef033
</script>