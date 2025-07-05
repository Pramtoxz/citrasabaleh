<script>
function showKamarDetail(id) {
    $.ajax({
        url: "<?= site_url('kamar/show/') ?>" + id,
        type: "GET",
        dataType: "json",
        success: function(response) {
            if(response.status) {
                const data = response.data;
                Swal.fire({
                    title: 'Detail Kamar: ' + data.nama,
                    html: `
                        <div class="text-center mb-3">
                            <img src="${data.gambar_url}" alt="Gambar Kamar" class="kamar-image" style="max-width: 100%; max-height: 300px; border-radius: 8px;">
                        </div>
                        <div class="text-start">
                            <table class="table table-borderless">
                                <tr>
                                    <td style="width: 130px;"><strong>ID Kamar</strong></td>
                                    <td>${data.idkamar}</td>
                                </tr>
                                <tr>
                                    <td><strong>Harga</strong></td>
                                    <td>${data.harga_formatted}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kapasitas</strong></td>
                                    <td>${data.kapasitas} orang</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>${data.status_text == 'Tersedia' ? 
                                        '<span class="badge bg-success">Tersedia</span>' : 
                                        '<span class="badge bg-danger">Tidak Tersedia</span>'}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat</strong></td>
                                    <td>${data.created_at_formatted}</td>
                                </tr>
                                <tr>
                                    <td><strong>Diupdate</strong></td>
                                    <td>${data.updated_at_formatted}</td>
                                </tr>
                            </table>
                            
                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #eee;">
                                <h6 class="fw-bold mb-2">Deskripsi</h6>
                                <div>${data.deskripsi}</div>
                            </div>
                        </div>
                    `,
                    width: '650px',
                    confirmButtonText: 'Tutup',
                    showDenyButton: true,
                    denyButtonText: 'Edit',
                    denyButtonColor: '#FFA500'
                }).then((result) => {
                    if (result.isDenied) {
                        window.location.href = '<?= site_url('kamar/edit/') ?>' + id;
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: response.message,
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Gagal mengambil data kamar',
            });
        }
    });
}
</script> 