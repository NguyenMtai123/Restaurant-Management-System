// Shipping Policy JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo các tính năng tương tác cho trang chính sách giao hàng
    
    // In chính sách
    const printButton = document.getElementById('printPolicy');
    if (printButton) {
        printButton.addEventListener('click', function() {
            window.print();
        });
    }
    
    // Kiểm tra khu vực giao hàng
    const checkDeliveryButton = document.getElementById('checkDeliveryArea');
    const deliveryModal = document.getElementById('deliveryModal');
    const modalOverlay = document.querySelector('.modal-overlay');
    const closeModalButtons = document.querySelectorAll('.close-modal');
    const checkAreaButton = document.getElementById('checkAreaButton');
    
    if (checkDeliveryButton && deliveryModal) {
        checkDeliveryButton.addEventListener('click', function() {
            deliveryModal.classList.add('active');
        });
        
        // Đóng modal
        closeModalButtons.forEach(button => {
            button.addEventListener('click', function() {
                deliveryModal.classList.remove('active');
            });
        });
        
        // Đóng modal khi click bên ngoài
        modalOverlay.addEventListener('click', function() {
            deliveryModal.classList.remove('active');
        });
        
        // Kiểm tra khu vực
        if (checkAreaButton) {
            checkAreaButton.addEventListener('click', checkDeliveryArea);
        }
    }
    
    // Tính toán phí giao hàng
    const calculateButton = document.getElementById('calculateFee');
    if (calculateButton) {
        calculateButton.addEventListener('click', calculateShippingFee);
        
        // Tính toán tự động khi thay đổi giá trị
        document.getElementById('orderValue').addEventListener('input', calculateShippingFee);
        document.getElementById('deliveryDistance').addEventListener('input', calculateShippingFee);
        
        // Tính toán lần đầu khi trang tải
        calculateShippingFee();
    }
    
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

// Kiểm tra khu vực giao hàng
function checkDeliveryArea() {
    const districtSelect = document.getElementById('checkDistrict');
    const wardInput = document.getElementById('checkWard');
    const streetInput = document.getElementById('checkStreet');
    const resultDiv = document.getElementById('areaResult');
    
    const district = districtSelect.value;
    const ward = wardInput.value.trim();
    const street = streetInput.value.trim();
    
    if (!district) {
        showNotification('Vui lòng chọn quận/huyện', 'warning');
        return;
    }
    
    if (!ward) {
        showNotification('Vui lòng nhập tên phường/xã', 'warning');
        return;
    }
    
    // Giả lập kiểm tra khu vực dựa trên quận đã chọn
    let result = '';
    let areaType = '';
    let deliveryTime = '';
    let shippingFee = '';
    let isSupported = false;
    
    // Danh sách quận trung tâm
    const centralDistricts = ['1', '3', '5', '10', 'phunhuan', 'binhthanh'];
    
    // Danh sách quận ngoại thành
    const suburbanDistricts = ['2', '7', '9', '12', 'thuduc', 'govap'];
    
    // Danh sách quận khác
    const otherDistricts = ['4', '6', '8', '11', 'tanbinh', 'tanphu'];
    
    if (centralDistricts.includes(district)) {
        areaType = 'Khu vực trung tâm';
        deliveryTime = '30-45 phút';
        shippingFee = '10.000đ - 15.000đ';
        isSupported = true;
    } else if (suburbanDistricts.includes(district)) {
        areaType = 'Khu vực ngoại thành';
        deliveryTime = '45-60 phút';
        shippingFee = '15.000đ - 20.000đ';
        isSupported = true;
    } else if (otherDistricts.includes(district)) {
        areaType = 'Khu vực khác';
        deliveryTime = '60-75 phút';
        shippingFee = '20.000đ - 25.000đ';
        isSupported = true;
    } else {
        areaType = 'Khu vực chưa hỗ trợ';
        deliveryTime = 'Không có thông tin';
        shippingFee = 'Không có thông tin';
        isSupported = false;
    }
    
    // Lấy tên quận từ value
    const districtName = districtSelect.options[districtSelect.selectedIndex].text;
    
    if (isSupported) {
        result = `
            <div class="result-success">
                <h4><i class="fas fa-check-circle"></i> Hỗ trợ giao hàng</h4>
                <p>Take Away Express hỗ trợ giao hàng đến địa chỉ của bạn.</p>
                <div class="result-detail">
                    <div class="detail-item">
                        <span>Khu vực:</span>
                        <span><strong>${areaType}</strong></span>
                    </div>
                    <div class="detail-item">
                        <span>Quận/Huyện:</span>
                        <span>${districtName}</span>
                    </div>
                    <div class="detail-item">
                        <span>Thời gian giao hàng dự kiến:</span>
                        <span><strong>${deliveryTime}</strong></span>
                    </div>
                    <div class="detail-item">
                        <span>Phí giao hàng cơ bản:</span>
                        <span><strong>${shippingFee}</strong></span>
                    </div>
                    <div class="detail-item">
                        <span>Miễn phí giao hàng:</span>
                        <span>Đơn từ 200.000đ trong bán kính 5km</span>
                    </div>
                </div>
            </div>
        `;
        
        showNotification('Khu vực của bạn được hỗ trợ giao hàng!', 'success');
    } else {
        result = `
            <div class="result-warning">
                <h4><i class="fas fa-exclamation-triangle"></i> Hỗ trợ hạn chế</h4>
                <p>Hiện tại chúng tôi chưa hỗ trợ giao hàng đến khu vực này.</p>
                <div class="result-detail">
                    <div class="detail-item">
                        <span>Quận/Huyện:</span>
                        <span>${districtName}</span>
                    </div>
                    <div class="detail-item">
                        <span>Trạng thái:</span>
                        <span><strong>Đang mở rộng phạm vi phục vụ</strong></span>
                    </div>
                    <div class="detail-item">
                        <span>Đề xuất:</span>
                        <span>Vui lòng liên hệ hotline để được tư vấn</span>
                    </div>
                </div>
            </div>
        `;
        
        showNotification('Khu vực của bạn chưa được hỗ trợ giao hàng. Vui lòng liên hệ hotline.', 'warning');
    }
    
    resultDiv.innerHTML = result;
}

