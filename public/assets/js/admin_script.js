/**
 * Admin Script
 * File ini berisi script untuk template admin
 */

// Variabel global
let site_url = '';

// Fungsi untuk menginisialisasi aplikasi
function initializeApp() {
    // Dapatkan base URL dari meta tag
    const baseUrlMeta = document.querySelector('meta[name="base-url"]');
    if (baseUrlMeta) {
        site_url = baseUrlMeta.getAttribute('content');
        // Pastikan diakhiri dengan slash
        if (!site_url.endsWith('/')) {
            site_url += '/';
        }
    } else {
        // Fallback jika meta tag tidak ditemukan
        const currentUrl = window.location.href;
        const urlParts = currentUrl.split('/');
        site_url = urlParts[0] + '//' + urlParts[2] + '/';
    }
    
    // Inisialisasi komponen
    initSidebar();
    initTooltips();
    makeTableResponsive();
    initializeDatatables();
    reinitializeEvents();
    animateOnScroll();
}

// Document ready function
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi aplikasi
    initializeApp();
    
    // Inisialisasi sidebar
    initSidebar();
    
    // Inisialisasi tooltips
    initTooltips();
    
    // Buat tabel responsif
    makeTableResponsive();
    
    // Inisialisasi DataTables
    initializeDatatables();
    
    // Animasi saat scroll
    animateOnScroll();
});

// Fungsi untuk mengatur submenu di mobile
function setupMobileSubmenu() {
    // Toggle submenu on click for mobile
    const hasSubmenu = document.querySelectorAll('.has-submenu');
    hasSubmenu.forEach(item => {
        const link = item.querySelector('a[data-bs-toggle="collapse"]');
        if (link) {
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 991) {
                    e.preventDefault();
                    const submenu = document.querySelector(this.getAttribute('href'));
                    if (submenu) {
                        if (submenu.classList.contains('show')) {
                            new bootstrap.Collapse(submenu).hide();
                        } else {
                            new bootstrap.Collapse(submenu).show();
                        }
                    }
                }
            });
        }
    });
}

// Window load function
window.addEventListener('load', function() {
    // Hide loader
    const loader = document.querySelector('.loader-wrapper');
    if (loader) {
        setTimeout(function() {
            loader.style.opacity = '0';
            setTimeout(function() {
                loader.style.display = 'none';
            }, 500);
        }, 500);
    }
});

// Initialize tooltips
function initTooltips() {
    // Inisialisasi tooltip
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
}

// Animate elements when they scroll into view
function animateOnScroll() {
    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    
    if (animatedElements.length === 0) return;
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    animatedElements.forEach(el => {
        observer.observe(el);
    });
}

// Custom Sweet Alert confirmation
function confirmAction(title, text, icon, confirmBtn, callback) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmBtn,
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed && typeof callback === 'function') {
                callback();
            }
        });
    } else {
        if (confirm(text) && typeof callback === 'function') {
            callback();
        }
    }
}

