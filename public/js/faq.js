// FAQ JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo các tính năng tương tác cho trang FAQ
    
    // Lọc theo danh mục
    const categoryFilters = document.querySelectorAll('.category-filter');
    const questionsContainer = document.getElementById('questionsContainer');
    const faqItems = document.querySelectorAll('.faq-item');
    const faqCategories = document.querySelectorAll('.faq-category');
    const questionsCount = document.getElementById('questionsCount');
    const filterStatus = document.getElementById('filterStatus');
    
    // Tìm kiếm FAQ
    const searchInput = document.getElementById('faqSearch');
    const clearSearchBtn = document.getElementById('clearSearch');
    const noResultsDiv = document.getElementById('noResults');
    const resetSearchBtn = document.getElementById('resetSearch');
    
    // Mở/đóng câu hỏi
    initFAQToggle();
    
    // Lọc theo danh mục
    if (categoryFilters.length > 0) {
        categoryFilters.forEach(filter => {
            filter.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                
                // Cập nhật trạng thái active
                categoryFilters.forEach(f => f.classList.remove('active'));
                this.classList.add('active');
                
                // Lọc câu hỏi
                filterQuestionsByCategory(category);
                
                // Cập nhật URL hash (nếu không phải "all")
                if (category !== 'all') {
                    history.pushState(null, null, `#${category}`);
                } else {
                    history.pushState(null, null, ' ');
                }
                
                // Cuộn lên đầu phần câu hỏi
                questionsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
        
        // Kiểm tra hash URL khi trang tải
        if (window.location.hash) {
            const categoryFromHash = window.location.hash.substring(1);
            const correspondingFilter = document.querySelector(`.category-filter[data-category="${categoryFromHash}"]`);
            
            if (correspondingFilter) {
                // Kích hoạt filter tương ứng
                categoryFilters.forEach(f => f.classList.remove('active'));
                correspondingFilter.classList.add('active');
                filterQuestionsByCategory(categoryFromHash);
            }
        }
    }
    
    // Tìm kiếm FAQ
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim().toLowerCase();
            
            // Hiển thị nút xóa tìm kiếm nếu có nội dung
            if (searchTerm.length > 0) {
                clearSearchBtn.style.display = 'block';
            } else {
                clearSearchBtn.style.display = 'none';
                // Nếu đang ở chế độ lọc theo danh mục, áp dụng lại bộ lọc
                const activeFilter = document.querySelector('.category-filter.active');
                if (activeFilter) {
                    const category = activeFilter.getAttribute('data-category');
                    filterQuestionsByCategory(category);
                }
                return;
            }
            
            // Tìm kiếm
            performSearch(searchTerm);
        });
        
        // Xóa tìm kiếm
        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            this.style.display = 'none';
            
            // Khôi phục hiển thị theo danh mục đang active
            const activeFilter = document.querySelector('.category-filter.active');
            if (activeFilter) {
                const category = activeFilter.getAttribute('data-category');
                filterQuestionsByCategory(category);
            }
            
            // Đặt focus lại vào ô tìm kiếm
            searchInput.focus();
        });
    }
    
    // Reset tìm kiếm
    if (resetSearchBtn) {
        resetSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            clearSearchBtn.style.display = 'none';
            
            // Hiển thị tất cả câu hỏi
            showAllQuestions();
            
            // Kích hoạt filter "all"
            categoryFilters.forEach(f => f.classList.remove('active'));
            const allFilter = document.querySelector('.category-filter[data-category="all"]');
            if (allFilter) {
                allFilter.classList.add('active');
            }
            
            // Đặt focus lại vào ô tìm kiếm
            searchInput.focus();
        });
    }
    
    // Thêm hiệu ứng cho nút quay lại khi cuộn
    initBackButtonEffect();
    
    // Thêm hiệu ứng cuộn mượt cho các liên kết nội bộ
    initSmoothScrolling();
    
    // Đánh dấu phần đang được xem trong URL hash
    highlightCurrentQuestion();
    
    // Mở tất cả các câu hỏi nếu có hash cụ thể
    openQuestionFromHash();
});

