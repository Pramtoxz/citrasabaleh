/**
 * Admin Script
 * File ini berisi script untuk template admin
 */

// Document ready function
document.addEventListener('DOMContentLoaded', function() {
    // Tooltips initialization
    initTooltips();

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

    // Animate elements when they come into view
    animateOnScroll();
    
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
    const hasDatatable = document.querySelector('table.datatable') || 
                        document.querySelector('table[id*="datatable"]');
    
    if (hasDatatable) {
        setTimeout(() => {
            handleDataTablesAjax();
        }, 300);
    } else {
        initializeDatatables();
    }
    
    makeTableResponsive();
    
    // Reinisialisasi event handlers
    reinitializeEvents();
});

// Fungsi untuk memperbaiki submenu di mobile
function setupMobileSubmenu() {
    // Ambil semua dropdown toggle di sidebar
    const dropdownToggles = document.querySelectorAll('#sidebar a[data-bs-toggle="collapse"]');
    
    // Tambahkan event listener untuk setiap toggle
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            // Pada perangkat mobile, jangan biarkan click event menyebabkan navigasi
            if (window.innerWidth <= 767) {
                e.preventDefault();
                
                // ID submenu (target collapse)
                const targetId = this.getAttribute('href') || this.getAttribute('data-bs-target');
                
                if (targetId) {
                    // Ambil elemen submenu
                    const submenu = document.querySelector(targetId);
                    
                    // Toggle class show pada submenu
                    if (submenu) {
                        submenu.classList.toggle('show');
                        
                        // Update aria-expanded attribute
                        const isExpanded = submenu.classList.contains('show');
                        this.setAttribute('aria-expanded', isExpanded);
                    }
                }
            }
        });
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

// Fungsi untuk menjalankan script pada halaman setelah AJAX load
function executePageScripts() {
    // Hapus semua script yang sudah ada di main content
    const mainContent = document.querySelector('.main-content .container-fluid');
    if (!mainContent) return;
    
    // Cari semua inline script di konten
    const scriptTexts = Array.from(mainContent.querySelectorAll('script:not([src])')).map(s => s.textContent);
    
    // Gabungkan semua script dan jalankan
    if (scriptTexts.length > 0) {
        const combinedScript = scriptTexts.join('\n');
        
        try {
            // Buat dan jalankan script baru dengan timeout untuk memastikan DOM sudah siap
            setTimeout(() => {
                const newScript = document.createElement('script');
                newScript.textContent = combinedScript;
                document.body.appendChild(newScript);
                
                // Opsional: hapus script setelah dijalankan
                setTimeout(() => {
                    document.body.removeChild(newScript);
                }, 100);
            }, 300);
        } catch (error) {
            console.error('Error executing page scripts:', error);
        }
    }
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
    
    // Reinisialisasi event untuk tombol hapus dengan AJAX
    document.querySelectorAll('.btn-delete[data-id]').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama = this.dataset.nama || 'item ini';
            const url = this.dataset.url || null;
            
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
        });
    });
    
    // Reinisialisasi event untuk tombol view detail dengan AJAX
    document.querySelectorAll('.btn-view[data-id]').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const url = this.dataset.url || null;
            const modalId = this.dataset.target || '#detailModal';
            
            if (!url) return;
            
            // Cari modal
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
        });
    });
    
    // Reinisialisasi animasi scroll
    animateOnScroll();
}

// Fungsi untuk memperbarui status menu aktif
function updateActiveMenu(currentPath) {
    document.querySelectorAll('#sidebar a').forEach(link => {
        const href = link.getAttribute('href');
        if (href && (href === currentPath || (currentPath.indexOf(href) === 0 && href !== '/'))) {
            // Hapus semua status aktif
            document.querySelectorAll('#sidebar li').forEach(item => {
                item.classList.remove('active');
            });
            
            // Tambahkan status aktif ke menu yang sesuai
            link.closest('li').classList.add('active');
            
            // Jika menu berada dalam submenu, buka parentnya
            const parentCollapse = link.closest('.collapse');
            if (parentCollapse) {
                parentCollapse.classList.add('show');
                const parentToggle = document.querySelector(`[data-bs-target="#${parentCollapse.id}"]`) || 
                                   document.querySelector(`[href="#${parentCollapse.id}"]`);
                if (parentToggle) {
                    parentToggle.setAttribute('aria-expanded', 'true');
                    parentToggle.classList.remove('collapsed');
                }
            }
            
            // Keluar setelah menemukan menu yang sesuai
            return;
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
        
        // Jika ditemukan script inisialisasi, ekstrak konfigurasi AJAX
        if (scriptContent) {
            try {
                // Hapus DataTable yang sudah ada
                if ($.fn.DataTable.isDataTable('#' + tableId)) {
                    $('#' + tableId).DataTable().destroy();
                }
                
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
                    
                    // Buat konfigurasi dasar
                    const config = {
                        processing: true,
                        serverSide: true,
                        ajax: ajaxUrl,
                        info: true,
                        ordering: true,
                        paging: true,
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
                    
                    // Inisialisasi DataTable dengan konfigurasi
                    $('#' + tableId).DataTable(config);
                } else {
                    // Jika tidak ditemukan URL AJAX, coba ekstrak dari atribut data-ajax-url
                    const dataAjaxUrl = table.getAttribute('data-ajax-url');
                    if (dataAjaxUrl) {
                        // Proses URL AJAX jika perlu
                        const processedUrl = processAjaxUrl(dataAjaxUrl);
                        console.log('Reinitializing DataTable with data-ajax-url:', processedUrl);
                        
                        // Inisialisasi dengan URL dari atribut
                        $('#' + tableId).DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: processedUrl,
                            info: true,
                            ordering: true,
                            paging: true,
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
                    } else {
                        // Jika tidak ditemukan URL AJAX, inisialisasi dengan konfigurasi default
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
                }
            } catch (e) {
                console.error('Error initializing DataTable:', e);
            }
        } else {
            // Jika tidak ditemukan script inisialisasi, coba inisialisasi berdasarkan atribut data
            try {
                // Hapus DataTable yang sudah ada
                if ($.fn.DataTable.isDataTable('#' + tableId)) {
                    $('#' + tableId).DataTable().destroy();
                }
                
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
                        info: true,
                        ordering: true,
                        paging: true,
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
                } else {
                    // Jika tidak ada atribut data-ajax-url, inisialisasi dengan konfigurasi default
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
                console.error('Error initializing DataTable from attributes:', e);
            }
        }
    });
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