// Show toast notification
function showToast(title, message, icon, position) {
    const Toast = Swal.mixin({
        toast: true,
        position: position || 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
    
    Toast.fire({
        icon: icon || 'success',
        title: title || 'Berhasil',
        text: message || ''
    });
}

// Responsive table handling
function makeTableResponsive() {
    // Wrap tabel dengan div responsive jika belum
    document.querySelectorAll('table.table').forEach(table => {
        if (!table.parentElement.classList.contains('table-responsive')) {
            const wrapper = document.createElement('div');
            wrapper.className = 'table-responsive';
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        }
    });
}

// Initialize DataTables with custom options
function initDataTable(selector, options) {
    const defaultOptions = {
        responsive: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            zeroRecords: "Tidak ada data yang ditemukan",
            info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data tersedia",
            infoFiltered: "(difilter dari total _MAX_ data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            },
        }
    };
    
    const mergedOptions = {...defaultOptions, ...options};
    return $(selector).DataTable(mergedOptions);
}

// Fungsi untuk menginisialisasi DataTables
function initializeDatatables() {
    // Periksa semua tabel dengan class datatable atau id yang mengandung datatable
    const datatableTables = document.querySelectorAll('table.datatable, table[id*="datatable"], .table-responsive table');
    
    if (datatableTables.length > 0) {
        // Pastikan jQuery dan DataTables tersedia
        if (typeof $ !== 'undefined' && $.fn.DataTable) {
            datatableTables.forEach(table => {
                // Periksa apakah tabel sudah diinisialisasi
                try {
                    // Hapus DataTable yang sudah ada jika ada
                    if ($.fn.DataTable.isDataTable(table)) {
                        $(table).DataTable().destroy();
                    }
                    
                    // Cari opsi konfigurasi dalam atribut data
                    let options = {};
                    if (table.dataset.options) {
                        try {
                            options = JSON.parse(table.dataset.options);
                        } catch (e) {
                            console.warn('Error parsing DataTable options', e);
                        }
                    }
                    
                    // Cari script inisialisasi DataTable di halaman
                    const tableId = table.id;
                    if (tableId) {
                        const scriptContent = Array.from(document.querySelectorAll('script')).map(s => s.textContent).join('\n');
                        if (scriptContent.includes(`$('#${tableId}').DataTable(`) || scriptContent.includes(`$('#${tableId}')`) && scriptContent.includes(`.DataTable(`)) {
                            // Jika ada script khusus untuk tabel ini, jangan inisialisasi di sini
                            // Itu akan ditangani oleh executePageScripts
                            return;
                        }
                    }
                    
                    // Inisialisasi DataTable dengan opsi default jika tidak ada script khusus
                    initDataTable(table, options);
                } catch (error) {
                    console.error('Error initializing DataTable:', error);
                }
            });
        } else {
            console.warn('jQuery or DataTables is not loaded');
            
            // Jika jQuery atau DataTables tidak tersedia, coba lagi setelah beberapa saat
            setTimeout(initializeDatatables, 500);
        }
    }
}

// Fungsi untuk menjalankan script halaman
function executePageScripts() {
    // Ambil semua script dalam konten utama
    const mainContent = document.querySelector('.main-content .container-fluid');
    if (!mainContent) return;
    
    const scripts = mainContent.querySelectorAll('script');
    scripts.forEach(script => {
        try {
            // Buat elemen script baru
            const newScript = document.createElement('script');
            
            // Salin atribut dari script lama
            Array.from(script.attributes).forEach(attr => {
                newScript.setAttribute(attr.name, attr.value);
            });
            
            // Salin konten script
            newScript.textContent = script.textContent;
            
            // Ganti script lama dengan yang baru untuk memicu eksekusi
            script.parentNode.replaceChild(newScript, script);
        } catch (e) {
            console.error('Error executing script:', e);
        }
    });
    
    // Reinisialisasi event handlers
    setTimeout(reinitializeEvents, 100);
}

// Fungsi untuk reinisialisasi komponen Bootstrap
function reinitializeBootstrapComponents() {
    // Inisialisasi tooltips
    initTooltips();
    
    // Inisialisasi popovers jika ada
    if (typeof bootstrap !== 'undefined' && bootstrap.Popover) {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    }
    
    // Buat tabel responsif
    makeTableResponsive();
}

// Fungsi untuk reinisialisasi event handlers
function reinitializeEvents() {
    // Reinisialisasi event untuk form konfirmasi
    document.querySelectorAll('form[data-confirm="true"], button[data-confirm="true"], a[data-confirm="true"]').forEach(el => {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            
            const title = this.dataset.confirmTitle || 'Konfirmasi';
            const text = this.dataset.confirmText || 'Apakah Anda yakin?';
            const icon = this.dataset.confirmIcon || 'warning';
            const confirmBtn = this.dataset.confirmButton || 'Ya';
            
            confirmAction(title, text, icon, confirmBtn, () => {
                if (el.tagName === 'FORM') {
                    el.submit();
                } else if (el.tagName === 'A') {
                    window.location.href = el.href;
                } else if (el.type === 'submit') {
                    const form = el.closest('form');
                    if (form) form.submit();
                }
            });
        });
    });
    
    // Hapus event listener lama dari document untuk menghindari duplikasi
    document.removeEventListener('click', handleGlobalButtonClick);
    
    // Tambahkan event listeners baru dengan event delegation
    document.addEventListener('click', handleGlobalButtonClick);
    
    // Tambahkan event handler langsung untuk tombol view di tabel kamar
    // Ini sebagai fallback jika event delegation tidak berfungsi
    const kamarTable = document.getElementById('kamar-datatable');
    if (kamarTable && typeof $ !== 'undefined') {
        $(kamarTable).off('click', '.btn-view').on('click', '.btn-view', function() {
            var id = $(this).data('id');
            window.showKamarDetail(id);
        });
    }
    
    // Reinisialisasi animasi scroll
    animateOnScroll();
}