// Lọc câu hỏi theo danh mục
function filterQuestionsByCategory(category) {
    let visibleCount = 0;
    let categoryName = '';
    
    // Ẩn tất cả câu hỏi trước
    faqItems.forEach(item => {
        item.style.display = 'none';
        item.classList.remove('filtered-match');
    });
    
    // Ẩn tất cả danh mục
    faqCategories.forEach(cat => {
        cat.style.display = 'none';
    });
    
    // Hiển thị câu hỏi theo danh mục
    if (category === 'all') {
        // Hiển thị tất cả
        faqCategories.forEach(cat => {
            cat.style.display = 'flex';
            const itemsInCategory = cat.querySelectorAll('.faq-item');
            itemsInCategory.forEach(item => {
                item.style.display = 'flex';
                visibleCount++;
            });
        });
        categoryName = 'Tất cả câu hỏi';
    } else {
        // Hiển thị danh mục cụ thể
        const targetCategory = document.getElementById(`category-${category}`);
        if (targetCategory) {
            targetCategory.style.display = 'flex';
            const itemsInCategory = targetCategory.querySelectorAll('.faq-item');
            itemsInCategory.forEach(item => {
                item.style.display = 'flex';
                visibleCount++;
            });
            
            // Lấy tên danh mục
            const categoryHeader = targetCategory.querySelector('.category-header h3');
            categoryName = categoryHeader ? categoryHeader.textContent : category;
        }
    }
    
    // Cập nhật thống kê
    updateQuestionsStats(visibleCount, categoryName);
    
    // Ẩn thông báo không có kết quả nếu đang hiển thị
    noResultsDiv.style.display = 'none';
}

// Tìm kiếm câu hỏi
function performSearch(searchTerm) {
    let matchCount = 0;
    let hasMatches = false;
    
    // Ẩn tất cả câu hỏi trước
    faqItems.forEach(item => {
        item.style.display = 'none';
        item.classList.remove('filtered-match');
    });
    
    // Ẩn tất cả danh mục
    faqCategories.forEach(cat => {
        cat.style.display = 'none';
    });
    
    // Tìm kiếm trong tất cả câu hỏi
    faqItems.forEach(item => {
        const questionText = item.querySelector('h4').textContent.toLowerCase();
        const answerText = item.querySelector('.faq-answer').textContent.toLowerCase();
        
        if (questionText.includes(searchTerm) || answerText.includes(searchTerm)) {
            // Hiển thị câu hỏi này
            item.style.display = 'flex';
            item.classList.add('filtered-match');
            
            // Hiển thị danh mục cha
            const parentCategory = item.closest('.faq-category');
            if (parentCategory) {
                parentCategory.style.display = 'flex';
            }
            
            matchCount++;
            hasMatches = true;
        }
    });
    
    // Hiển thị/ẩn thông báo không có kết quả
    if (!hasMatches) {
        noResultsDiv.style.display = 'block';
        updateQuestionsStats(0, `kết quả cho "${searchTerm}"`);
    } else {
        noResultsDiv.style.display = 'none';
        updateQuestionsStats(matchCount, `kết quả cho "${searchTerm}"`);
        
        // Mở tất cả các câu hỏi có kết quả khớp
        const matchedItems = document.querySelectorAll('.faq-item.filtered-match');
        matchedItems.forEach(item => {
            const answer = item.querySelector('.faq-answer');
            if (!answer.classList.contains('open')) {
                answer.classList.add('open');
                item.querySelector('.faq-toggle i').className = 'fas fa-chevron-up';
            }
        });
    }
    
    // Cập nhật bộ lọc category để phản ánh tìm kiếm
    categoryFilters.forEach(f => f.classList.remove('active'));
}

// Hiển thị tất cả câu hỏi
function showAllQuestions() {
    faqCategories.forEach(cat => {
        cat.style.display = 'flex';
    });
    
    faqItems.forEach(item => {
        item.style.display = 'flex';
        item.classList.remove('filtered-match');
    });
    
    // Đóng tất cả câu trả lời (tùy chọn)
    // closeAllAnswers();
    
    // Cập nhật thống kê
    const totalQuestions = faqItems.length;
    updateQuestionsStats(totalQuestions, 'Tất cả câu hỏi');
    
    // Ẩn thông báo không có kết quả
    noResultsDiv.style.display = 'none';
}

// Cập nhật thống kê câu hỏi
function updateQuestionsStats(count, filter) {
    if (questionsCount) {
        questionsCount.textContent = `${count} câu hỏi`;
    }
    
    if (filterStatus) {
        filterStatus.textContent = `Đang hiển thị: ${filter}`;
    }
}

// Khởi tạo toggle mở/đóng câu hỏi
function initFAQToggle() {
    const faqToggles = document.querySelectorAll('.faq-toggle');
    
    faqToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const faqItem = this.closest('.faq-item');
            const answer = faqItem.querySelector('.faq-answer');
            const icon = this.querySelector('i');
            
            // Đóng tất cả các câu hỏi khác (tùy chọn)
            // closeOtherAnswers(faqItem);
            
            // Mở/đóng câu hỏi hiện tại
            if (answer.classList.contains('open')) {
                answer.classList.remove('open');
                icon.className = 'fas fa-chevron-down';
            } else {
                answer.classList.add('open');
                icon.className = 'fas fa-chevron-up';
                
                // Cập nhật URL hash
                const questionId = faqItem.id;
                history.pushState(null, null, `#${questionId}`);
            }
        });
    });
    
    // Mở câu hỏi khi click vào câu hỏi (toàn bộ phần header)
    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(question => {
        question.addEventListener('click', function(e) {
            // Chỉ xử lý nếu không click vào nút toggle
            if (!e.target.closest('.faq-toggle')) {
                const toggle = this.querySelector('.faq-toggle');
                toggle.click();
            }
        });
    });
}

