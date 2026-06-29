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
                        <th scope="col" style="text-align: center;">Kode</th>
                        <th scope="col" style="text-align: center;">Nama Produk</th>
                        <th scope="col" style="text-align: center;">Satuan</th>
                        <th scope="col" style="text-align: center;">Harga Beli</th>
                        <th scope="col" style="text-align: center;">Harga Jual</th>
                        <th scope="col" style="text-align: center;">Aksi</th>
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
                            <td style="text-align: right;"><?php echo number_format($row['hargabeli']) ?></td>
                            <td style="text-align: right;"><?php echo number_format($row['hargajual']) ?></td>
                            <td style="text-align: center;">
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
                        <label>Kode Supplier</label>
                        <input type="text" name="kode" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label>Nama Supplier</label>
                        <input type="text" name="nama" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label>Alamat Supplier</label>
                        <input type="text" name="alamat" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label>Kota Supplier</label>
                        <input type="text" name="kota" class="form-control" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label>HP Supplier</label>
                        <input type="text" name="hp" class="form-control" autocomplete="off">
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
        $('.modal-title').text('Tambah Supplier');
    }

    function edit() {
        $('#form')[0].reset();
        $('#exampleModal').modal('show');
        $('.modal-title').text('Ganti Supplier');
    }

    function hapus() {

    }

    function simpan(){
        
    }
</script>