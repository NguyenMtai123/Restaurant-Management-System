// Privacy Policy JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo các tính năng tương tác cho trang chính sách bảo mật
    
    // In chính sách
    const printButton = document.getElementById('printPolicy');
    if (printButton) {
        printButton.addEventListener('click', function() {
            window.print();
        });
    }
    
    // Tải xuống PDF (giả lập)
    const downloadButton = document.getElementById('downloadPolicy');
    if (downloadButton) {
        downloadButton.addEventListener('click', function() {
            showNotification('Đang chuẩn bị tệp PDF... Vui lòng đợi.', 'info');
            
            // Giả lập quá trình tải xuống
            setTimeout(() => {
                showNotification('Tải xuống PDF thành công!', 'success');
                
                // Trong thực tế, đây sẽ là liên kết đến tệp PDF thực
                // window.location.href = 'privacy-policy.pdf';
            }, 1500);
        });
    }
    
    // Quản lý cookie toggle
    const analyticsToggle = document.getElementById('analyticsCookieToggle');
    const marketingToggle = document.getElementById('marketingCookieToggle');
    
    if (analyticsToggle) {
        analyticsToggle.addEventListener('change', function() {
            const status = this.checked ? 'bật' : 'tắt';
            showNotification(`Đã ${status} cookie phân tích`, 'info');
            saveCookiePreference('analytics', this.checked);
        });
    }
    
    if (marketingToggle) {
        marketingToggle.addEventListener('change', function() {
            const status = this.checked ? 'bật' : 'tắt';
            showNotification(`Đã ${status} cookie tiếp thị`, 'info');
            saveCookiePreference('marketing', this.checked);
        });
    }
    
    // Tải cài đặt cookie đã lưu (nếu có)
    loadCookiePreferences();
    
    // Đánh dấu phần đang được xem trong URL hash
    highlightCurrentSection();
    
    // Thêm hiệu ứng cuộn mượt cho các liên kết nội bộ
    initSmoothScrolling();
    
    // Thêm hiệu ứng cho các phần khi cuộn
    initScrollAnimations();
    
    // Thêm chức năng sao chép địa chỉ email
    initCopyEmail();
});