// Đóng tất cả câu trả lời
function closeAllAnswers() {
    const answers = document.querySelectorAll('.faq-answer');
    const icons = document.querySelectorAll('.faq-toggle i');
    
    answers.forEach(answer => {
        answer.classList.remove('open');
    });
    
    icons.forEach(icon => {
        icon.className = 'fas fa-chevron-down';
    });
}

// Đóng các câu trả lời khác
function closeOtherAnswers(currentItem) {
    const allItems = document.querySelectorAll('.faq-item');
    
    allItems.forEach(item => {
        if (item !== currentItem) {
            const answer = item.querySelector('.faq-answer');
            const icon = item.querySelector('.faq-toggle i');
            
            if (answer && answer.classList.contains('open')) {
                answer.classList.remove('open');
                if (icon) {
                    icon.className = 'fas fa-chevron-down';
                }
            }
        }
    });
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
                const headerHeight = document.querySelector('.faq-header').offsetHeight;
                const targetPosition = target.offsetTop - headerHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // Cập nhật URL hash
                history.pushState(null, null, href);
                
                // Mở câu hỏi nếu là FAQ item
                if (target.classList.contains('faq-item')) {
                    const answer = target.querySelector('.faq-answer');
                    const toggle = target.querySelector('.faq-toggle');
                    
                    if (answer && !answer.classList.contains('open')) {
                        answer.classList.add('open');
                        if (toggle) {
                            toggle.querySelector('i').className = 'fas fa-chevron-up';
                        }
                    }
                }
            }
        });
    });
}

// Đánh dấu câu hỏi hiện tại từ URL hash
function highlightCurrentQuestion() {
    // Kiểm tra hash URL khi trang tải
    if (window.location.hash && window.location.hash.startsWith('#faq-')) {
        const questionId = window.location.hash.substring(1);
        const questionElement = document.getElementById(questionId);
        
        if (questionElement) {
            // Thêm highlight
            questionElement.style.transition = 'none';
            questionElement.style.boxShadow = '0 0 0 3px rgba(255, 107, 53, 0.3)';
            questionElement.style.borderColor = 'var(--primary-color)';
            
            setTimeout(() => {
                questionElement.style.transition = 'all 0.3s ease';
                questionElement.style.boxShadow = '';
                questionElement.style.borderColor = '';
            }, 2000);
        }
    }
    
    // Theo dõi thay đổi hash
    window.addEventListener('hashchange', function() {
        if (window.location.hash && window.location.hash.startsWith('#faq-')) {
            const questionId = window.location.hash.substring(1);
            const questionElement = document.getElementById(questionId);
            
            if (questionElement) {
                // Thêm highlight
                questionElement.style.transition = 'none';
                questionElement.style.boxShadow = '0 0 0 3px rgba(255, 107, 53, 0.3)';
                questionElement.style.borderColor = 'var(--primary-color)';
                
                setTimeout(() => {
                    questionElement.style.transition = 'all 0.3s ease';
                    questionElement.style.boxShadow = '';
                    questionElement.style.borderColor = '';
                }, 2000);
            }
        }
    });
}

// Mở câu hỏi từ hash URL khi trang tải
function openQuestionFromHash() {
    if (window.location.hash && window.location.hash.startsWith('#faq-')) {
        const questionId = window.location.hash.substring(1);
        const questionElement = document.getElementById(questionId);
        
        if (questionElement) {
            const answer = questionElement.querySelector('.faq-answer');
            const toggle = questionElement.querySelector('.faq-toggle');
            
            if (answer && !answer.classList.contains('open')) {
                // Đảm bảo câu hỏi được hiển thị (nếu đang filter)
                questionElement.style.display = 'flex';
                
                // Hiển thị danh mục cha
                const parentCategory = questionElement.closest('.faq-category');
                if (parentCategory) {
                    parentCategory.style.display = 'flex';
                }
                
                // Mở câu trả lời
                setTimeout(() => {
                    answer.classList.add('open');
                    if (toggle) {
                        toggle.querySelector('i').className = 'fas fa-chevron-up';
                    }
                    
                    // Cuộn đến câu hỏi
                    const headerHeight = document.querySelector('.faq-header').offsetHeight;
                    const targetPosition = questionElement.offsetTop - headerHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }, 300);
            }
        }
    }
}

// Hiển thị thông báo
function showNotification(message, type = 'info') {
    // Tạo phần tử thông báo
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
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

// Thêm chức năng sao chép thông tin liên hệ (nếu cần)
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