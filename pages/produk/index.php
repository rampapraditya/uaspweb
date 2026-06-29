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
                <tbody id="data-produk">

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
    $(document).ready(function() {
        loadData();
    });

    // Fungsi untuk mengambil string HTML dari proses.php
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
        $('#exampleModal').modal('show');
        $('.modal-title').text('Tambah Supplier');
    }

    function edit() {
        $('#form')[0].reset();
        $('#exampleModal').modal('show');
        $('.modal-title').text('Ganti Supplier');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var nama = document.getElementById('nama').value;

        if (nama === '') {
            iziToast.error({
                title: 'Error',
                message: "Access name cannot be empty",
                position: 'topRight'
            });
        } else {
            $('#btnSave').text('Loading...');
            $('#btnSave').attr('disabled', true);

            var url = "";
            if (save_method === 'add') {
                url = "";
            } else {
                url = "";
            }

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('nama', nama);

            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                success: function(response, status, xhr) {
                    var csrfToken = xhr.getResponseHeader('X-CSRF-TOKEN');
                    $('meta[name="csrf-token"]').attr('content', csrfToken);

                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled', false);

                    if (response.status == "Data saved") {
                        iziToast.success({
                            title: 'Info',
                            message: response.status,
                            position: 'topRight'
                        });
                        reload();
                        $('#modal_form').modal('hide');
                    } else {
                        iziToast.warning({
                            title: 'Info',
                            message: response.status,
                            position: 'topRight'
                        });
                    }

                },
                error: function(response, status, xhr) {
                    var csrfToken = xhr.getResponseHeader('X-CSRF-TOKEN');
                    $('meta[name="csrf-token"]').attr('content', csrfToken);

                    iziToast.error({
                        title: 'Error',
                        message: "Error json " + errorThrown,
                        position: 'topRight'
                    });

                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled', false);
                }
            });
        }
    }

    function hapus(id, nama) {
        iziToast.show({
            color: 'dark',
            icon: 'fas fa-question',
            title: 'Confirmation',
            message: 'Are you sure you want to remove access ' + nama + ' ?',
            position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
            progressBarColor: 'rgb(0, 255, 184)',
            buttons: [
                [
                    '<button>Ok</button>',
                    function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOutUp'
                        }, toast);

                        $.ajax({
                            url: "" + id,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data) {
                                iziToast.success({
                                    title: 'Info',
                                    message: data.status,
                                    position: 'topRight'
                                });
                                reload();

                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                iziToast.error({
                                    title: 'Error',
                                    message: "Error json " + errorThrown,
                                    position: 'topRight'
                                });
                            }
                        });
                    }
                ],
                [
                    '<button>Close</button>',
                    function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOutUp'
                        }, toast);
                    }
                ]
            ]
        });
    }

    function ganti(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Change Access');
        $.ajax({
            url: "" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="kode"]').val(data.idakses);
                $('[name="nama"]').val(data.namaakses);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }
</script>