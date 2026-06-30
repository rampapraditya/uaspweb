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
</script>