// Tính toán phí giao hàng
function calculateShippingFee() {
    const orderValueInput = document.getElementById('orderValue');
    const distanceInput = document.getElementById('deliveryDistance');
    const calculatedFee = document.getElementById('calculatedFee');
    const orderTotal = document.getElementById('orderTotal');
    const totalPayment = document.getElementById('totalPayment');
    
    const orderValue = parseFloat(orderValueInput.value) || 0;
    const distance = parseFloat(distanceInput.value) || 0;
    
    // Tính phí giao hàng dựa trên khoảng cách
    let shippingFee = 0;
    
    if (distance < 3) {
        shippingFee = 10000;
    } else if (distance >= 3 && distance < 5) {
        shippingFee = 15000;
    } else if (distance >= 5 && distance < 7) {
        shippingFee = 20000;
    } else {
        shippingFee = 25000;
    }
    
    // Kiểm tra điều kiện đơn hàng tối thiểu
    let minOrderMessage = '';
    if (distance >= 5 && distance < 7 && orderValue < 100000) {
        minOrderMessage = ' (Yêu cầu đơn từ 100.000đ)';
    } else if (distance >= 7 && orderValue < 150000) {
        minOrderMessage = ' (Yêu cầu đơn từ 150.000đ)';
    }
    
    // Miễn phí giao hàng cho đơn từ 200.000đ trong bán kính 5km
    if (orderValue >= 200000 && distance < 5) {
        shippingFee = 0;
    }
    
    // Tính tổng thanh toán
    const total = orderValue + shippingFee;
    
    // Hiển thị kết quả
    calculatedFee.textContent = shippingFee === 0 ? 'Miễn phí' : shippingFee.toLocaleString() + 'đ' + minOrderMessage;
    orderTotal.textContent = orderValue.toLocaleString() + 'đ';
    totalPayment.textContent = total.toLocaleString() + 'đ';
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
                const headerHeight = document.querySelector('.shipping-header').offsetHeight;
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

// Thêm tính năng ước tính thời gian giao hàng chi tiết
function initDeliveryTimeEstimator() {
    // Tạo form ước tính thời gian
    const estimatorHTML = `
        <div class="time-estimator">
            <h4><i class="fas fa-clock"></i> Ước tính thời gian giao hàng chi tiết</h4>
            <div class="estimator-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="estimateDistrict">Quận giao hàng</label>
                        <select id="estimateDistrict">
                            <option value="">Chọn quận</option>
                            <option value="central">Quận trung tâm (1, 3, 5, 10, PN, BThạnh)</option>
                            <option value="suburban">Quận ngoại thành (2, 7, 9, 12, Thủ Đức, Gò Vấp)</option>
                            <option value="other">Quận khác (4, 6, 8, 11, Tân Bình, Tân Phú)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="estimateTime">Khung giờ đặt hàng</label>
                        <select id="estimateTime">
                            <option value="">Chọn khung giờ</option>
                            <option value="normal">Giờ bình thường (9:00-11:00, 14:00-16:00)</option>
                            <option value="peak">Giờ cao điểm (11:30-13:30, 17:30-19:30)</option>
                            <option value="evening">Buổi tối (19:30-22:00)</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="estimateComplexity">Độ phức tạp đơn hàng</label>
                    <select id="estimateComplexity">
                        <option value="">Chọn độ phức tạp</option>
                        <option value="simple">Đơn giản (1-2 món thông thường)</option>
                        <option value="medium">Trung bình (3-4 món hoặc món đặc biệt)</option>
                        <option value="complex">Phức tạp (5+ món hoặc đặt theo đơn)</option>
                    </select>
                </div>
                <button id="estimateButton" class="btn-estimate">
                    <i class="fas fa-calculator"></i>
                    Ước tính thời gian
                </button>
            </div>
            <div class="estimator-result" id="estimateResult">
                <div class="result-placeholder">
                    <i class="fas fa-clock"></i>
                    <p>Nhập thông tin để ước tính thời gian giao hàng</p>
                </div>
            </div>
        </div>
    `;
    
    // Thêm CSS cho estimator
    const style = document.createElement('style');
    style.textContent = `
        .time-estimator {
            padding: 25px;
            background-color: var(--bg-light);
            border-radius: var(--radius);
            margin-top: 30px;
        }
        .time-estimator h4 {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            margin-bottom: 20px;
            color: var(--secondary-color);
        }
        .estimator-form {
            margin-bottom: 25px;
        }
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--secondary-color);
            font-size: 14px;
        }
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 16px;
            transition: var(--transition);
            background-color: white;
        }
        .form-group select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }
        .btn-estimate {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 15px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--radius);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }
        .btn-estimate:hover {
            background-color: var(--primary-dark);
            transform: translateY(-3px);
        }
        .estimator-result {
            padding: 25px;
            background-color: white;
            border-radius: var(--radius);
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .result-placeholder {
            color: var(--text-light);
        }
        .result-placeholder i {
            font-size: 48px;
            margin-bottom: 15px;
            color: var(--border-color);
        }
        .result-placeholder p {
            margin: 0;
            font-size: 16px;
        }
        .result-detailed {
            width: 100%;
        }
        .result-detailed h5 {
            font-size: 20px;
            margin-bottom: 15px;
            color: var(--secondary-color);
        }
        .time-breakdown {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        .time-item {
            padding: 15px;
            background-color: var(--bg-light);
            border-radius: var(--radius);
            text-align: center;
        }
        .time-item .time-value {
            display: block;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        .time-item .time-label {
            font-size: 14px;
            color: var(--text-light);
        }
        .total-time {
            padding: 20px;
            background-color: rgba(255, 107, 53, 0.1);
            border-radius: var(--radius);
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
        }
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            .time-breakdown {
                grid-template-columns: 1fr;
            }
        }
    `;
    document.head.appendChild(style);
    
    // Chèn estimator vào phần thời gian giao hàng
    const deliveryTimeSection = document.querySelector('#delivery-time .section-content');
    if (deliveryTimeSection) {
        // Tạo một container mới để chứa estimator
        const estimatorContainer = document.createElement('div');
        estimatorContainer.innerHTML = estimatorHTML;
        
        // Tìm vị trí để chèn estimator (sau phần estimated-time)
        const estimatedTimeDiv = deliveryTimeSection.querySelector('.estimated-time');
        if (estimatedTimeDiv) {
            estimatedTimeDiv.parentNode.insertBefore(estimatorContainer, estimatedTimeDiv.nextSibling);
            
            // Thêm sự kiện cho nút ước tính
            const estimateButton = document.getElementById('estimateButton');
            if (estimateButton) {
                estimateButton.addEventListener('click', estimateDeliveryTime);
            }
        }
    }
}

// Ước tính thời gian giao hàng
function estimateDeliveryTime() {
    const districtSelect = document.getElementById('estimateDistrict');
    const timeSelect = document.getElementById('estimateTime');
    const complexitySelect = document.getElementById('estimateComplexity');
    const resultDiv = document.getElementById('estimateResult');
    
    const district = districtSelect.value;
    const time = timeSelect.value;
    const complexity = complexitySelect.value;
    
    if (!district || !time || !complexity) {
        showNotification('Vui lòng điền đầy đủ thông tin để ước tính', 'warning');
        return;
    }
    
    // Tính toán thời gian cơ bản dựa trên quận
    let baseTime = 0;
    let areaLabel = '';
    
    switch (district) {
        case 'central':
            baseTime = 30;
            areaLabel = 'Khu vực trung tâm';
            break;
        case 'suburban':
            baseTime = 45;
            areaLabel = 'Khu vực ngoại thành';
            break;
        case 'other':
            baseTime = 60;
            areaLabel = 'Khu vực khác';
            break;
    }
    
    // Điều chỉnh thời gian dựa trên khung giờ
    let timeAdjustment = 0;
    let timeLabel = '';
    
    switch (time) {
        case 'normal':
            timeAdjustment = 0;
            timeLabel = 'Giờ bình thường';
            break;
        case 'peak':
            timeAdjustment = 15;
            timeLabel = 'Giờ cao điểm';
            break;
        case 'evening':
            timeAdjustment = 10;
            timeLabel = 'Buổi tối';
            break;
    }
    
    // Điều chỉnh thời gian dựa trên độ phức tạp
    let complexityAdjustment = 0;
    let complexityLabel = '';
    
    switch (complexity) {
        case 'simple':
            complexityAdjustment = 0;
            complexityLabel = 'Đơn giản';
            break;
        case 'medium':
            complexityAdjustment = 10;
            complexityLabel = 'Trung bình';
            break;
        case 'complex':
            complexityAdjustment = 20;
            complexityLabel = 'Phức tạp';
            break;
    }
    
    // Tính tổng thời gian
    const totalTime = baseTime + timeAdjustment + complexityAdjustment;
    
    // Hiển thị kết quả
    const resultHTML = `
        <div class="result-detailed">
            <h5><i class="fas fa-clock"></i> Kết quả ước tính</h5>
            <div class="time-breakdown">
                <div class="time-item">
                    <span class="time-value">${baseTime} phút</span>
                    <span class="time-label">Thời gian cơ bản<br>(${areaLabel})</span>
                </div>
                <div class="time-item">
                    <span class="time-value">+${timeAdjustment} phút</span>
                    <span class="time-label">Điều chỉnh<br>(${timeLabel})</span>
                </div>
                <div class="time-item">
                    <span class="time-value">+${complexityAdjustment} phút</span>
                    <span class="time-label">Độ phức tạp<br>(${complexityLabel})</span>
                </div>
            </div>
            <div class="total-time">
                Tổng thời gian ước tính: ${totalTime} phút
            </div>
            <div class="estimate-note">
                <p><small><i class="fas fa-info-circle"></i> Đây là thời gian ước tính. Thời gian thực tế có thể thay đổi tùy vào tình hình giao thông và điều kiện thời tiết.</small></p>
            </div>
        </div>
    `;
    
    resultDiv.innerHTML = resultHTML;
    showNotification('Đã ước tính thời gian giao hàng thành công!', 'success');
}

// Gọi hàm tạo estimator (bỏ comment nếu muốn sử dụng)
// initDeliveryTimeEstimator();