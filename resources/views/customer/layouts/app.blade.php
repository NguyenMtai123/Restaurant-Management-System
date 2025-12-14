<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Take Away Express')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    @stack('styles')
<style>
     .menu-items {
    display: flex;
    flex-wrap: wrap;
    gap: 20px; /* Khoảng cách giữa các món */
    justify-content: center; /* Canh giữa */
    margin-top: 20px;
}

.menu-item {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    flex: 1 1 250px; /* Tự động co giãn, min-width 250px */
    max-width: 300px; /* Giới hạn chiều rộng */
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.menu-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.menu-image img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.menu-content {
    padding: 15px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.menu-content h4 {
    font-size: 1.1rem;
    margin-bottom: 10px;
}

.menu-content p {
    font-size: 0.9rem;
    color: #555;
    flex: 1;
}

.menu-price {
    font-weight: bold;
    margin-top: 10px;
    display: block;
    color: #e63946;
}

.add-to-cart {
    margin-top: 10px;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5px;
}
</style>
</head>
<body>
    @include('customer.partials.loader')
    @include('customer.partials.toast')
    @include('customer.partials.promotion')

    @include('customer.partials.header')

    <main>
        @yield('content')
    </main>

    @include('customer.partials.footer')


    <button class="back-to-top" id="backToTop">
      <i class="fas fa-chevron-up"></i>
    </button>

    @include('customer.partials.cart-sidebar')

    <!-- Product Quick View Modal -->
    @include('customer.partials.quick-view-modal')

    <!-- Order Online Modal -->
    @include('customer.partials.order-online-modal')

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartItemsContainer = document.getElementById('cartItems');
            // Thêm vào giỏ
            document.querySelectorAll('.add-to-cart').forEach(btn => {
                btn.addEventListener('click', function() {
            const itemId = this.dataset.id;
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ item_id: itemId })
            })
            .then(res => res.json())
            .then(cart => {
                updateCartUI(cart);
                showCartMessage('Đã thêm món vào giỏ hàng!', 'success');
            });
        });

        });

        // Cập nhật giao diện giỏ
        function updateCartUI(cart) {
        cartItemsContainer.innerHTML = ''; // xóa nội dung cũ
        if(cart.items.length === 0) {
            cartItemsContainer.innerHTML = `<div class="empty-cart">
                <i class="fas fa-shopping-basket"></i>
                <p>Giỏ hàng của bạn đang trống</p>
                <a href="#menu" class="btn btn-primary">Xem thực đơn</a>
            </div>`;
            document.querySelector('.cart-subtotal').textContent = '0 đ';
            document.querySelector('.cart-total').textContent = '0 đ';
            return;
        }

        let subtotal = 0;
        cart.items.forEach((item) => {
            subtotal += item.quantity * item.menu_item.price;

            const cartItemElement = document.createElement("div");
            cartItemElement.className = "cart-item";
            cartItemElement.dataset.id = item.menu_item.id;
            const imageUrl = item.menu_item.featured_image_url ?? '/images/menu/default.png';
            cartItemElement.innerHTML = `
                <div class="cart-item-image">
                    <img src="${imageUrl}" alt="${item.menu_item.name}">
                </div>
                <div class="cart-item-info">
                    <div class="cart-item-header">
                        <h4 class="cart-item-name">${item.menu_item.name}</h4>
                        <span class="cart-item-price">${(item.menu_item.price).toLocaleString()} đ</span>
                    </div>
                    <div class="cart-item-actions">
                        <div class="quantity-control">
                            <button class="quantity-btn decrease-btn" data-id="${item.menu_item.id}">-</button>
                            <span class="cart-item-quantity">${item.quantity}</span>
                            <button class="quantity-btn increase-btn" data-id="${item.menu_item.id}">+</button>
                        </div>
                        <button class="remove-item" data-id="${item.menu_item.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            cartItemsContainer.appendChild(cartItemElement);
        });

        document.querySelector('.cart-subtotal').textContent = subtotal.toLocaleString() + ' đ';
        document.querySelector('.cart-total').textContent = subtotal.toLocaleString() + ' đ';

        // Gắn sự kiện cho nút + / - / xóa
        cartItemsContainer.querySelectorAll('.increase-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const parent = this.closest('.cart-item');
                const quantityEl = parent.querySelector('.cart-item-quantity');
                let quantity = parseInt(quantityEl.textContent) + 1;
                quantityEl.textContent = quantity;
                updateQuantity(parent.dataset.id, quantity);
            });
        });

        cartItemsContainer.querySelectorAll('.decrease-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const parent = this.closest('.cart-item');
                const quantityEl = parent.querySelector('.cart-item-quantity');
                let quantity = parseInt(quantityEl.textContent);
                if(quantity > 1) {
                    quantity -= 1;
                    quantityEl.textContent = quantity;
                    updateQuantity(parent.dataset.id, quantity);
                }
            });
        });

        cartItemsContainer.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', function() {
                const parent = this.closest('.cart-item');
                removeItem(parent.dataset.id);
            });
        });
        document.querySelector('.cart-count').textContent = cart.items.length;
    }
        // Cập nhật số lượng qua AJAX
        function updateQuantity(itemId, quantity) {
            fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ item_id: itemId, quantity: quantity })
            })
            .then(res => res.json())
            .then(cart => updateCartUI(cart));
        }

        // Xóa món
        function removeItem(itemId) {
        fetch('/cart/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ item_id: itemId })
        })
        .then(res => res.json())
        .then(cart => {
            updateCartUI(cart);
            showCartMessage('Đã xóa món khỏi giỏ hàng!', 'success');
        });
    }

    function showCartMessage(message, type = 'success') {
    // Tạo div thông báo
    const msg = document.createElement('div');
    msg.className = `cart-message ${type}`; // type: success / error
    msg.textContent = message;

    document.body.appendChild(msg);

    // Hiển thị trong 2 giây rồi ẩn
    setTimeout(() => {
        msg.classList.add('hide');
        setTimeout(() => msg.remove(), 500);
    }, 2000);
}


    // Load giỏ khi mở trang
    fetch('/cart')
    .then(res => res.json())
    .then(cart => updateCartUI(cart));
});
</script>

    <script src="{{ asset('js/home.js') }}"></script>
    @stack('scripts')
</body>
</html>
