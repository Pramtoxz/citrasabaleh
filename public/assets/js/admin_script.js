 /**
 * Admin Script
 * File ini berisi script untuk template admin
 */

// Document ready function
document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar on mobile
    const sidebarCollapse = document.getElementById('sidebarCollapse');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const body = document.body;

    if (sidebarCollapse) {
        sidebarCollapse.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            content.classList.toggle('active');

            // Add/remove overlay for mobile
            if (window.innerWidth < 992) {
                body.classList.toggle('sidebar-active');
            }
        });
    }

    // Hide sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 992 && body.classList.contains('sidebar-active')) {
            // If click outside sidebar
            if (!sidebar.contains(e.target) && e.target !== sidebarCollapse) {
                sidebar.classList.remove('active');
                content.classList.remove('active');
                body.classList.remove('sidebar-active');
            }
        }
    });

    // Tooltips initialization
    initTooltips();

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

    // Animate elements when they come into view
    animateOnScroll();
    
    // Add animation delay to sidebar items
    const sidebarItems = document.querySelectorAll('#sidebar ul.components > li');
    sidebarItems.forEach((item, index) => {
        item.style.animationDelay = (0.1 * index) + 's';
        item.classList.add('animate__animated', 'animate__fadeInLeft');
    });
});

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
    // Using Bootstrap 5's tooltip through popper.js
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Animate elements when they scroll into view
function animateOnScroll() {
    const elements = document.querySelectorAll('.animate-on-scroll');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate__animated', entry.target.dataset.animation || 'animate__fadeIn');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    elements.forEach(element => {
        observer.observe(element);
    });
}

// Custom Sweet Alert confirmation
function confirmAction(title, text, icon, confirmButtonText, callback) {
    Swal.fire({
        title: title || 'Apakah Anda yakin?',
        text: text || 'Tindakan ini tidak dapat dibatalkan!',
        icon: icon || 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4e73df',
        cancelButtonColor: '#e74a3b',
        confirmButtonText: confirmButtonText || 'Ya, lanjutkan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed && typeof callback === 'function') {
            callback();
        }
    });
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
    const tables = document.querySelectorAll('table');
    tables.forEach(table => {
        if (!table.parentElement.classList.contains('table-responsive')) {
            const wrapper = document.createElement('div');
            wrapper.classList.add('table-responsive');
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