// Hiển thị thông báo
function showNotification(message, type = 'info') {
    // Tạo phần tử thông báo
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
        <button class="notification-close">&times;</button>
    `;
    
    // Thêm CSS cho thông báo nếu chưa có
    if (!document.querySelector('#notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            .notification {
                position: fixed;
                top: 100px;
                right: 20px;
                background-color: #2c3e50;
                color: white;
                padding: 15px 20px;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.2);
                z-index: 10000;
                transform: translateX(150%);
                transition: transform 0.4s ease;
                display: flex;
                align-items: center;
                justify-content: space-between;
                max-width: 400px;
            }
            .notification.show {
                transform: translateX(0);
            }
            .notification.success {
                background-color: #2ecc71;
            }
            .notification.error {
                background-color: #e74c3c;
            }
            .notification.info {
                background-color: #3498db;
            }
            .notification-warning {
                background-color: #f39c12;
            }
            .notification-content {
                display: flex;
                align-items: center;
                gap: 12px;
            }
            .notification-content i {
                font-size: 20px;
            }
            .notification-close {
                background: none;
                border: none;
                color: white;
                font-size: 24px;
                cursor: pointer;
                margin-left: 15px;
                opacity: 0.8;
                transition: opacity 0.3s;
                line-height: 1;
            }
            .notification-close:hover {
                opacity: 1;
            }
            @media (max-width: 768px) {
                .notification {
                    left: 20px;
                    right: 20px;
                    max-width: none;
                    transform: translateY(-150%);
                }
                .notification.show {
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    // Thêm thông báo vào body
    document.body.appendChild(notification);
    
    // Hiển thị thông báo
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);
    
    // Tự động ẩn thông báo sau 5 giây
    const autoHide = setTimeout(() => {
        closeNotification(notification);
    }, 5000);
    
    // Thêm sự kiện đóng thông báo
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('click', function() {
        clearTimeout(autoHide);
        closeNotification(notification);
    });
    
    // Hàm đóng thông báo
    function closeNotification(notificationElement) {
        notificationElement.classList.remove('show');
        setTimeout(() => {
            if (notificationElement.parentNode) {
                notificationElement.parentNode.removeChild(notificationElement);
            }
        }, 400);
    }
}

// Lưu tùy chọn cookie
function saveCookiePreference(type, enabled) {
    const preferences = getCookiePreferences();
    preferences[type] = enabled;
    localStorage.setItem('cookiePreferences', JSON.stringify(preferences));
}

// Lấy tùy chọn cookie
function getCookiePreferences() {
    const saved = localStorage.getItem('cookiePreferences');
    return saved ? JSON.parse(saved) : { analytics: true, marketing: false };
}

// Tải tùy chọn cookie
function loadCookiePreferences() {
    const preferences = getCookiePreferences();
    
    const analyticsToggle = document.getElementById('analyticsCookieToggle');
    const marketingToggle = document.getElementById('marketingCookieToggle');
    
    if (analyticsToggle && preferences.analytics !== undefined) {
        analyticsToggle.checked = preferences.analytics;
    }
    
    if (marketingToggle && preferences.marketing !== undefined) {
        marketingToggle.checked = preferences.marketing;
    }
}

// Đánh dấu phần đang được xem
function highlightCurrentSection() {
    // Kiểm tra hash URL khi trang tải
    if (window.location.hash) {
        const sectionId = window.location.hash.substring(1);
        highlightSection(sectionId);
    }
    
    // Theo dõi thay đổi hash
    window.addEventListener('hashchange', function() {
        const sectionId = window.location.hash.substring(1);
        highlightSection(sectionId);
    });
    
    // Hàm đánh dấu phần
    function highlightSection(sectionId) {
        // Xóa đánh dấu cũ
        document.querySelectorAll('.policy-section').forEach(section => {
            section.classList.remove('active');
        });
        
        // Thêm đánh dấu mới
        const activeSection = document.getElementById(sectionId);
        if (activeSection) {
            activeSection.classList.add('active');
            
            // Thêm hiệu ứng flash
            activeSection.style.transition = 'none';
            activeSection.style.backgroundColor = 'rgba(255, 107, 53, 0.05)';
            
            setTimeout(() => {
                activeSection.style.transition = 'all 0.3s ease';
                activeSection.style.backgroundColor = '';
            }, 1000);
        }
    }
}

// Cuộn mượt cho các liên kết nội bộ
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href === '#') return;
            
            e.preventDefault();
            const target = document.querySelector(href);
            
            if (target) {
                // Tính toán vị trí cuộn, trừ đi chiều cao header nếu cần
                const headerHeight = document.querySelector('.privacy-header').offsetHeight;
                const targetPosition = target.offsetTop - headerHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Hiệu ứng cuộn cho các phần
function initScrollAnimations() {
    // Chỉ chạy nếu trình duyệt hỗ trợ IntersectionObserver
    if ('IntersectionObserver' in window) {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        // Quan sát các phần chính sách
        document.querySelectorAll('.policy-section').forEach(section => {
            observer.observe(section);
        });
        
        // Thêm CSS cho hiệu ứng
        const style = document.createElement('style');
        style.textContent = `
            .policy-section {
                opacity: 0;
                transform: translateY(30px);
                transition: opacity 0.6s ease, transform 0.6s ease;
            }
            .policy-section.animate-in {
                opacity: 1;
                transform: translateY(0);
            }
        `;
        document.head.appendChild(style);
    }
}

// Sao chép địa chỉ email
function initCopyEmail() {
    // Tìm tất cả các liên kết email
    const emailLinks = document.querySelectorAll('a[href^="mailto:"]');
    
    emailLinks.forEach(link => {
        // Thêm nút sao chép bên cạnh liên kết email
        const copyButton = document.createElement('button');
        copyButton.className = 'copy-email-btn';
        copyButton.innerHTML = '<i class="far fa-copy"></i>';
        copyButton.title = 'Sao chép địa chỉ email';
        
        // Chèn nút sau liên kết
        link.parentNode.insertBefore(copyButton, link.nextSibling);
        
        // Thêm sự kiện click
        copyButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const email = link.href.replace('mailto:', '');
            copyToClipboard(email);
        });
    });
    
    // Thêm CSS cho nút sao chép
    const style = document.createElement('style');
    style.textContent = `
        .copy-email-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin-left: 8px;
            transition: var(--transition);
            vertical-align: middle;
        }
        .copy-email-btn:hover {
            background-color: var(--primary-dark);
            transform: scale(1.1);
        }
    `;
    document.head.appendChild(style);
}

// Sao chép vào clipboard
function copyToClipboard(text) {
    // Sử dụng Clipboard API nếu có
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text)
            .then(() => {
                showNotification('Đã sao chép địa chỉ email vào clipboard!', 'success');
            })
            .catch(err => {
                console.error('Không thể sao chép: ', err);
                fallbackCopyToClipboard(text);
            });
    } else {
        // Fallback cho trình duyệt cũ
        fallbackCopyToClipboard(text);
    }
}

// Fallback sao chép clipboard
function fallbackCopyToClipboard(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    textArea.style.top = '-999999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        document.execCommand('copy');
        showNotification('Đã sao chép địa chỉ email vào clipboard!', 'success');
    } catch (err) {
        console.error('Không thể sao chép: ', err);
        showNotification('Không thể sao chép địa chỉ email. Vui lòng sao chép thủ công.', 'error');
    }
    
    document.body.removeChild(textArea);
}

// Thêm hiệu ứng cho nút quay lại khi cuộn
window.addEventListener('scroll', function() {
    const backButton = document.querySelector('.back-button');
    const scrollPosition = window.scrollY;
    
    if (backButton) {
        if (scrollPosition > 300) {
            backButton.classList.add('scrolled');
        } else {
            backButton.classList.remove('scrolled');
        }
    }
    
    // Thêm CSS cho nút quay lại khi cuộn
    if (!document.querySelector('#back-button-scroll-styles')) {
        const style = document.createElement('style');
        style.id = 'back-button-scroll-styles';
        style.textContent = `
            .back-button.scrolled .btn-back {
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 1000;
                background-color: var(--primary-color);
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            }
            @media (max-width: 768px) {
                .back-button.scrolled .btn-back {
                    left: 10px;
                    right: 10px;
                    width: auto;
                }
            }
        `;
        document.head.appendChild(style);
    }
});