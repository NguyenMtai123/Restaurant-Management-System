// Terms of Service JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo các tính năng tương tác cho trang điều khoản dịch vụ
    
    // In điều khoản
    const printButton = document.getElementById('printTerms');
    if (printButton) {
        printButton.addEventListener('click', function() {
            window.print();
        });
    }
    
    // Tải xuống PDF (giả lập)
    const downloadButton = document.getElementById('downloadTerms');
    if (downloadButton) {
        downloadButton.addEventListener('click', function() {
            showNotification('Đang chuẩn bị tệp PDF... Vui lòng đợi.', 'info');
            
            // Giả lập quá trình tải xuống
            setTimeout(() => {
                showNotification('Tải xuống PDF thành công!', 'success');
                
                // Trong thực tế, đây sẽ là liên kết đến tệp PDF thực
                // window.location.href = 'terms-of-service.pdf';
            }, 1500);
        });
    }
    
    // Xác nhận đồng ý điều khoản
    const acceptButton = document.getElementById('acceptTerms');
    const acceptanceModal = document.getElementById('acceptanceModal');
    const modalOverlay = document.querySelector('.modal-overlay');
    const closeModalButtons = document.querySelectorAll('.close-modal, .btn-modal.cancel');
    const confirmButton = document.querySelector('.btn-modal.confirm');
    
    if (acceptButton && acceptanceModal) {
        acceptButton.addEventListener('click', function() {
            acceptanceModal.classList.add('active');
        });
        
        // Đóng modal
        closeModalButtons.forEach(button => {
            button.addEventListener('click', function() {
                acceptanceModal.classList.remove('active');
            });
        });
        
        // Xác nhận đồng ý
        if (confirmButton) {
            confirmButton.addEventListener('click', function() {
                // Lưu trạng thái đồng ý vào localStorage
                localStorage.setItem('termsAccepted', 'true');
                localStorage.setItem('termsAcceptedDate', new Date().toISOString());
                localStorage.setItem('termsVersion', '3.0');
                
                // Hiển thị thông báo
                showNotification('Cảm ơn bạn đã đồng ý với Điều Khoản Dịch Vụ!', 'success');
                
                // Đóng modal
                acceptanceModal.classList.remove('active');
                
                // Cập nhật nút
                acceptButton.innerHTML = '<i class="fas fa-check"></i> Đã đồng ý';
                acceptButton.classList.add('accepted');
                acceptButton.disabled = true;
                
                // Thêm CSS cho nút đã đồng ý
                const style = document.createElement('style');
                style.textContent = `
                    .btn-action.primary.accepted {
                        background-color: var(--success-color);
                        border-color: var(--success-color);
                        cursor: not-allowed;
                    }
                `;
                document.head.appendChild(style);
                
                // Chuyển hướng về trang chủ sau 2 giây
                setTimeout(() => {
                    window.location.href = '../index.html';
                }, 2000);
            });
        }
        
        // Đóng modal khi click bên ngoài
        modalOverlay.addEventListener('click', function() {
            acceptanceModal.classList.remove('active');
        });
    }
    
    // Kiểm tra nếu người dùng đã đồng ý trước đó
    checkPreviousAcceptance();
    
    // Đánh dấu phần đang được xem trong URL hash
    highlightCurrentSection();
    
    // Thêm hiệu ứng cuộn mượt cho các liên kết nội bộ
    initSmoothScrolling();
    
    // Thêm hiệu ứng cho các phần khi cuộn
    initScrollAnimations();
    
    // Thêm chức năng sao chép thông tin liên hệ
    initCopyContactInfo();
    
    // Thêm hiệu ứng cho nút quay lại khi cuộn
    initBackButtonEffect();
});