// Handler global untuk tombol aksi dengan event delegation
function handleGlobalButtonClick(e) {
    // Handler untuk tombol delete
    if (e.target.closest('.btn-delete[data-id]')) {
        const btn = e.target.closest('.btn-delete[data-id]');
        e.preventDefault();
        
        const id = btn.dataset.id;
        const nama = btn.dataset.nama || 'item ini';
        const url = btn.dataset.url || null;
        
        if (!url) return;
        
        Swal.fire({
            title: 'Anda yakin?',
            html: `Ingin menghapus <strong>${nama}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // AJAX request untuk hapus data
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        // Tampilkan pesan sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message,
                            timer: 1500
                        }).then(() => {
                            // Reload halaman atau hanya reload datatable
                            if (typeof $ !== 'undefined' && $.fn.DataTable) {
                                const table = btn.closest('table');
                                if (table && $.fn.DataTable.isDataTable(table)) {
                                    $(table).DataTable().ajax.reload();
                                } else {
                                    window.location.reload();
                                }
                            } else {
                                window.location.reload();
                            }
                        });
                    } else {
                        // Tampilkan pesan error
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message,
                        });
                    }
                })
                .catch(error => {
                    // Tampilkan pesan error
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal menghapus data',
                    });
                });
            }
        });
    }
    
    // Handler untuk tombol view/detail
    else if (e.target.closest('.btn-view[data-id]') || e.target.closest('.btn-detail[data-id]')) {
        const btn = e.target.closest('.btn-view[data-id]') || e.target.closest('.btn-detail[data-id]');
        e.preventDefault();
        
        const id = btn.dataset.id;
        
        // Jika ini adalah tombol view kamar
        if (id && typeof window.showKamarDetail === 'function') {
            // Cek apakah kita berada di halaman kamar
            const isKamarPage = window.location.pathname.includes('kamar') || 
                               document.querySelector('#kamar-datatable') !== null ||
                               btn.closest('#kamar-datatable') !== null;
            
            if (isKamarPage || btn.classList.contains('btn-view-kamar')) {
                window.showKamarDetail(id);
                return;
            }
        }
        
        // Jika ini adalah tombol detail tamu di tabel tamu
        if (id && btn.closest('#tamu-datatable')) {
            // Gunakan jQuery AJAX jika tersedia (untuk kompatibilitas dengan kode yang ada)
            if (typeof $ !== 'undefined' && $.ajax) {
                $.ajax({
                    url: site_url + "tamu/show/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        if(response.status) {
                            const data = response.data;
                            
                            // Buat konten HTML untuk detail
                            let userAccountInfo = '';
                            if (data.has_account) {
                                userAccountInfo = `
                                    <div class="user-account-info">
                                        <h6 class="mb-2">Informasi Akun</h6>
                                        <table class="detail-table">
                                            <tr>
                                                <td class="label">Username</td>
                                                <td class="separator">:</td>
                                                <td class="value">${data.username || '-'}</td>
                                            </tr>
                                            <tr>
                                                <td class="label">Email</td>
                                                <td class="separator">:</td>
                                                <td class="value">${data.email || '-'}</td>
                                            </tr>
                                        </table>
                                    </div>`;
                            } else {
                                userAccountInfo = `
                                    <div class="user-account-info">
                                        <p class="no-account-text">Tamu belum memiliki akun user</p>
                                    </div>`;
                            }
                            
                            // Tampilkan detail dengan SweetAlert2
                            Swal.fire({
                                title: 'Detail Tamu: ' + data.nama,
                                html: `
                                    <div class="text-start">
                                        <table class="detail-table">
                                            <tr>
                                                <td class="label">NIK</td>
                                                <td class="separator">:</td>
                                                <td class="value">${data.nik}</td>
                                            </tr>
                                            <tr>
                                                <td class="label">Nama</td>
                                                <td class="separator">:</td>
                                                <td class="value">${data.nama}</td>
                                            </tr>
                                            <tr>
                                                <td class="label">Alamat</td>
                                                <td class="separator">:</td>
                                                <td class="value">${data.alamat}</td>
                                            </tr>
                                            <tr>
                                                <td class="label">No.HP</td>
                                                <td class="separator">:</td>
                                                <td class="value">${data.nohp}</td>
                                            </tr>
                                            <tr>
                                                <td class="label">Jenis Kelamin</td>
                                                <td class="separator">:</td>
                                                <td class="value">${data.jenkel}</td>
                                            </tr>
                                            <tr>
                                                <td class="label">Tanggal Lahir</td>
                                                <td class="separator">:</td>
                                                <td class="value">${data.tgllahir}</td>
                                            </tr>
                                            <tr>
                                                <td class="label">Tanggal Daftar</td>
                                                <td class="separator">:</td>
                                                <td class="value">${data.created_at}</td>
                                            </tr>
                                            <tr>
                                                <td class="label">Terakhir Diperbarui</td>
                                                <td class="separator">:</td>
                                                <td class="value">${data.updated_at}</td>
                                            </tr>
                                        </table>
                                        ${userAccountInfo}
                                    </div>
                                `,
                                confirmButtonText: 'Tutup',
                                width: '600px'
                            });
                        } else {
                            // Tampilkan pesan error
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan pesan error
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal mengambil data tamu',
                        });
                    }
                });
                return;
            }
        }
        
        // Default behavior untuk tombol view lainnya
        const url = btn.dataset.url || null;
        if (!url) return;
        
        const modalId = btn.dataset.target || '#detailModal';
        const modal = document.querySelector(modalId);
        if (!modal) return;
        
        // Tampilkan loading di modal
        const modalBody = modal.querySelector('.modal-body');
        if (modalBody) {
            modalBody.innerHTML = '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Memuat data...</p></div>';
        }
        
        // Tampilkan modal
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const modalObj = new bootstrap.Modal(modal);
            modalObj.show();
        }
        
        // AJAX request
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status && modalBody) {
                // Perbarui konten modal sesuai dengan data
                if (modal.dataset.updateFunction && window[modal.dataset.updateFunction]) {
                    // Jika ada fungsi update khusus
                    window[modal.dataset.updateFunction](data, modal);
                } else {
                    // Update secara otomatis berdasarkan data-field
                    Object.keys(data.data).forEach(key => {
                        const el = modal.querySelector(`[data-field="${key}"]`);
                        if (el) {
                            el.innerHTML = data.data[key];
                        }
                    });
                }
            } else {
                if (modalBody) {
                    modalBody.innerHTML = '<div class="alert alert-danger">Gagal memuat data</div>';
                }
            }
        })
        .catch(error => {
            console.error('Error loading detail:', error);
            if (modalBody) {
                modalBody.innerHTML = '<div class="alert alert-danger">Terjadi kesalahan saat memuat data</div>';
            }
        });
    }
    
    // Handler untuk tombol create user
    else if (e.target.closest('.btn-create-user[data-nik]')) {
        const btn = e.target.closest('.btn-create-user[data-nik]');
        e.preventDefault();
        
        const nik = btn.dataset.nik;
        const nama = btn.dataset.nama || '';
        
        // Buat form dengan Sweetalert2
        Swal.fire({
            title: 'Buat Akun User untuk ' + nama,
            html: `
                <form id="formBuatAkunSwal">
                    <input type="hidden" id="swal-nik_tamu" value="${nik}">
                    <div class="mb-3 text-start">
                        <label for="swal-username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="swal-username" required>
                        <div class="invalid-feedback" id="swal-error-username"></div>
                    </div>
                    <div class="mb-3 text-start">
                        <label for="swal-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="swal-email" required>
                        <div class="invalid-feedback" id="swal-error-email"></div>
                    </div>
                    <div class="mb-3 text-start">
                        <label for="swal-password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="swal-password" required>
                        <div class="invalid-feedback" id="swal-error-password"></div>
                    </div>
                    <div class="mb-3 text-start">
                        <label for="swal-confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="swal-confirm_password" required>
                        <div class="invalid-feedback" id="swal-error-confirm_password"></div>
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            focusConfirm: false,
            allowOutsideClick: false,
            didOpen: () => {
                // Focus pada input pertama
                document.getElementById('swal-username').focus();
            },
            preConfirm: () => {
                // Validasi input
                const username = document.getElementById('swal-username').value;
                const email = document.getElementById('swal-email').value;
                const password = document.getElementById('swal-password').value;
                const confirm_password = document.getElementById('swal-confirm_password').value;
                
                let isValid = true;
                
                // Reset validasi sebelumnya
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                
                // Validasi username
                if (!username) {
                    document.getElementById('swal-username').classList.add('is-invalid');
                    document.getElementById('swal-error-username').textContent = 'Username harus diisi';
                    isValid = false;
                }
                
                // Validasi email
                if (!email) {
                    document.getElementById('swal-email').classList.add('is-invalid');
                    document.getElementById('swal-error-email').textContent = 'Email harus diisi';
                    isValid = false;
                }
                
                // Validasi password
                if (!password) {
                    document.getElementById('swal-password').classList.add('is-invalid');
                    document.getElementById('swal-error-password').textContent = 'Password harus diisi';
                    isValid = false;
                }
                
                // Validasi konfirmasi password
                if (password !== confirm_password) {
                    document.getElementById('swal-confirm_password').classList.add('is-invalid');
                    document.getElementById('swal-error-confirm_password').textContent = 'Konfirmasi password tidak cocok';
                    isValid = false;
                }
                
                if (!isValid) {
                    return false;
                }
                
                // Return data untuk diproses
                return {
                    nik_tamu: document.getElementById('swal-nik_tamu').value,
                    username: username,
                    email: email,
                    password: password,
                    confirm_password: confirm_password
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika form valid, kirim data ke server
                $.ajax({
                    url: site_url + "tamu/create-user",
                    type: "POST",
                    data: result.value,
                    dataType: "json",
                    success: function(response) {
                        if(response.status) {
                            // Tampilkan pesan sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                            });
                            
                            // Refresh datatable
                            const table = btn.closest('table');
                            if (table && typeof $ !== 'undefined' && $.fn.DataTable && $.fn.DataTable.isDataTable(table)) {
                                $(table).DataTable().ajax.reload();
                            } else {
                                window.location.reload();
                            }
                        } else {
                            // Tampilkan pesan error
                            let errorMessage = response.message;
                            
                            if (response.errors) {
                                errorMessage = Object.values(response.errors).join('<br>');
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                html: errorMessage,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan pesan error
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal membuat akun user',
                        });
                    }
                });
            }
        });
    }
}

// Fungsi untuk mengupdate menu aktif berdasarkan path
function updateActiveMenu(path) {
    // Reset semua menu aktif
    document.querySelectorAll('#sidebar li').forEach(item => {
        item.classList.remove('active');
    });
    
    // Temukan dan aktifkan menu yang sesuai dengan path
    document.querySelectorAll('#sidebar a').forEach(link => {
        const href = link.getAttribute('href');
        if (href && path.includes(href) && href !== '#' && href !== 'javascript:void(0)') {
            link.closest('li').classList.add('active');
            
            // Jika dalam submenu, buka parent menu
            const parentCollapse = link.closest('.collapse');
            if (parentCollapse) {
                parentCollapse.classList.add('show');
                const parentToggle = document.querySelector(`[href="#${parentCollapse.id}"]`);
                if (parentToggle) {
                    parentToggle.classList.remove('collapsed');
                    parentToggle.setAttribute('aria-expanded', 'true');
                }
            }
        }
    });
}

// Fungsi untuk memastikan DataTables diinisialisasi dengan benar
function ensureDataTablesInitialized() {
    // Periksa semua tabel dengan class datatable atau id yang mengandung datatable
    const datatableTables = document.querySelectorAll('table.datatable, table[id*="datatable"]');
    
    if (datatableTables.length > 0) {
        // Pastikan jQuery dan DataTables tersedia
        if (typeof $ !== 'undefined' && $.fn.DataTable) {
            datatableTables.forEach(table => {
                const tableId = table.id;
                if (tableId) {
                    try {
                        // Periksa apakah tabel sudah diinisialisasi
                        if (!$.fn.DataTable.isDataTable('#' + tableId)) {
                            // Inisialisasi DataTable dengan opsi default
                            $('#' + tableId).DataTable({
                                responsive: true,
                                language: {
                                    search: "Cari:",
                                    lengthMenu: "Tampilkan _MENU_ data",
                                    zeroRecords: "Tidak ada data yang ditemukan",
                                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                                    infoEmpty: "Tidak ada data tersedia",
                                    infoFiltered: "(difilter dari total _MAX_ data)",
                                    paginate: {
                                        first: "Pertama",
                                        last: "Terakhir",
                                        next: "Selanjutnya",
                                        previous: "Sebelumnya"
                                    },
                                }
                            });
                            console.log('DataTable initialized:', tableId);
                        } else {
                            // Jika sudah diinisialisasi, reload data
                            $('#' + tableId).DataTable().ajax.reload();
                            console.log('DataTable reloaded:', tableId);
                        }
                    } catch (e) {
                        console.warn('Error ensuring DataTable initialized:', e);
                    }
                }
            });
        } else {
            // Jika jQuery atau DataTables tidak tersedia, coba lagi setelah beberapa saat
            setTimeout(ensureDataTablesInitialized, 500);
        }
    }
}

// Fungsi untuk menginisialisasi ulang DataTables
function reinitializeDataTables() {
    // Hapus semua DataTables yang sudah ada
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $.fn.dataTable.tables({ api: true }).destroy();
        
        // Tunggu sebentar untuk memastikan DOM sudah diperbarui
        setTimeout(() => {
            // Tangani tabel dengan AJAX
            handleDataTablesAjax();
            
            // Cari semua tabel yang perlu diinisialisasi tetapi tidak menggunakan AJAX
            const tables = document.querySelectorAll('table.datatable, table[id*="datatable"]');
            tables.forEach(table => {
                const tableId = table.id;
                if (tableId) {
                    try {
                        // Periksa apakah tabel sudah diinisialisasi
                        if (!$.fn.DataTable.isDataTable('#' + tableId)) {
                            // Inisialisasi dengan opsi default
                            $('#' + tableId).DataTable({
                                responsive: true,
                                language: {
                                    search: "Cari:",
                                    lengthMenu: "Tampilkan _MENU_ data",
                                    zeroRecords: "Tidak ada data yang ditemukan",
                                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                                    infoEmpty: "Tidak ada data tersedia",
                                    infoFiltered: "(difilter dari total _MAX_ data)",
                                    paginate: {
                                        first: "Pertama",
                                        last: "Terakhir",
                                        next: "Selanjutnya",
                                        previous: "Sebelumnya"
                                    },
                                }
                            });
                        }
                    } catch (e) {
                        console.warn('Error reinitializing DataTable:', e);
                    }
                }
            });
            
            // Jalankan semua script di halaman untuk menangani inisialisasi khusus
            executePageScripts();
        }, 200);
    }
}

