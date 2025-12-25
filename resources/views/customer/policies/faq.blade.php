<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Câu Hỏi Thường Gặp - Take Away Express</title>
    <link rel="stylesheet" href="{{ asset('css/faq.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="faq-container">
        <header class="faq-header">
            <div class="back-button">
                <a href="/" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    <span>Quay lại trang chủ</span>
                </a>
            </div>
            <div class="faq-logo">
                <i class="fas fa-question-circle"></i>
                <h1>Câu Hỏi Thường Gặp</h1>
                <p>Take Away Express</p>
            </div>
        </header>

        <main class="faq-content">
            <div class="faq-intro">
                <div class="last-updated">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Cập nhật lần cuối: 01/01/2024</span>
                </div>
                <p>Tại đây, bạn sẽ tìm thấy câu trả lời cho những câu hỏi phổ biến nhất về dịch vụ của Take Away Express. Nếu không tìm thấy câu trả lời bạn cần, vui lòng liên hệ với chúng tôi.</p>

                <div class="search-section">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="faqSearch" placeholder="Tìm kiếm câu hỏi hoặc từ khóa...">
                        <button id="clearSearch" class="btn-clear" title="Xóa tìm kiếm">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="search-tips">
                        <i class="fas fa-lightbulb"></i>
                        <span>Gợi ý tìm kiếm: đặt hàng, thanh toán, giao hàng, hoàn tiền, tài khoản</span>
                    </div>
                </div>

                <div class="faq-highlight">
                    <i class="fas fa-bolt"></i>
                    <div>
                        <h4>Tìm câu trả lời nhanh chóng</h4>
                        <p>Sử dụng công cụ tìm kiếm hoặc lọc theo danh mục để tìm thông tin bạn cần</p>
                    </div>
                </div>
            </div>

            <div class="faq-main">
                <aside class="faq-sidebar">
                    <div class="sidebar-sticky">
                        <h3><i class="fas fa-filter"></i> Lọc theo danh mục</h3>
                        <div class="category-filters">
                            <button class="category-filter active" data-category="all">
                                <i class="fas fa-layer-group"></i>
                                <span>Tất cả câu hỏi</span>
                                <span class="category-count">45</span>
                            </button>
                            <button class="category-filter" data-category="ordering">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Đặt hàng</span>
                                <span class="category-count">12</span>
                            </button>
                            <button class="category-filter" data-category="delivery">
                                <i class="fas fa-shipping-fast"></i>
                                <span>Giao hàng</span>
                                <span class="category-count">10</span>
                            </button>
                            <button class="category-filter" data-category="payment">
                                <i class="fas fa-credit-card"></i>
                                <span>Thanh toán</span>
                                <span class="category-count">8</span>
                            </button>
                            <button class="category-filter" data-category="account">
                                <i class="fas fa-user-circle"></i>
                                <span>Tài khoản</span>
                                <span class="category-count">6</span>
                            </button>
                            <button class="category-filter" data-category="refund">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Hoàn tiền</span>
                                <span class="category-count">5</span>
                            </button>
                            <button class="category-filter" data-category="technical">
                                <i class="fas fa-cog"></i>
                                <span>Vấn đề kỹ thuật</span>
                                <span class="category-count">4</span>
                            </button>
                        </div>

                        <div class="popular-questions">
                            <h4><i class="fas fa-fire"></i> Câu hỏi phổ biến</h4>
                            <div class="popular-list">
                                <a href="#faq-1" class="popular-link">
                                    <i class="fas fa-question"></i>
                                    <span>Làm thế nào để đặt hàng?</span>
                                </a>
                                <a href="#faq-5" class="popular-link">
                                    <i class="fas fa-question"></i>
                                    <span>Thời gian giao hàng là bao lâu?</span>
                                </a>
                                <a href="#faq-12" class="popular-link">
                                    <i class="fas fa-question"></i>
                                    <span>Các phương thức thanh toán nào được chấp nhận?</span>
                                </a>
                                <a href="#faq-18" class="popular-link">
                                    <i class="fas fa-question"></i>
                                    <span>Làm thế nào để yêu cầu hoàn tiền?</span>
                                </a>
                                <a href="#faq-25" class="popular-link">
                                    <i class="fas fa-question"></i>
                                    <span>Tôi có thể hủy đơn hàng sau khi đặt không?</span>
                                </a>
                            </div>
                        </div>

                        <div class="contact-help">
                            <h4><i class="fas fa-headset"></i> Cần hỗ trợ thêm?</h4>
                            <p>Nếu không tìm thấy câu trả lời, đội ngũ hỗ trợ của chúng tôi luôn sẵn sàng giúp đỡ.</p>
                            <div class="contact-buttons">
                                <a href="tel:0912345678" class="btn-contact">
                                    <i class="fas fa-phone-alt"></i>
                                    Gọi ngay
                                </a>
                                <a href="mailto:support@takeawayexpress.vn" class="btn-contact">
                                    <i class="fas fa-envelope"></i>
                                    Gửi email
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>

                <section class="faq-questions">
                    <div class="questions-header">
                        <h2><i class="fas fa-question-circle"></i> Tất cả câu hỏi</h2>
                        <div class="questions-stats">
                            <span id="questionsCount">45 câu hỏi</span>
                            <span id="filterStatus">Đang hiển thị: Tất cả</span>
                        </div>
                    </div>

                    <div class="questions-container" id="questionsContainer">
                        <!-- Category: Ordering -->
                        <div class="faq-category" id="category-ordering">
                            <div class="category-header">
                                <i class="fas fa-shopping-cart"></i>
                                <h3>Đặt hàng</h3>
                                <span class="category-badge">12 câu hỏi</span>
                            </div>

                            <div class="faq-item" id="faq-1" data-category="ordering">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q1</span>
                                        <h4>Làm thế nào để đặt hàng trên Take Away Express?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Để đặt hàng trên Take Away Express, bạn có thể thực hiện theo các bước sau:</p>
                                    <ol>
                                        <li>Truy cập website hoặc ứng dụng Take Away Express</li>
                                        <li>Đăng nhập vào tài khoản của bạn (hoặc đăng ký nếu chưa có)</li>
                                        <li>Chọn nhà hàng và món ăn bạn muốn đặt</li>
                                        <li>Thêm món vào giỏ hàng và kiểm tra lại đơn hàng</li>
                                        <li>Chọn phương thức thanh toán và nhập địa chỉ giao hàng</li>
                                        <li>Xác nhận đơn hàng và chờ xác nhận từ nhà hàng</li>
                                    </ol>
                                    <div class="answer-note">
                                        <i class="fas fa-info-circle"></i>
                                        <span>Bạn có thể đặt hàng trước tối đa 7 ngày trên ứng dụng của chúng tôi.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-2" data-category="ordering">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q2</span>
                                        <h4>Tôi có thể chỉnh sửa đơn hàng sau khi đặt không?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Có, bạn có thể chỉnh sửa đơn hàng trong một khoảng thời gian nhất định:</p>
                                    <ul>
                                        <li><strong>Trước khi nhà hàng xác nhận:</strong> Bạn có thể chỉnh sửa hoặc hủy đơn hàng bất kỳ lúc nào.</li>
                                        <li><strong>Sau khi nhà hàng xác nhận:</strong> Bạn có thể chỉnh sửa trong vòng 5 phút sau khi nhận được xác nhận.</li>
                                        <li><strong>Sau khi nhà hàng bắt đầu chế biến:</strong> Không thể chỉnh sửa đơn hàng. Vui lòng liên hệ hotline nếu có vấn đề khẩn cấp.</li>
                                    </ul>
                                    <p>Để chỉnh sửa đơn hàng, truy cập mục "Đơn hàng của tôi" trên ứng dụng/website và chọn "Chỉnh sửa".</p>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-3" data-category="ordering">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q3</span>
                                        <h4>Làm thế nào để đặt hàng cho người khác?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Bạn có thể dễ dàng đặt hàng cho người khác bằng cách:</p>
                                    <ol>
                                        <li>Trong quá trình đặt hàng, ở bước "Thông tin giao hàng", chọn "Giao đến địa chỉ khác"</li>
                                        <li>Nhập thông tin người nhận: tên, số điện thoại, địa chỉ giao hàng</li>
                                        <li>Thêm ghi chú đặc biệt nếu cần (ví dụ: đây là quà tặng, giao hàng kín đáo)</li>
                                        <li>Tiếp tục các bước thanh toán như bình thường</li>
                                    </ol>
                                    <div class="answer-note">
                                        <i class="fas fa-lightbulb"></i>
                                        <span>Bạn có thể lưu địa chỉ giao hàng cho người khác để sử dụng cho những lần đặt hàng sau.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-4" data-category="ordering">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q4</span>
                                        <h4>Đơn hàng tối thiểu là bao nhiêu?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Đơn hàng tối thiểu phụ thuộc vào nhà hàng và khu vực giao hàng:</p>
                                    <div class="answer-table">
                                        <div class="table-row">
                                            <div class="table-cell"><strong>Khu vực trung tâm</strong></div>
                                            <div class="table-cell">50.000đ</div>
                                        </div>
                                        <div class="table-row">
                                            <div class="table-cell"><strong>Khu vực ngoại thành</strong></div>
                                            <div class="table-cell">80.000đ</div>
                                        </div>
                                        <div class="table-row">
                                            <div class="table-cell"><strong>Khu vực khác</strong></div>
                                            <div class="table-cell">100.000đ</div>
                                        </div>
                                    </div>
                                    <p>Đơn hàng tối thiểu sẽ được hiển thị rõ ràng khi bạn chọn nhà hàng và địa chỉ giao hàng. Một số nhà hàng đối tác có thể có chính sách đơn tối thiểu riêng.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Category: Delivery -->
                        <div class="faq-category" id="category-delivery">
                            <div class="category-header">
                                <i class="fas fa-shipping-fast"></i>
                                <h3>Giao hàng</h3>
                                <span class="category-badge">10 câu hỏi</span>
                            </div>

                            <div class="faq-item" id="faq-5" data-category="delivery">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q5</span>
                                        <h4>Thời gian giao hàng là bao lâu?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Thời gian giao hàng phụ thuộc vào nhiều yếu tố:</p>
                                    <ul>
                                        <li><strong>Khoảng cách:</strong> 30-45 phút cho khu vực trung tâm, 45-60 phút cho khu vực ngoại thành</li>
                                        <li><strong>Thời điểm đặt hàng:</strong> Giờ cao điểm có thể lâu hơn 15-20 phút</li>
                                        <li><strong>Độ phức tạp của đơn hàng:</strong> Đơn hàng nhiều món hoặc món đặc biệt cần thêm thời gian chế biến</li>
                                        <li><strong>Thời tiết và giao thông:</strong> Ảnh hưởng đến tốc độ di chuyển của tài xế</li>
                                    </ul>
                                    <p>Khi đặt hàng, hệ thống sẽ hiển thị thời gian giao hàng dự kiến chính xác cho đơn hàng của bạn.</p>
                                    <div class="answer-note">
                                        <i class="fas fa-clock"></i>
                                        <span>Bạn có thể theo dõi trạng thái đơn hàng và vị trí tài xế thời gian thực trên ứng dụng.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-6" data-category="delivery">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q6</span>
                                        <h4>Take Away Express giao hàng đến những khu vực nào?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Hiện tại, Take Away Express phục vụ tại các quận thuộc TP.HCM:</p>
                                    <div class="answer-columns">
                                        <div class="column">
                                            <h5>Khu vực trung tâm (30-45 phút)</h5>
                                            <ul>
                                                <li>Quận 1, 3, 5, 10</li>
                                                <li>Phú Nhuận, Bình Thạnh</li>
                                            </ul>
                                        </div>
                                        <div class="column">
                                            <h5>Khu vực ngoại thành (45-60 phút)</h5>
                                            <ul>
                                                <li>Quận 2, 7, 9, 12</li>
                                                <li>Thủ Đức, Gò Vấp</li>
                                            </ul>
                                        </div>
                                        <div class="column">
                                            <h5>Khu vực khác (60-75 phút)</h5>
                                            <ul>
                                                <li>Quận 4, 6, 8, 11</li>
                                                <li>Tân Bình, Tân Phú</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p>Chúng tôi đang mở rộng phạm vi phục vụ. Để kiểm tra chính xác khu vực của bạn, vui lòng sử dụng công cụ kiểm tra trên website hoặc liên hệ hotline.</p>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-7" data-category="delivery">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q7</span>
                                        <h4>Làm thế nào để theo dõi đơn hàng của tôi?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Có nhiều cách để theo dõi đơn hàng của bạn:</p>
                                    <div class="tracking-methods">
                                        <div class="method">
                                            <div class="method-icon">
                                                <i class="fas fa-mobile-alt"></i>
                                            </div>
                                            <div class="method-content">
                                                <h5>Ứng dụng di động</h5>
                                                <p>Theo dõi trực tiếp trên ứng dụng Take Away Express với bản đồ thời gian thực, hiển thị vị trí tài xế và thời gian đến ước tính.</p>
                                            </div>
                                        </div>
                                        <div class="method">
                                            <div class="method-icon">
                                                <i class="fas fa-sms"></i>
                                            </div>
                                            <div class="method-content">
                                                <h5>Tin nhắn SMS/Email</h5>
                                                <p>Nhận cập nhật tự động qua SMS và email về trạng thái đơn hàng: xác nhận, đang chế biến, đang giao, đã giao.</p>
                                            </div>
                                        </div>
                                        <div class="method">
                                            <div class="method-icon">
                                                <i class="fas fa-desktop"></i>
                                            </div>
                                            <div class="method-content">
                                                <h5>Website</h5>
                                                <p>Truy cập mục "Theo dõi đơn hàng" trên website, nhập mã đơn hàng để xem trạng thái cập nhật.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-8" data-category="delivery">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q8</span>
                                        <h4>Tôi có thể thay đổi địa chỉ giao hàng sau khi đặt hàng không?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Có, bạn có thể thay đổi địa chỉ giao hàng trong một số trường hợp:</p>
                                    <ul>
                                        <li><strong>Trước khi nhà hàng xác nhận:</strong> Thay đổi trực tiếp trên ứng dụng/website</li>
                                        <li><strong>Sau khi nhà hàng xác nhận nhưng chưa chế biến:</strong> Liên hệ hotline để được hỗ trợ thay đổi</li>
                                        <li><strong>Sau khi nhà hàng bắt đầu chế biến:</strong> Không thể thay đổi địa chỉ. Nếu cần thiết, vui lòng hủy đơn và đặt lại (có thể áp dụng phí hủy)</li>
                                    </ul>
                                    <div class="answer-note warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <span>Thay đổi địa chỉ giao hàng có thể ảnh hưởng đến thời gian giao hàng và phí vận chuyển.</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Category: Payment -->
                        <div class="faq-category" id="category-payment">
                            <div class="category-header">
                                <i class="fas fa-credit-card"></i>
                                <h3>Thanh toán</h3>
                                <span class="category-badge">8 câu hỏi</span>
                            </div>

                            <div class="faq-item" id="faq-9" data-category="payment">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q9</span>
                                        <h4>Các phương thức thanh toán nào được chấp nhận?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Take Away Express chấp nhận nhiều phương thức thanh toán đa dạng:</p>
                                    <div class="payment-methods-grid">
                                        <div class="payment-method">
                                            <div class="payment-icon">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                            <div class="payment-info">
                                                <h5>Tiền mặt (COD)</h5>
                                                <p>Thanh toán khi nhận hàng</p>
                                            </div>
                                        </div>
                                        <div class="payment-method">
                                            <div class="payment-icon">
                                                <i class="fas fa-credit-card"></i>
                                            </div>
                                            <div class="payment-info">
                                                <h5>Thẻ tín dụng/ghi nợ</h5>
                                                <p>Visa, Mastercard, JCB</p>
                                            </div>
                                        </div>
                                        <div class="payment-method">
                                            <div class="payment-icon">
                                                <i class="fas fa-mobile-alt"></i>
                                            </div>
                                            <div class="payment-info">
                                                <h5>Ví điện tử</h5>
                                                <p>Momo, Zalopay, VNPay</p>
                                            </div>
                                        </div>
                                        <div class="payment-method">
                                            <div class="payment-icon">
                                                <i class="fas fa-university"></i>
                                            </div>
                                            <div class="payment-info">
                                                <h5>Chuyển khoản ngân hàng</h5>
                                                <p>Internet Banking</p>
                                            </div>
                                        </div>
                                        <div class="payment-method">
                                            <div class="payment-icon">
                                                <i class="fas fa-wallet"></i>
                                            </div>
                                            <div class="payment-info">
                                                <h5>Take Away Wallet</h5>
                                                <p>Ví tích điểm của Take Away</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p>Một số phương thức thanh toán có thể không khả dụng với một số nhà hàng đối tác. Phương thức thanh toán sẽ được hiển thị rõ ràng trong quá trình đặt hàng.</p>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-10" data-category="payment">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q10</span>
                                        <h4>Tôi có thể thanh toán bằng ngoại tệ không?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Hiện tại, Take Away Express chỉ chấp nhận thanh toán bằng Đồng Việt Nam (VND).</p>
                                    <p>Nếu bạn sử dụng thẻ tín dụng/quốc tế, ngân hàng của bạn sẽ tự động chuyển đổi ngoại tệ sang VND theo tỷ giá của ngân hàng. Phí chuyển đổi ngoại tệ (nếu có) sẽ do ngân hàng phát hành thẻ quy định.</p>
                                    <div class="answer-note">
                                        <i class="fas fa-info-circle"></i>
                                        <span>Đối với thẻ quốc tế, vui lòng kiểm tra với ngân hàng phát hành thẻ về phí chuyển đổi ngoại tệ và các hạn chế giao dịch quốc tế.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-11" data-category="payment">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q11</span>
                                        <h4>Làm thế nào để sử dụng mã giảm giá/voucher?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Để sử dụng mã giảm giá hoặc voucher, làm theo các bước sau:</p>
                                    <ol>
                                        <li>Thêm món ăn vào giỏ hàng</li>
                                        <li>Ở trang thanh toán, tìm ô "Mã giảm giá" hoặc "Áp dụng voucher"</li>
                                        <li>Nhập mã và nhấn "Áp dụng"</li>
                                        <li>Hệ thống sẽ tự động tính toán số tiền giảm giá</li>
                                    </ol>
                                    <div class="answer-note">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>Mỗi mã giảm giá/voucher có điều kiện sử dụng riêng (đơn hàng tối thiểu, áp dụng cho nhà hàng cụ thể, thời hạn sử dụng). Vui lòng kiểm tra kỹ điều kiện trước khi sử dụng.</span>
                                    </div>
                                    <p>Nếu gặp vấn đề khi áp dụng mã, vui lòng liên hệ hotline hỗ trợ với mã voucher và mã đơn hàng để được hỗ trợ.</p>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-12" data-category="payment">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q12</span>
                                        <h4>Tại sao giao dịch thanh toán của tôi thất bại?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Có nhiều lý do khiến giao dịch thanh toán thất bại:</p>
                                    <div class="failure-reasons">
                                        <div class="reason">
                                            <h5><i class="fas fa-credit-card"></i> Vấn đề với thẻ/tài khoản</h5>
                                            <ul>
                                                <li>Thẻ hết hạn hoặc bị khóa</li>
                                                <li>Số dư không đủ</li>
                                                <li>Vượt hạn mức giao dịch</li>
                                                <li>Thông tin thẻ không chính xác</li>
                                            </ul>
                                        </div>
                                        <div class="reason">
                                            <h5><i class="fas fa-wifi"></i> Vấn đề kết nối</h5>
                                            <ul>
                                                <li>Mất kết nối internet trong khi thanh toán</li>
                                                <li>Hệ thống ngân hàng bảo trì</li>
                                                <li>Kết nối không ổn định</li>
                                            </ul>
                                        </div>
                                        <div class="reason">
                                            <h5><i class="fas fa-cog"></i> Vấn đề kỹ thuật</h5>
                                            <ul>
                                                <li>Lỗi hệ thống thanh toán tạm thời</li>
                                                <li>Trình duyệt/ứng dụng cần cập nhật</li>
                                                <li>Cookie/cache trình duyệt</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p><strong>Giải pháp khắc phục:</strong></p>
                                    <ul>
                                        <li>Kiểm tra lại thông tin thẻ/tài khoản</li>
                                        <li>Thử lại sau 5-10 phút</li>
                                        <li>Thử phương thức thanh toán khác</li>
                                        <li>Liên hệ ngân hàng phát hành thẻ</li>
                                        <li>Liên hệ hotline Take Away Express nếu vẫn gặp vấn đề</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Category: Account -->
                        <div class="faq-category" id="category-account">
                            <div class="category-header">
                                <i class="fas fa-user-circle"></i>
                                <h3>Tài khoản</h3>
                                <span class="category-badge">6 câu hỏi</span>
                            </div>

                            <div class="faq-item" id="faq-13" data-category="account">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q13</span>
                                        <h4>Làm thế nào để đăng ký tài khoản?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Đăng ký tài khoản Take Away Express rất đơn giản:</p>
                                    <ol>
                                        <li>Truy cập website hoặc tải ứng dụng Take Away Express</li>
                                        <li>Nhấn nút "Đăng ký" hoặc "Tạo tài khoản"</li>
                                        <li>Nhập thông tin: số điện thoại, email, mật khẩu</li>
                                        <li>Xác minh số điện thoại qua mã OTP được gửi qua SMS</li>
                                        <li>Hoàn tất hồ sơ cá nhân (tên, địa chỉ)</li>
                                        <li>Nhấn "Hoàn tất đăng ký"</li>
                                    </ol>
                                    <div class="answer-note">
                                        <i class="fas fa-gift"></i>
                                        <span>Khi đăng ký tài khoản mới, bạn sẽ nhận được voucher 50.000đ cho đơn hàng đầu tiên.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-14" data-category="account">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q14</span>
                                        <h4>Tôi quên mật khẩu, làm thế nào để lấy lại?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Để lấy lại mật khẩu, thực hiện các bước sau:</p>
                                    <ol>
                                        <li>Truy cập trang đăng nhập trên website/ứng dụng</li>
                                        <li>Nhấn "Quên mật khẩu?"</li>
                                        <li>Nhập số điện thoại hoặc email đã đăng ký</li>
                                        <li>Nhấn "Gửi mã xác nhận"</li>
                                        <li>Nhập mã OTP nhận được qua SMS/email</li>
                                        <li>Tạo mật khẩu mới (tối thiểu 8 ký tự, bao gồm chữ và số)</li>
                                        <li>Xác nhận mật khẩu mới và nhấn "Đổi mật khẩu"</li>
                                    </ol>
                                    <div class="answer-note warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <span>Nếu không nhận được mã OTP, vui lòng kiểm tra hộp thư spam hoặc liên hệ hotline để được hỗ trợ.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-15" data-category="account">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q15</span>
                                        <h4>Làm thế nào để cập nhật thông tin cá nhân?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Để cập nhật thông tin cá nhân:</p>
                                    <ol>
                                        <li>Đăng nhập vào tài khoản Take Away Express</li>
                                        <li>Nhấn vào biểu tượng tài khoản/avatar ở góc phải</li>
                                        <li>Chọn "Cài đặt tài khoản" hoặc "Thông tin cá nhân"</li>
                                        <li>Cập nhật các thông tin cần thay đổi:
                                            <ul>
                                                <li><strong>Thông tin cơ bản:</strong> Tên, ngày sinh, giới tính</li>
                                                <li><strong>Liên hệ:</strong> Số điện thoại, email (cần xác minh OTP)</li>
                                                <li><strong>Địa chỉ:</strong> Thêm, chỉnh sửa hoặc xóa địa chỉ giao hàng</li>
                                                <li><strong>Bảo mật:</strong> Thay đổi mật khẩu, cài đặt xác thực 2 lớp</li>
                                            </ul>
                                        </li>
                                        <li>Nhấn "Lưu thay đổi"</li>
                                    </ol>
                                    <p>Một số thông tin như số điện thoại và email chính cần xác minh OTP để đảm bảo bảo mật.</p>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-16" data-category="account">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q16</span>
                                        <h4>Làm thế nào để xóa tài khoản của tôi?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Để xóa tài khoản Take Away Express, vui lòng thực hiện theo các bước sau:</p>
                                    <ol>
                                        <li>Đăng nhập vào tài khoản của bạn</li>
                                        <li>Truy cập "Cài đặt tài khoản" → "Bảo mật"</li>
                                        <li>Chọn "Xóa tài khoản"</li>
                                        <li>Đọc kỹ thông báo về hậu quả của việc xóa tài khoản:
                                            <ul>
                                                <li>Mất toàn bộ lịch sử đơn hàng</li>
                                                <li>Mất điểm tích lũy và voucher chưa sử dụng</li>
                                                <li>Không thể khôi phục tài khoản sau khi xóa</li>
                                            </ul>
                                        </li>
                                        <li>Nhập mật khẩu để xác nhận</li>
                                        <li>Nhấn "Xác nhận xóa tài khoản"</li>
                                    </ol>
                                    <div class="answer-note warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <span>Quá trình xóa tài khoản có thể mất đến 30 ngày để hoàn tất. Trong thời gian này, bạn có thể hủy yêu cầu bằng cách liên hệ bộ phận hỗ trợ.</span>
                                    </div>
                                    <p>Nếu gặp khó khăn trong việc xóa tài khoản, vui lòng liên hệ hotline hoặc gửi email đến <a href="mailto:support@takeawayexpress.vn">support@takeawayexpress.vn</a> với tiêu đề "Yêu cầu xóa tài khoản".</p>
                                </div>
                            </div>
                        </div>

                        <!-- Category: Refund -->
                        <div class="faq-category" id="category-refund">
                            <div class="category-header">
                                <i class="fas fa-money-bill-wave"></i>
                                <h3>Hoàn tiền</h3>
                                <span class="category-badge">5 câu hỏi</span>
                            </div>

                            <div class="faq-item" id="faq-17" data-category="refund">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q17</span>
                                        <h4>Trường hợp nào được hoàn tiền?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Take Away Express hoàn tiền trong các trường hợp sau:</p>
                                    <div class="refund-cases">
                                        <div class="case">
                                            <h5><i class="fas fa-utensils"></i> Vấn đề về thực phẩm</h5>
                                            <ul>
                                                <li>Thực phẩm không đảm bảo chất lượng, an toàn vệ sinh</li>
                                                <li>Có vật lạ trong thức ăn</li>
                                                <li>Món ăn bị hỏng, ôi thiu</li>
                                            </ul>
                                        </div>
                                        <div class="case">
                                            <h5><i class="fas fa-box-open"></i> Vấn đề về đơn hàng</h5>
                                            <ul>
                                                <li>Thiếu món, sai món so với đơn đặt</li>
                                                <li>Giao sai địa chỉ do lỗi của Take Away</li>
                                                <li>Đơn hàng bị hủy do lỗi hệ thống</li>
                                            </ul>
                                        </div>
                                        <div class="case">
                                            <h5><i class="fas fa-clock"></i> Vấn đề về thời gian</h5>
                                            <ul>
                                                <li>Giao hàng trễ quá 60 phút không có thông báo</li>
                                                <li>Hủy đơn trước khi nhà hàng chế biến</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p><strong>Lưu ý quan trọng:</strong> Yêu cầu hoàn tiền cần được gửi trong vòng 30 phút sau khi nhận hàng và có đầy đủ bằng chứng (hình ảnh, video).</p>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-18" data-category="refund">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q18</span>
                                        <h4>Làm thế nào để yêu cầu hoàn tiền?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Để yêu cầu hoàn tiền, thực hiện theo các bước sau:</p>
                                    <ol>
                                        <li><strong>Báo cáo ngay lập tức:</strong> Liên hệ hotline hoặc chat trực tuyến trong vòng 30 phút sau khi nhận hàng</li>
                                        <li><strong>Cung cấp thông tin:</strong> Mã đơn hàng, mô tả vấn đề gặp phải</li>
                                        <li><strong>Cung cấp bằng chứng:</strong> Chụp ảnh/video rõ ràng về sản phẩm và vấn đề</li>
                                        <li><strong>Chờ xác minh:</strong> Đội ngũ hỗ trợ sẽ xem xét và liên hệ lại trong 1 giờ làm việc</li>
                                        <li><strong>Nhận giải pháp:</strong> Nhận đề xuất giải pháp: giao lại, hoàn tiền, voucher bồi thường</li>
                                        <li><strong>Nhận hoàn tiền:</strong> Nếu được chấp thuận, tiền sẽ được hoàn trong 1-10 ngày tùy phương thức thanh toán</li>
                                    </ol>
                                    <div class="answer-note">
                                        <i class="fas fa-info-circle"></i>
                                        <span>Bạn cũng có thể gửi yêu cầu hoàn tiền qua email đến <a href="mailto:refund@takeawayexpress.vn">refund@takeawayexpress.vn</a> với đầy đủ thông tin và bằng chứng.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-19" data-category="refund">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q19</span>
                                        <h4>Thời gian xử lý hoàn tiền là bao lâu?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Thời gian xử lý hoàn tiền phụ thuộc vào phương thức thanh toán ban đầu:</p>
                                    <div class="refund-timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-content">
                                                <h5>Ví điện tử (Momo, Zalopay)</h5>
                                                <p>24-48 giờ</p>
                                            </div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-content">
                                                <h5>Thẻ tín dụng/ghi nợ</h5>
                                                <p>5-10 ngày làm việc</p>
                                            </div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-content">
                                                <h5>Chuyển khoản ngân hàng</h5>
                                                <p>1-3 ngày làm việc</p>
                                            </div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-content">
                                                <h5>Take Away Wallet</h5>
                                                <p>Ngay lập tức</p>
                                            </div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-content">
                                                <h5>Tiền mặt (COD)</h5>
                                                <p>3-5 ngày làm việc (chuyển khoản/ví điện tử)</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p>Thời gian trên là ước tính và có thể thay đổi tùy thuộc vào ngân hàng, nhà cung cấp dịch vụ thanh toán. Bạn sẽ nhận được email/SMS xác nhận khi hoàn tiền thành công.</p>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-20" data-category="refund">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q20</span>
                                        <h4>Tôi thanh toán bằng tiền mặt, làm thế nào để nhận hoàn tiền?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Nếu bạn thanh toán bằng tiền mặt (COD), chúng tôi sẽ hoàn tiền qua một trong các phương thức sau:</p>
                                    <div class="cash-refund-methods">
                                        <div class="method">
                                            <div class="method-icon">
                                                <i class="fas fa-university"></i>
                                            </div>
                                            <div class="method-content">
                                                <h5>Chuyển khoản ngân hàng</h5>
                                                <p>Cung cấp thông tin tài khoản ngân hàng: số tài khoản, tên ngân hàng, tên chủ tài khoản.</p>
                                            </div>
                                        </div>
                                        <div class="method">
                                            <div class="method-icon">
                                                <i class="fas fa-mobile-alt"></i>
                                            </div>
                                            <div class="method-content">
                                                <h5>Ví điện tử</h5>
                                                <p>Cung cấp số điện thoại đăng ký ví điện tử (Momo, Zalopay, VNPay).</p>
                                            </div>
                                        </div>
                                        <div class="method">
                                            <div class="method-icon">
                                                <i class="fas fa-wallet"></i>
                                            </div>
                                            <div class="method-content">
                                                <h5>Take Away Wallet</h5>
                                                <p>Nhận tiền hoàn vào ví Take Away để sử dụng cho đơn hàng tiếp theo (khuyến khích).</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p><strong>Quy trình:</strong></p>
                                    <ol>
                                        <li>Yêu cầu hoàn tiền được chấp thuận</li>
                                        <li>Cung cấp thông tin nhận tiền (số tài khoản/số điện thoại ví)</li>
                                        <li>Xác minh thông tin (có thể yêu cầu ảnh chụp CMND/CCCD)</li>
                                        <li>Nhận tiền trong 3-5 ngày làm việc</li>
                                    </ol>
                                    <div class="answer-note">
                                        <i class="fas fa-lightbulb"></i>
                                        <span>Chúng tôi khuyến khích chọn nhận voucher Take Away có giá trị cao hơn 10-20% so với số tiền hoàn.</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Category: Technical -->
                        <div class="faq-category" id="category-technical">
                            <div class="category-header">
                                <i class="fas fa-cog"></i>
                                <h3>Vấn đề kỹ thuật</h3>
                                <span class="category-badge">4 câu hỏi</span>
                            </div>

                            <div class="faq-item" id="faq-21" data-category="technical">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q21</span>
                                        <h4>Ứng dụng bị treo/crash, tôi phải làm gì?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Nếu ứng dụng Take Away Express bị treo hoặc crash, thử các giải pháp sau:</p>
                                    <div class="troubleshooting-steps">
                                        <div class="step">
                                            <div class="step-number">1</div>
                                            <div class="step-content">
                                                <h5>Khởi động lại ứng dụng</h5>
                                                <p>Đóng hoàn toàn ứng dụng và mở lại.</p>
                                            </div>
                                        </div>
                                        <div class="step">
                                            <div class="step-number">2</div>
                                            <div class="step-content">
                                                <h5>Kiểm tra kết nối internet</h5>
                                                <p>Đảm bảo bạn có kết nối mạng ổn định (WiFi/3G/4G/5G).</p>
                                            </div>
                                        </div>
                                        <div class="step">
                                            <div class="step-number">3</div>
                                            <div class="step-content">
                                                <h5>Cập nhật ứng dụng</h5>
                                                <p>Kiểm tra và cập nhật phiên bản mới nhất trên App Store/Google Play.</p>
                                            </div>
                                        </div>
                                        <div class="step">
                                            <div class="step-number">4</div>
                                            <div class="step-content">
                                                <h5>Xóa cache ứng dụng</h5>
                                                <p>Vào Cài đặt > Ứng dụng > Take Away Express > Bộ nhớ > Xóa cache.</p>
                                            </div>
                                        </div>
                                        <div class="step">
                                            <div class="step-number">5</div>
                                            <div class="step-content">
                                                <h5>Khởi động lại thiết bị</h5>
                                                <p>Khởi động lại điện thoại/tablet của bạn.</p>
                                            </div>
                                        </div>
                                        <div class="step">
                                            <div class="step-number">6</div>
                                            <div class="step-content">
                                                <h5>Gỡ và cài đặt lại</h5>
                                                <p>Gỡ ứng dụng và cài đặt lại từ cửa hàng ứng dụng chính thức.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p>Nếu vẫn gặp vấn đề, vui lòng liên hệ bộ phận hỗ trợ kỹ thuật qua hotline hoặc email <a href="mailto:techsupport@takeawayexpress.vn">techsupport@takeawayexpress.vn</a> với thông tin: loại thiết bị, hệ điều hành, phiên bản ứng dụng, mô tả chi tiết lỗi.</p>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-22" data-category="technical">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q22</span>
                                        <h4>Tại sao tôi không nhận được mã OTP?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Có nhiều lý do khiến bạn không nhận được mã OTP:</p>
                                    <div class="otp-issues">
                                        <div class="issue">
                                            <h5><i class="fas fa-mobile-alt"></i> Vấn đề với số điện thoại</h5>
                                            <ul>
                                                <li>Số điện thoại không chính xác</li>
                                                <li>SIM bị mất sóng/tắt máy</li>
                                                <li>Số điện thoại đã thay đổi nhưng chưa cập nhật trên tài khoản</li>
                                            </ul>
                                        </div>
                                        <div class="issue">
                                            <h5><i class="fas fa-inbox"></i> Vấn đề nhận tin nhắn</h5>
                                            <ul>
                                                <li>Hộp thư đầy</li>
                                                <li>Chặn tin nhắn từ số lạ</li>
                                                <li>Lỗi nhà mạng (tạm thời)</li>
                                            </ul>
                                        </div>
                                        <div class="issue">
                                            <h5><i class="fas fa-cog"></i> Vấn đề kỹ thuật</h5>
                                            <ul>
                                                <li>Hệ thống gửi OTP bảo trì</li>
                                                <li>Vượt quá giới hạn gửi OTP (tối đa 5 lần/ngày)</li>
                                                <li>Lỗi ứng dụng/website</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p><strong>Giải pháp khắc phục:</strong></p>
                                    <ol>
                                        <li>Kiểm tra số điện thoại đã nhập có chính xác không</li>
                                        <li>Kiểm tra hộp thư SMS, thư mục spam/quảng cáo</li>
                                        <li>Đảm bảo điện thoại có sóng và không chặn số lạ</li>
                                        <li>Thử lại sau 5-10 phút</li>
                                        <li>Yêu cầu gửi lại mã OTP (chờ đủ 60 giây trước khi yêu cầu lại)</li>
                                        <li>Liên hệ hotline để được hỗ trợ gửi mã OTP qua cuộc gọi</li>
                                    </ol>
                                    <div class="answer-note">
                                        <i class="fas fa-info-circle"></i>
                                        <span>Mã OTP có hiệu lực trong 5 phút. Nếu hết hạn, bạn cần yêu cầu mã mới.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-23" data-category="technical">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q23</span>
                                        <h4>Tại sao website không tải được hoặc báo lỗi?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Các nguyên nhân phổ biến khiến website không tải được hoặc báo lỗi:</p>
                                    <div class="website-issues">
                                        <div class="issue">
                                            <h5><i class="fas fa-wifi"></i> Vấn đề kết nối</h5>
                                            <ul>
                                                <li>Mất kết nối internet</li>
                                                <li>Mạng yếu, không ổn định</li>
                                                <li>Nhà mạng đang gặp sự cố</li>
                                            </ul>
                                        </div>
                                        <div class="issue">
                                            <h5><i class="fas fa-desktop"></i> Vấn đề trình duyệt</h5>
                                            <ul>
                                                <li>Trình duyệt cũ, cần cập nhật</li>
                                                <li>Cookie/cache quá nhiều</li>
                                                <li>Tiện ích mở rộng gây xung đột</li>
                                                <li>JavaScript bị tắt</li>
                                            </ul>
                                        </div>
                                        <div class="issue">
                                            <h5><i class="fas fa-server"></i> Vấn đề máy chủ</h5>
                                            <ul>
                                                <li>Website bảo trì theo lịch trình</li>
                                                <li>Quá tải máy chủ (giờ cao điểm)</li>
                                                <li>Sự cố kỹ thuật tạm thời</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p><strong>Cách khắc phục:</strong></p>
                                    <ol>
                                        <li><strong>Kiểm tra kết nối internet:</strong> Thử truy cập website khác để xác định lỗi</li>
                                        <li><strong>Làm mới trang (F5):</strong> Nhấn F5 hoặc nút refresh</li>
                                        <li><strong>Xóa cache và cookie:</strong> Vào cài đặt trình duyệt > Xóa dữ liệu duyệt web</li>
                                        <li><strong>Thử trình duyệt khác:</strong> Chrome, Firefox, Safari, Edge</li>
                                        <li><strong>Tắt tiện ích mở rộng:</strong> Tạm thời tắt ad-blocker và các tiện ích khác</li>
                                        <li><strong>Kiểm tra thời gian:</strong> Đảm bảo ngày giờ trên máy tính chính xác</li>
                                        <li><strong>Thử lại sau:</strong> Chờ 15-30 phút và thử lại</li>
                                    </ol>
                                    <p>Nếu website vẫn không hoạt động, có thể chúng tôi đang bảo trì hệ thống. Vui lòng theo dõi thông báo trên trang Facebook chính thức hoặc sử dụng ứng dụng di động thay thế.</p>
                                </div>
                            </div>

                            <div class="faq-item" id="faq-24" data-category="technical">
                                <div class="faq-question">
                                    <div class="question-header">
                                        <span class="question-number">Q24</span>
                                        <h4>Làm thế nào để báo cáo lỗi kỹ thuật?</h4>
                                    </div>
                                    <button class="faq-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="faq-answer">
                                    <p>Để báo cáo lỗi kỹ thuật, vui lòng cung cấp càng nhiều thông tin chi tiết càng tốt:</p>
                                    <div class="bug-report-form">
                                        <h5>Thông tin cần cung cấp:</h5>
                                        <ul>
                                            <li><strong>Mô tả lỗi:</strong> Chuyện gì xảy ra? Bạn đang làm gì khi lỗi xuất hiện?</li>
                                            <li><strong>Thiết bị:</strong> Điện thoại/tablet/máy tính (hãng, model)</li>
                                            <li><strong>Hệ điều hành:</strong> iOS/Android/Windows/macOS (phiên bản)</li>
                                            <li><strong>Phiên bản ứng dụng:</strong> Số phiên bản (tìm trong Cài đặt > Giới thiệu)</li>
                                            <li><strong>Trình duyệt:</strong> Chrome/Firefox/Safari/Edge (phiên bản, nếu dùng website)</li>
                                            <li><strong>Ảnh chụp màn hình/video:</strong> Ghi lại lỗi nếu có thể</li>
                                            <li><strong>Mã lỗi:</strong> Nếu có thông báo lỗi cụ thể</li>
                                            <li><strong>Thời gian xảy ra lỗi:</strong> Ngày, giờ chính xác</li>
                                        </ul>
                                    </div>
                                    <p><strong>Cách gửi báo cáo lỗi:</strong></p>
                                    <div class="report-methods">
                                        <div class="method">
                                            <div class="method-icon">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <div class="method-content">
                                                <h5>Email</h5>
                                                <p>Gửi đến <a href="mailto:bugs@takeawayexpress.vn">bugs@takeawayexpress.vn</a> với tiêu đề "[Báo lỗi] - [Mô tả ngắn]"</p>
                                            </div>
                                        </div>
                                        <div class="method">
                                            <div class="method-icon">
                                                <i class="fas fa-comment-alt"></i>
                                            </div>
                                            <div class="method-content">
                                                <h5>Chat trực tuyến</h5>
                                                <p>Chat với bộ phận hỗ trợ kỹ thuật trên website/ứng dụng</p>
                                            </div>
                                        </div>
                                        <div class="method">
                                            <div class="method-icon">
                                                <i class="fas fa-phone-alt"></i>
                                            </div>
                                            <div class="method-content">
                                                <h5>Hotline kỹ thuật</h5>
                                                <p>Gọi 0912 345 680 (Nhánh 4) trong giờ hành chính</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="answer-note">
                                        <i class="fas fa-lightbulb"></i>
                                        <span>Báo cáo lỗi chi tiết giúp chúng tôi khắc phục nhanh hơn. Bạn có thể nhận được voucher cảm ơn khi báo cáo lỗi nghiêm trọng.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="no-results" id="noResults" style="display: none;">
                        <div class="no-results-content">
                            <i class="fas fa-search"></i>
                            <h3>Không tìm thấy kết quả phù hợp</h3>
                            <p>Không có câu hỏi nào khớp với tìm kiếm của bạn. Vui lòng thử:</p>
                            <ul>
                                <li>Kiểm tra lại từ khóa tìm kiếm</li>
                                <li>Sử dụng từ khóa ngắn gọn hơn</li>
                                <li>Thử danh mục khác</li>
                                <li>Liên hệ bộ phận hỗ trợ trực tiếp</li>
                            </ul>
                            <button id="resetSearch" class="btn-reset">
                                <i class="fas fa-redo"></i>
                                Hiển thị tất cả câu hỏi
                            </button>
                        </div>
                    </div>
                </section>
            </div>

            <div class="faq-footer">
                <div class="still-questions">
                    <div class="still-questions-content">
                        <h3><i class="fas fa-question-circle"></i> Vẫn còn thắc mắc?</h3>
                        <p>Đội ngũ hỗ trợ của Take Away Express luôn sẵn sàng giải đáp mọi thắc mắc của bạn.</p>
                        <div class="contact-options">
                            <div class="contact-option">
                                <div class="option-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="option-details">
                                    <h4>Gọi cho chúng tôi</h4>
                                    <p>0912 345 678</p>
                                    <span>8:00 - 22:00 hàng ngày</span>
                                </div>
                            </div>
                            <div class="contact-option">
                                <div class="option-icon">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div class="option-details">
                                    <h4>Chat trực tuyến</h4>
                                    <p>Trên website hoặc ứng dụng</p>
                                    <span>Phản hồi trong vòng 5 phút</span>
                                </div>
                            </div>
                            <div class="contact-option">
                                <div class="option-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="option-details">
                                    <h4>Gửi email</h4>
                                    <p>support@takeawayexpress.vn</p>
                                    <span>Phản hồi trong vòng 24 giờ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="quick-nav">
                    <h4>Chính sách liên quan:</h4>
                    <div class="nav-links">
                        <a href="{{ route('policy.shipping') }}"><i class="fas fa-shipping-fast"></i> Chính sách giao hàng</a>
                        <a href="{{ route('policy.refund') }}"><i class="fas fa-money-bill-wave"></i> Chính sách hoàn tiền</a>
                        <a href="/"><i class="fas fa-home"></i> Trang chủ</a>
                    </div>
                </div>

                <div class="update-notice">
                    <div class="notice-content">
                        <i class="fas fa-bullhorn"></i>
                        <div>
                            <h4>Cập nhật FAQ</h4>
                            <p>Trang FAQ được cập nhật thường xuyên với các câu hỏi mới nhất từ khách hàng. Hãy quay lại thường xuyên để xem cập nhật.</p>
                        </div>
                    </div>
                </div>

                <div class="copyright">
                    <p>&copy; 2024 <strong>Take Away Express</strong>. Tất cả các quyền được bảo lưu.</p>
                    <p class="version">Phiên bản FAQ: 3.0 | Số câu hỏi: 45 | Ngày cập nhật: 01/01/2024</p>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/faq.js') }}"></script>
</body>
</html>
