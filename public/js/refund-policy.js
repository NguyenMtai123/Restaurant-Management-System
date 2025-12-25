// Refund Policy JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo các tính năng tương tác cho trang chính sách hoàn tiền
    
    // In chính sách
    const printButton = document.getElementById('printPolicy');
    if (printButton) {
        printButton.addEventListener('click', function() {
            window.print();
        });
    }
    
    // Mở modal yêu cầu hoàn tiền
    const requestRefundButton = document.getElementById('requestRefund');
    const refundModal = document.getElementById('refundModal');
    const modalOverlay = document.querySelector('.modal-overlay');
    const closeModalButtons = document.querySelectorAll('.close-modal');
    
    if (requestRefundButton && refundModal) {
        requestRefundButton.addEventListener('click', function() {
            refundModal.classList.add('active');
        });
        
        // Đóng modal
        closeModalButtons.forEach(button => {
            button.addEventListener('click', function() {
                refundModal.classList.remove('active');
                resetRefundForm();
            });
        });
        
        // Đóng modal khi click bên ngoài
        modalOverlay.addEventListener('click', function() {
            refundModal.classList.remove('active');
            resetRefundForm();
        });
    }
    
    // Tính toán số tiền hoàn
    const calculateButton = document.getElementById('calculateRefund');
    if (calculateButton) {
        calculateButton.addEventListener('click', calculateRefundAmount);
        
        // Tính toán tự động khi thay đổi giá trị
        document.getElementById('orderAmount').addEventListener('input', calculateRefundAmount);
        document.getElementById('issueType').addEventListener('change', function() {
            togglePartialAmountField();
            calculateRefundAmount();
        });
        document.getElementById('affectedAmount').addEventListener('input', calculateRefundAmount);
        
        // Tính toán lần đầu khi trang tải
        calculateRefundAmount();
    }
    
    // Xử lý form yêu cầu hoàn tiền
    const submitRefundButton = document.getElementById('submitRefund');
    if (submitRefundButton) {
        submitRefundButton.addEventListener('click', submitRefundRequest);
    }
    
    // Xử lý hiển thị thông tin ngân hàng/ví điện tử
    const refundMethodSelect = document.getElementById('refundMethod');
    if (refundMethodSelect) {
        refundMethodSelect.addEventListener('change', togglePaymentDetails);
    }
    
    // Xử lý upload file
    const fileInput = document.getElementById('refundEvidence');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'Chưa có file nào được chọn';
            document.getElementById('fileName').textContent = fileName;
        });
    }
    
    // Xử lý FAQ
    initFAQ();
    
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

// Hiển thị/ẩn trường số tiền bị ảnh hưởng
function togglePartialAmountField() {
    const issueType = document.getElementById('issueType').value;
    const partialAmountGroup = document.getElementById('partialAmountGroup');
    
    if (issueType === 'partial') {
        partialAmountGroup.style.display = 'block';
    } else {
        partialAmountGroup.style.display = 'none';
    }
}

// Tính toán số tiền hoàn
function calculateRefundAmount() {
    const orderAmountInput = document.getElementById('orderAmount');
    const issueTypeSelect = document.getElementById('issueType');
    const affectedAmountInput = document.getElementById('affectedAmount');
    
    const originalAmount = document.getElementById('originalAmount');
    const refundRate = document.getElementById('refundRate');
    const shippingRefund = document.getElementById('shippingRefund');
    const totalRefund = document.getElementById('totalRefund');
    
    const orderValue = parseFloat(orderAmountInput.value) || 0;
    const issueType = issueTypeSelect.value;
    const affectedValue = parseFloat(affectedAmountInput.value) || 0;
    
    let refundPercentage = 0;
    let refundShipping = 'Có';
    let calculatedRefund = 0;
    
    switch (issueType) {
        case 'full':
            refundPercentage = 100;
            calculatedRefund = orderValue;
            break;
        case 'partial':
            refundPercentage = 100;
            calculatedRefund = affectedValue > orderValue ? orderValue : affectedValue;
            break;
        case 'delay':
            refundPercentage = 50;
            calculatedRefund = orderValue * 0.5;
            refundShipping = '50%';
            break;
        case 'wrong':
            refundPercentage = 100;
            calculatedRefund = orderValue;
            break;
        default:
            refundPercentage = 0;
            calculatedRefund = 0;
            refundShipping = 'Không';
    }
    
    // Hiển thị kết quả
    originalAmount.textContent = orderValue.toLocaleString() + 'đ';
    refundRate.textContent = refundPercentage + '%';
    shippingRefund.textContent = refundShipping;
    totalRefund.textContent = calculatedRefund.toLocaleString() + 'đ';
}

