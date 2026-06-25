<div>
    <div class="bg-body-tertiary p-5 rounded">
        <div class="col-sm-12 mx-auto">
            <h1>Data Supplier</h1>
            <hr>
            <button type="button" class="btn btn-primary" onclick="add()">
                Tambah Data
            </button>

            <table class="table" style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th scope="col">Kode</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Kota</th>
                        <th scope="col">HP</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conn, "select * from supplier");
                    while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                        <tr>
                            <th><?php echo $row['id'] ?></th>
                            <td><?php echo $row['nama'] ?></td>
                            <td><?php echo $row['alamat'] ?></td>
                            <td><?php echo $row['kota'] ?></td>
                            <td><?php echo $row['hp'] ?></td>
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
                        <label></label>
                        <input type="text" class="form-control" autocomplete="off">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
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
</script>