// Fungsi untuk menangani AJAX DataTables
function handleDataTablesAjax() {
    // Cari semua tabel DataTable dengan AJAX
    const tables = document.querySelectorAll('table.datatable, table[id*="datatable"]');
    
    if (tables.length === 0) return;
    
    // Pastikan jQuery dan DataTables tersedia
    if (typeof $ === 'undefined' || !$.fn.DataTable) {
        console.warn('jQuery or DataTables is not loaded');
        return;
    }
    
    // Untuk setiap tabel, cari script inisialisasi
    tables.forEach(table => {
        const tableId = table.id;
        if (!tableId) return;
        
        // Tambahkan event handler langsung untuk tombol view di tabel kamar
        // Ini sebagai fallback jika event delegation tidak berfungsi
        if (tableId === 'kamar-datatable') {
            $(table).off('click', '.btn-view').on('click', '.btn-view', function() {
                var id = $(this).data('id');
                window.showKamarDetail(id);
            });
        }
        
        // Cari script inisialisasi DataTable untuk tabel ini
        const scripts = document.querySelectorAll('script');
        let scriptContent = '';
        
        for (let i = 0; i < scripts.length; i++) {
            const content = scripts[i].textContent || '';
            if (content.includes(`$('#${tableId}').DataTable(`) || 
                content.includes(`$("#${tableId}").DataTable(`) ||
                (content.includes(`${tableId}`) && content.includes('.DataTable('))) {
                scriptContent = content;
                break;
            }
        }
        
        try {
            // Hapus DataTable yang sudah ada
            if ($.fn.DataTable.isDataTable('#' + tableId)) {
                $('#' + tableId).DataTable().destroy();
            }
            
            // Jika ditemukan script inisialisasi, ekstrak konfigurasi AJAX
            if (scriptContent) {
                // Ekstrak URL AJAX dari script
                let ajaxUrl = '';
                const ajaxMatch = scriptContent.match(/ajax:\s*['"]([^'"]+)['"]/);
                if (ajaxMatch && ajaxMatch[1]) {
                    ajaxUrl = ajaxMatch[1];
                }
                
                // Jika URL AJAX ditemukan, inisialisasi ulang dengan URL yang sama
                if (ajaxUrl) {
                    // Proses URL AJAX jika perlu
                    ajaxUrl = processAjaxUrl(ajaxUrl);
                    console.log('Reinitializing DataTable with AJAX URL:', ajaxUrl);
                    
                    // Dapatkan konfigurasi dari script jika memungkinkan
                    // Tetapi tetap gunakan URL AJAX yang sudah diekstrak
                    let config = {};
                    try {
                        // Coba ekstrak konfigurasi dari script
                        const configMatch = scriptContent.match(/DataTable\((.*)\)/s);
                        if (configMatch && configMatch[1]) {
                            // Hapus komentar dan whitespace berlebih
                            let configStr = configMatch[1].replace(/\/\/.*$/gm, '').trim();
                            // Evaluasi string konfigurasi menjadi objek
                            // Ini tidak aman untuk produksi, hanya untuk demo
                            try {
                                // Ganti ajax url dengan yang sudah diekstrak
                                configStr = configStr.replace(/ajax:\s*['"][^'"]+['"]/, `ajax: '${ajaxUrl}'`);
                                // Tambahkan callback drawCallback
                                if (!configStr.includes('drawCallback')) {
                                    if (configStr.endsWith('}')) {
                                        configStr = configStr.slice(0, -1) + ', drawCallback: function() { setTimeout(reinitializeEvents, 100); }}';
                                    } else {
                                        configStr += ', drawCallback: function() { setTimeout(reinitializeEvents, 100); }';
                                    }
                                }
                                // Evaluasi konfigurasi
                                config = eval('(' + configStr + ')');
                            } catch (e) {
                                console.warn('Error evaluating DataTable config:', e);
                                // Fallback ke konfigurasi default dengan URL AJAX
                                config = {
                                    processing: true,
                                    serverSide: true,
                                    ajax: ajaxUrl,
                                    drawCallback: function() {
                                        setTimeout(reinitializeEvents, 100);
                                    }
                                };
                            }
                        } else {
                            // Fallback ke konfigurasi default dengan URL AJAX
                            config = {
                                processing: true,
                                serverSide: true,
                                ajax: ajaxUrl,
                                drawCallback: function() {
                                    setTimeout(reinitializeEvents, 100);
                                }
                            };
                        }
                    } catch (e) {
                        console.warn('Error extracting DataTable config:', e);
                        // Fallback ke konfigurasi default dengan URL AJAX
                        config = {
                            processing: true,
                            serverSide: true,
                            ajax: ajaxUrl,
                            drawCallback: function() {
                                setTimeout(reinitializeEvents, 100);
                            }
                        };
                    }
                    
                    // Inisialisasi DataTable dengan konfigurasi
                    $('#' + tableId).DataTable(config);
                } else {
                    // Jika tidak ditemukan URL AJAX, evaluasi script secara langsung
                    try {
                        // Tambahkan script ke halaman untuk dieksekusi
                        const tempScript = document.createElement('script');
                        tempScript.textContent = scriptContent;
                        document.body.appendChild(tempScript);
                        document.body.removeChild(tempScript);
                        
                        // Pastikan event handlers diinisialisasi ulang setelah DataTable dirender
                        setTimeout(reinitializeEvents, 100);
                    } catch (e) {
                        console.error('Error executing DataTable script:', e);
                    }
                }
            } else {
                // Jika tidak ditemukan script inisialisasi, coba inisialisasi berdasarkan atribut data
                // Cek apakah ada atribut data-ajax-url
                const dataAjaxUrl = table.getAttribute('data-ajax-url');
                if (dataAjaxUrl) {
                    // Proses URL AJAX jika perlu
                    const processedUrl = processAjaxUrl(dataAjaxUrl);
                    console.log('Initializing DataTable with data-ajax-url:', processedUrl);
                    
                    // Inisialisasi dengan URL dari atribut
                    $('#' + tableId).DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: processedUrl,
                        drawCallback: function() {
                            setTimeout(reinitializeEvents, 100);
                        }
                    });
                } else {
                    // Jika tidak ada atribut data-ajax-url, inisialisasi dengan konfigurasi default
                    $('#' + tableId).DataTable({
                        responsive: true,
                        drawCallback: function() {
                            setTimeout(reinitializeEvents, 100);
                        }
                    });
                }
            }
        } catch (e) {
            console.error('Error initializing DataTable:', e);
        }
    });
    
    // Panggil reinitializeEvents setelah semua tabel diinisialisasi
    setTimeout(reinitializeEvents, 200);
}