// Kiểm tra người dùng đã đồng ý điều khoản trước đó chưa
function checkPreviousAcceptance() {
    const termsAccepted = localStorage.getItem('termsAccepted');
    const termsVersion = localStorage.getItem('termsVersion');
    const acceptButton = document.getElementById('acceptTerms');
    
    if (termsAccepted === 'true' && termsVersion === '3.0' && acceptButton) {
        acceptButton.innerHTML = '<i class="fas fa-check"></i> Đã đồng ý';
        acceptButton.classList.add('accepted');
        acceptButton.disabled = true;
        
        // Thêm CSS cho nút đã đồng ý
        const style = document.createElement('style');
        style.textContent = `
            .btn-action.primary.accepted {
                background-color: var(--success-color);
                border-color: var(--success-color);
                cursor: not-allowed;
            }
        `;
        document.head.appendChild(style);
    }
}

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
            .notification.warning {
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
        document.querySelectorAll('.term-section').forEach(section => {
            section.classList.remove('active');
        });
        
        // Thêm đánh dấu mới
        const activeSection = document.getElementById(sectionId);
        if (activeSection) {
            activeSection.classList.add('active');
            
            // Thêm hiệu ứng flash
            activeSection.style.transition = 'none';
            activeSection.style.boxShadow = '0 0 0 3px rgba(255, 107, 53, 0.2)';
            
            setTimeout(() => {
                activeSection.style.transition = 'all 0.3s ease';
                activeSection.style.boxShadow = '';
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
                // Tính toán vị trí cuộn, trừ đi chiều cao header
                const headerHeight = document.querySelector('.terms-header').offsetHeight;
                const targetPosition = target.offsetTop - headerHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // Cập nhật URL hash
                history.pushState(null, null, href);
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
        
        // Quan sát các phần điều khoản
        document.querySelectorAll('.term-section').forEach(section => {
            observer.observe(section);
        });
        
        // Thêm CSS cho hiệu ứng
        const style = document.createElement('style');
        style.textContent = `
            .term-section {
                opacity: 0;
                transform: translateY(30px);
                transition: opacity 0.6s ease, transform 0.6s ease;
            }
            .term-section.animate-in {
                opacity: 1;
                transform: translateY(0);
            }
        `;
        document.head.appendChild(style);
    }
}

// Sao chép thông tin liên hệ
function initCopyContactInfo() {
    // Tìm tất cả các liên kết email và số điện thoại
    const emailLinks = document.querySelectorAll('a[href^="mailto:"]');
    const phoneLinks = document.querySelectorAll('a[href^="tel:"]');
    
    // Thêm nút sao chép cho email
    emailLinks.forEach(link => {
        const copyButton = document.createElement('button');
        copyButton.className = 'copy-contact-btn';
        copyButton.innerHTML = '<i class="far fa-copy"></i>';
        copyButton.title = 'Sao chép địa chỉ email';
        
        // Chèn nút sau liên kết
        link.parentNode.insertBefore(copyButton, link.nextSibling);
        
        copyButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const email = link.href.replace('mailto:', '');
            copyToClipboard(email, 'email');
        });
    });
    
    // Thêm nút sao chép cho số điện thoại
    phoneLinks.forEach(link => {
        const copyButton = document.createElement('button');
        copyButton.className = 'copy-contact-btn';
        copyButton.innerHTML = '<i class="far fa-copy"></i>';
        copyButton.title = 'Sao chép số điện thoại';
        
        // Chèn nút sau liên kết
        link.parentNode.insertBefore(copyButton, link.nextSibling);
        
        copyButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const phone = link.href.replace('tel:', '');
            copyToClipboard(phone, 'số điện thoại');
        });
    });
    
    // Thêm CSS cho nút sao chép
    const style = document.createElement('style');
    style.textContent = `
        .copy-contact-btn {
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
        .copy-contact-btn:hover {
            background-color: var(--primary-dark);
            transform: scale(1.1);
        }
    `;
    document.head.appendChild(style);
}

// Sao chép vào clipboard
function copyToClipboard(text, type) {
    // Sử dụng Clipboard API nếu có
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text)
            .then(() => {
                showNotification(`Đã sao chép ${type} vào clipboard!`, 'success');
            })
            .catch(err => {
                console.error('Không thể sao chép: ', err);
                fallbackCopyToClipboard(text, type);
            });
    } else {
        // Fallback cho trình duyệt cũ
        fallbackCopyToClipboard(text, type);
    }
}

// Fallback sao chép clipboard
function fallbackCopyToClipboard(text, type) {
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
        showNotification(`Đã sao chép ${type} vào clipboard!`, 'success');
    } catch (err) {
        console.error('Không thể sao chép: ', err);
        showNotification(`Không thể sao chép ${type}. Vui lòng sao chép thủ công.`, 'error');
    }
    
    document.body.removeChild(textArea);
}

// Hiệu ứng cho nút quay lại khi cuộn
function initBackButtonEffect() {
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
}

