<div>
    <div class="bg-body-tertiary p-5 rounded">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0"><i class="bi bi-bag-check"></i> Data Pembelian</h2>
                    <a href="index.php?menu=tambah-pembelian" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Tambah Pembelian
                    </a>
                </div>
                <hr>
                <div class="row g-3 mb-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" class="form-control" value="<?= $_GET['tanggal_awal'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" class="form-control" value="<?= $_GET['tanggal_akhir'] ?? '' ?>">
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-primary"><i class="bi bi-funnel"></i> Filter</button>
                            <button type="button" class="btn btn-secondary"><i class="bi bi-arrow-counterclockwise"></i> Reset</button>
                            <button type="button" class="btn btn-dark" onclick="window.print()"><i class="bi bi-printer"></i> Print</button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="140">Aksi</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Supplier</th>
                                <th>No HP</th>
                                <th class="text-end">Grand Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
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
    </script>