// Fungsi untuk memproses URL AJAX
function processAjaxUrl(url) {
    // Jika URL berisi site_url() dari PHP, proses dengan benar
    if (url.includes('<?= site_url')) {
        // Ekstrak path dari site_url
        const matches = url.match(/site_url\(['"]([^'"]+)['"]\)/);
        if (matches && matches[1]) {
            // Buat URL lengkap dengan base URL saat ini
            const baseUrl = window.location.origin;
            return baseUrl + '/' + matches[1].replace(/^\//, '');
        }
    }
    
    // Jika URL adalah string literal, kembalikan apa adanya
    return url;
}

// Fungsi untuk inisialisasi sidebar
function initSidebar() {
    // Perbaikan untuk submenu di mobile
    setupMobileSubmenu();

    // Card hover effects
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 0.5rem 2rem 0 rgba(58, 59, 69, 0.15)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.boxShadow = '';
        });
    });

    // Dropdown hover effect on larger screens
    const dropdownItems = document.querySelectorAll('.dropdown');
    if (window.innerWidth >= 992) {
        dropdownItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.querySelector('.dropdown-toggle').click();
            });
            
            item.addEventListener('mouseleave', function() {
                this.querySelector('.dropdown-toggle').click();
            });
        });
    }

    // AJAX untuk sidebar menu
    document.querySelectorAll('#sidebar a').forEach(link => {
        // Skip dropdown toggles
        if (link.getAttribute('data-bs-toggle') === 'collapse') return;
        
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');
            
            // Jika tidak ada URL atau hanya '#', jangan lakukan apa-apa
            if (!url || url === '#' || url === 'javascript:void(0)') return;
            
            // Tampilkan loader
            const mainContent = document.querySelector('.main-content .container-fluid');
            if (mainContent) {
                // Tambahkan loading spinner
                mainContent.innerHTML = '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Memuat data...</p></div>';
            }
            
            // Load konten dengan AJAX
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    // Ambil hanya konten utama
                    const content = doc.querySelector('.main-content .container-fluid');
                    if (content && mainContent) {
                        // Simpan semua script dalam konten untuk dijalankan nanti
                        const scriptElements = Array.from(content.querySelectorAll('script'));
                        const scriptContents = scriptElements.map(script => script.innerHTML).join('\n');
                        
                        // Hapus script dari konten untuk mencegah evaluasi awal
                        scriptElements.forEach(script => {
                            script.parentNode.removeChild(script);
                        });
                        
                        // Update konten
                        mainContent.innerHTML = content.innerHTML;
                        
                        // Reinisialisasi komponen Bootstrap
                        reinitializeBootstrapComponents();
                        
                        // Tunggu sedikit untuk memastikan DOM sudah dirender
                        setTimeout(() => {
                            // Cek apakah ada tabel DataTable di konten
                            const hasDatatable = mainContent.querySelector('table.datatable') || 
                                               mainContent.querySelector('table[id*="datatable"]') ||
                                               scriptContents.includes('DataTable');
                            
                            if (hasDatatable) {
                                // Tambahkan script yang diekstrak ke DOM
                                if (scriptContents.includes('DataTable')) {
                                    const tempScript = document.createElement('script');
                                    tempScript.id = 'temp-datatable-script';
                                    tempScript.textContent = scriptContents;
                                    document.body.appendChild(tempScript);
                                }
                                
                                // Inisialisasi ulang DataTables dengan AJAX
                                setTimeout(() => {
                                    handleDataTablesAjax();
                                    
                                    // Hapus script sementara
                                    const tempScript = document.getElementById('temp-datatable-script');
                                    if (tempScript) {
                                        document.body.removeChild(tempScript);
                                    }
                                }, 300);
                            } else {
                                // Jalankan script halaman
                                executePageScripts();
                            }
                            
                            // Reinisialisasi event handler untuk form dan tombol
                            reinitializeEvents();
                        }, 200);
                    }
                    
                    // Update URL browser
                    history.pushState(null, '', url);
                    
                    // Update status active menu
                    document.querySelectorAll('#sidebar li').forEach(item => {
                        item.classList.remove('active');
                    });
                    this.closest('li').classList.add('active');
                    
                    // Close sidebar on mobile
                    if (window.innerWidth <= 767) {
                        const sidebar = document.getElementById('sidebar');
                        const content = document.getElementById('content');
                        const body = document.body;
                        
                        sidebar.classList.remove('active');
                        content.classList.remove('active');
                        body.classList.remove('sidebar-active');
                    }
                })
                .catch(error => {
                    console.error('Error loading content:', error);
                    if (mainContent) {
                        mainContent.innerHTML = `<div class="alert alert-danger">Gagal memuat konten. <button class="btn btn-sm btn-danger" onclick="window.location.reload()">Reload Halaman</button></div>`;
                    }
                });
        });
    });

    // Add animation delay to sidebar items
    const sidebarItems = document.querySelectorAll('#sidebar ul.components > li');
    sidebarItems.forEach((item, index) => {
        item.style.animationDelay = (0.1 * index) + 's';
        item.classList.add('animate__animated', 'animate__fadeInLeft');
    });

    // Handle untuk popstate event (browser back/forward)
    window.addEventListener('popstate', function(event) {
        // Load konten sesuai dengan URL saat ini
        if (window.location.pathname) {
            // Tampilkan loader
            const mainContent = document.querySelector('.main-content .container-fluid');
            if (mainContent) {
                // Tambahkan loading spinner
                mainContent.innerHTML = '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Memuat data...</p></div>';
            }

            fetch(window.location.pathname)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    // Ambil hanya konten utama
                    const content = doc.querySelector('.main-content .container-fluid');
                    
                    if (content && mainContent) {
                        // Simpan semua script dalam konten untuk dijalankan nanti
                        const scriptElements = Array.from(content.querySelectorAll('script'));
                        const scriptContents = scriptElements.map(script => script.innerHTML).join('\n');
                        
                        // Hapus script dari konten untuk mencegah evaluasi awal
                        scriptElements.forEach(script => {
                            script.parentNode.removeChild(script);
                        });
                        
                        // Update konten
                        mainContent.innerHTML = content.innerHTML;
                        
                        // Reinisialisasi komponen
                        reinitializeBootstrapComponents();
                        
                        // Tunggu sedikit untuk memastikan DOM sudah dirender
                        setTimeout(() => {
                            // Cek apakah ada tabel DataTable di konten
                            const hasDatatable = mainContent.querySelector('table.datatable') || 
                                               mainContent.querySelector('table[id*="datatable"]') ||
                                               scriptContents.includes('DataTable');
                            
                            if (hasDatatable) {
                                // Tambahkan script yang diekstrak ke DOM
                                if (scriptContents.includes('DataTable')) {
                                    const tempScript = document.createElement('script');
                                    tempScript.id = 'temp-datatable-script';
                                    tempScript.textContent = scriptContents;
                                    document.body.appendChild(tempScript);
                                }
                                
                                // Inisialisasi ulang DataTables dengan AJAX
                                setTimeout(() => {
                                    handleDataTablesAjax();
                                    
                                    // Hapus script sementara
                                    const tempScript = document.getElementById('temp-datatable-script');
                                    if (tempScript) {
                                        document.body.removeChild(tempScript);
                                    }
                                }, 300);
                            } else {
                                // Jalankan script halaman
                                executePageScripts();
                            }
                            
                            // Reinisialisasi event handler
                            reinitializeEvents();
                            
                            // Update status active menu sesuai dengan path saat ini
                            updateActiveMenu(window.location.pathname);
                        }, 200);
                    }
                })
                .catch(error => {
                    console.error('Error loading content:', error);
                    // Reload halaman jika terjadi error
                    window.location.reload();
                });
        }
    });
}

// Fungsi untuk menampilkan detail kamar
window.showKamarDetail = function(id) {
    // Pastikan jQuery tersedia
    if (typeof $ === 'undefined') {
        console.error('jQuery is not available');
        return;
    }
    
    // AJAX request
    $.ajax({
        url: site_url + "kamar/show/" + id,
        type: "GET",
        dataType: "json",
        success: function(response) {
            if(response.status) {
                const data = response.data;
                
                // Tampilkan detail dengan SweetAlert2
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
                        window.location.href = site_url + 'kamar/edit/' + id;
                    }
                });
            } else {
                // Tampilkan pesan error
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: response.message,
                });
            }
        },
        error: function(xhr, status, error) {
            // Tampilkan pesan error
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Gagal mengambil data kamar',
            });
        }
    });
} 