// Thêm chức năng tìm kiếm trong trang (nâng cao)
function initSearchInPage() {
    // Tạo thanh tìm kiếm
    const searchContainer = document.createElement('div');
    searchContainer.className = 'terms-search-container';
    searchContainer.innerHTML = `
        <div class="search-box">
            <input type="text" placeholder="Tìm kiếm trong điều khoản..." id="termsSearchInput">
            <button id="searchButton"><i class="fas fa-search"></i></button>
            <button id="clearSearch" style="display: none;"><i class="fas fa-times"></i></button>
        </div>
        <div class="search-results" id="searchResults"></div>
    `;
    
    // Chèn vào sau header
    const header = document.querySelector('.terms-header');
    header.parentNode.insertBefore(searchContainer, header.nextSibling);
    
    // Thêm CSS cho thanh tìm kiếm
    const style = document.createElement('style');
    style.textContent = `
        .terms-search-container {
            max-width: 1200px;
            margin: 0 auto 30px;
            padding: 0 20px;
        }
        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        .search-box input {
            flex: 1;
            padding: 12px 20px;
            border: 2px solid var(--border-color);
            border-radius: 50px;
            font-size: 16px;
            outline: none;
            transition: var(--transition);
        }
        .search-box input:focus {
            border-color: var(--primary-color);
        }
        .search-box button {
            width: 50px;
            height: 50px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }
        .search-box button:hover {
            background-color: var(--primary-dark);
            transform: scale(1.05);
        }
        .search-results {
            display: none;
            background-color: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            max-height: 300px;
            overflow-y: auto;
            padding: 15px;
        }
        .search-results.active {
            display: block;
        }
        .search-result-item {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
            cursor: pointer;
            transition: var(--transition);
        }
        .search-result-item:hover {
            background-color: var(--bg-light);
        }
        .search-result-item:last-child {
            border-bottom: none;
        }
        .search-result-item h5 {
            font-size: 14px;
            margin-bottom: 5px;
            color: var(--secondary-color);
        }
        .search-result-item p {
            font-size: 13px;
            color: var(--text-light);
            margin: 0;
        }
        .highlight {
            background-color: rgba(255, 107, 53, 0.2);
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: 600;
        }
        @media (max-width: 768px) {
            .terms-search-container {
                padding: 0 15px;
            }
        }
    `;
    document.head.appendChild(style);
    
    // Thêm chức năng tìm kiếm
    const searchInput = document.getElementById('termsSearchInput');
    const searchButton = document.getElementById('searchButton');
    const clearSearch = document.getElementById('clearSearch');
    const searchResults = document.getElementById('searchResults');
    
    if (searchInput && searchButton) {
        searchButton.addEventListener('click', performSearch);
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
        
        clearSearch.addEventListener('click', function() {
            searchInput.value = '';
            clearSearch.style.display = 'none';
            searchResults.classList.remove('active');
            removeHighlights();
        });
    }
    
    function performSearch() {
        const query = searchInput.value.trim().toLowerCase();
        
        if (!query) {
            showNotification('Vui lòng nhập từ khóa tìm kiếm', 'warning');
            return;
        }
        
        // Hiển thị nút xóa
        clearSearch.style.display = 'block';
        
        // Xóa kết quả cũ và highlight
        searchResults.innerHTML = '';
        removeHighlights();
        
        // Tìm kiếm trong tất cả các phần
        const sections = document.querySelectorAll('.term-section');
        let resultCount = 0;
        
        sections.forEach(section => {
            const content = section.textContent.toLowerCase();
            if (content.includes(query)) {
                resultCount++;
                
                // Thêm vào kết quả
                const sectionTitle = section.querySelector('h2').textContent;
                const sectionId = section.id;
                
                const resultItem = document.createElement('div');
                resultItem.className = 'search-result-item';
                resultItem.innerHTML = `
                    <h5>${sectionTitle}</h5>
                    <p>Nhấn để xem chi tiết...</p>
                `;
                
                resultItem.addEventListener('click', function() {
                    // Cuộn đến phần
                    const headerHeight = document.querySelector('.terms-header').offsetHeight;
                    const targetPosition = section.offsetTop - headerHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Highlight phần
                    section.classList.add('active');
                    setTimeout(() => {
                        section.classList.remove('active');
                    }, 3000);
                    
                    // Đóng kết quả tìm kiếm
                    searchResults.classList.remove('active');
                });
                
                searchResults.appendChild(resultItem);
                
                // Highlight từ khóa trong phần
                highlightTextInElement(section, query);
            }
        });
        
        // Hiển thị kết quả
        if (resultCount > 0) {
            searchResults.classList.add('active');
            showNotification(`Tìm thấy ${resultCount} kết quả cho "${query}"`, 'success');
        } else {
            searchResults.innerHTML = '<div class="search-result-item"><p>Không tìm thấy kết quả phù hợp</p></div>';
            searchResults.classList.add('active');
            showNotification(`Không tìm thấy kết quả cho "${query}"`, 'warning');
        }
    }
    
    function highlightTextInElement(element, query) {
        const walker = document.createTreeWalker(
            element,
            NodeFilter.SHOW_TEXT,
            null,
            false
        );
        
        const nodes = [];
        let node;
        while (node = walker.nextNode()) {
            if (node.nodeType === 3 && node.textContent.toLowerCase().includes(query)) {
                nodes.push(node);
            }
        }
        
        nodes.forEach(node => {
            const span = document.createElement('span');
            span.innerHTML = node.textContent.replace(
                new RegExp(`(${query})`, 'gi'),
                '<span class="highlight">$1</span>'
            );
            node.parentNode.replaceChild(span, node);
        });
    }
    
    function removeHighlights() {
        document.querySelectorAll('.highlight').forEach(highlight => {
            const parent = highlight.parentNode;
            parent.replaceChild(document.createTextNode(highlight.textContent), highlight);
            parent.normalize();
        });
    }
    
    // Tự động ẩn thanh tìm kiếm khi cuộn xuống
    let lastScrollTop = 0;
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const searchBox = document.querySelector('.search-box');
        
        if (searchBox) {
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Cuộn xuống
                searchBox.style.transform = 'translateY(-100%)';
                searchBox.style.opacity = '0';
            } else {
                // Cuộn lên
                searchBox.style.transform = 'translateY(0)';
                searchBox.style.opacity = '1';
            }
        }
        lastScrollTop = scrollTop;
    });
}

// Gọi hàm tìm kiếm (tùy chọn, bỏ comment nếu muốn sử dụng)
// initSearchInPage();