// Xử lý gửi yêu cầu hoàn tiền
function submitRefundRequest() {
    const orderId = document.getElementById('refundOrderId').value;
    const name = document.getElementById('refundName').value;
    const phone = document.getElementById('refundPhone').value;
    const email = document.getElementById('refundEmail').value;
    const issue = document.getElementById('refundIssue').value;
    const description = document.getElementById('refundDescription').value;
    const method = document.getElementById('refundMethod').value;
    
    const resultDiv = document.getElementById('refundRequestResult');
    
    // Kiểm tra các trường bắt buộc
    if (!orderId || !name || !phone || !email || !issue || !description || !method) {
        showNotification('Vui lòng điền đầy đủ thông tin bắt buộc', 'error');
        return;
    }
    
    // Kiểm tra định dạng email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showNotification('Email không hợp lệ', 'error');
        return;
    }
    
    // Kiểm tra định dạng số điện thoại
    const phoneRegex = /(0[3|5|7|8|9])+([0-9]{8})\b/;
    if (!phoneRegex.test(phone)) {
        showNotification('Số điện thoại không hợp lệ', 'error');
        return;
    }
    
    // Hiển thị kết quả giả lập
    const issueTypes = {
        'quality': 'Chất lượng thực phẩm',
        'wrong': 'Sai món/thiếu món',
        'delay': 'Giao hàng trễ',
        'address': 'Giao sai địa chỉ',
        'payment': 'Lỗi thanh toán',
        'other': 'Khác'
    };
    
    const methodTypes = {
        'bank': 'Chuyển khoản ngân hàng',
        'wallet': 'Ví điện tử',
        'card': 'Hoàn vào thẻ tín dụng/ghi nợ',
        'voucher': 'Nhận voucher Take Away'
    };
    
    const resultHTML = `
        <div class="result-success">
            <h4><i class="fas fa-check-circle"></i> Đã gửi yêu cầu hoàn tiền thành công!</h4>
            <p>Yêu cầu hoàn tiền của bạn đã được gửi đến Take Away Express. Dưới đây là thông tin chi tiết:</p>
            <div class="result-detail">
                <div class="detail-item">
                    <span>Mã yêu cầu:</span>
                    <span><strong>RF${Date.now().toString().slice(-6)}</strong></span>
                </div>
                <div class="detail-item">
                    <span>Mã đơn hàng:</span>
                    <span>${orderId}</span>
                </div>
                <div class="detail-item">
                    <span>Họ và tên:</span>
                    <span>${name}</span>
                </div>
                <div class="detail-item">
                    <span>Loại vấn đề:</span>
                    <span>${issueTypes[issue]}</span>
                </div>
                <div class="detail-item">
                    <span>Phương thức nhận hoàn tiền:</span>
                    <span>${methodTypes[method]}</span>
                </div>
                <div class="detail-item">
                    <span>Thời gian xử lý dự kiến:</span>
                    <span><strong>1-2 giờ làm việc</strong></span>
                </div>
            </div>
            <div class="result-instruction">
                <p><i class="fas fa-info-circle"></i> <strong>Hướng dẫn tiếp theo:</strong> Đội ngũ hỗ trợ sẽ liên hệ với bạn qua số điện thoại <strong>${phone}</strong> trong vòng 1 giờ làm việc để xác minh thông tin và hướng dẫn các bước tiếp theo.</p>
            </div>
        </div>
    `;
    
    resultDiv.innerHTML = resultHTML;
    
    // Cuộn đến kết quả
    resultDiv.scrollIntoView({ behavior: 'smooth' });
    
    // Hiển thị thông báo
    showNotification('Yêu cầu hoàn tiền đã được gửi thành công!', 'success');
    
    // Reset form sau 5 giây
    setTimeout(() => {
        resetRefundForm();
        refundModal.classList.remove('active');
    }, 5000);
}

// Reset form yêu cầu hoàn tiền
function resetRefundForm() {
    document.getElementById('refundOrderId').value = '';
    document.getElementById('refundName').value = '';
    document.getElementById('refundPhone').value = '';
    document.getElementById('refundEmail').value = '';
    document.getElementById('refundIssue').value = '';
    document.getElementById('refundDescription').value = '';
    document.getElementById('refundEvidence').value = '';
    document.getElementById('refundMethod').value = '';
    document.getElementById('fileName').textContent = 'Chưa có file nào được chọn';
    document.getElementById('refundRequestResult').innerHTML = '';
    
    // Ẩn các trường thông tin chi tiết
    document.getElementById('bankDetails').style.display = 'none';
    document.getElementById('walletDetails').style.display = 'none';
}

// Hiển thị thông tin chi tiết thanh toán
function togglePaymentDetails() {
    const method = document.getElementById('refundMethod').value;
    const bankDetails = document.getElementById('bankDetails');
    const walletDetails = document.getElementById('walletDetails');
    
    bankDetails.style.display = 'none';
    walletDetails.style.display = 'none';
    
    if (method === 'bank') {
        bankDetails.style.display = 'block';
    } else if (method === 'wallet') {
        walletDetails.style.display = 'block';
    }
}

// Khởi tạo FAQ
function initFAQ() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const toggle = item.querySelector('.faq-toggle');
        
        question.addEventListener('click', function() {
            const isOpen = answer.classList.contains('open');
            
            // Đóng tất cả các câu hỏi khác
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.querySelector('.faq-answer').classList.remove('open');
                    otherItem.querySelector('.faq-toggle i').className = 'fas fa-chevron-down';
                }
            });
            
            // Mở/đóng câu hỏi hiện tại
            if (!isOpen) {
                answer.classList.add('open');
                toggle.querySelector('i').className = 'fas fa-chevron-up';
            } else {
                answer.classList.remove('open');
                toggle.querySelector('i').className = 'fas fa-chevron-down';
            }
        });
    });
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
                const headerHeight = document.querySelector('.refund-header').offsetHeight;
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

// Sao chép thông tin liên hệ
function initCopyContactInfo() {
    // Thêm sự kiện cho các nút sao chép
    document.querySelectorAll('.btn-copy').forEach(button => {
        button.addEventListener('click', function() {
            const text = this.getAttribute('data-text');
            copyToClipboard(text, 'thông tin');
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