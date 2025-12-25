// Menu items data


// Cart functionality
let cart = JSON.parse(localStorage.getItem("cart")) || [];

// DOM Elements
const loader = document.querySelector(".loader");
const promotionBanner = document.getElementById("promotionBanner");
const closePromotion = document.getElementById("closePromotion");
const header = document.querySelector(".header");
const navLinks = document.querySelectorAll(".nav-link");
const mobileMenuToggle = document.getElementById("mobileMenuToggle");
const nav = document.querySelector(".nav");
const searchToggle = document.getElementById("searchToggle");
const searchBox = document.getElementById("searchBox");
const userToggle = document.getElementById("userToggle");
const userDropdown = document.getElementById("userDropdown");
// const cartToggle = document.getElementById("cartToggle");
// const cartSidebar = document.getElementById("cartSidebar");
const cartOverlay = document.getElementById("cartOverlay");
// const closeCart = document.getElementById("closeCart");
// const cartItemsContainer = document.getElementById("cartItems");
// const cartCount = document.querySelector(".cart-count");
const cartSubtotal = document.querySelector(".cart-subtotal");
const cartShipping = document.querySelector(".cart-shipping");
const cartTotal = document.querySelector(".cart-total");
const applyCoupon = document.getElementById("applyCoupon");
const couponInput = document.getElementById("couponInput");
const checkoutBtn = document.getElementById("checkoutBtn");
const menuItemsContainer = document.getElementById("menuItems");
const quickViewModal = document.getElementById("quickViewModal");
const quickViewOverlay = document.getElementById("quickViewOverlay");
const quickViewContent = document.getElementById("quickViewContent");
const orderOnlineModal = document.getElementById("orderOnlineModal");
const modalOverlay = document.getElementById("modalOverlay");
const closeModalButtons = document.querySelectorAll(".close-modal");
const contactForm = document.getElementById("contactForm");
const backToTop = document.getElementById("backToTop");
const toast = document.getElementById("toast");
const dealTimer = document.getElementById("dealTimer");
const daysElement = document.getElementById("days");
const hoursElement = document.getElementById("hours");
const minutesElement = document.getElementById("minutes");
const secondsElement = document.getElementById("seconds");

// Variables

let currentQuickViewItem = null;

// Initialize the page
document.addEventListener("DOMContentLoaded", function () {
  // Hide loader after page load
  setTimeout(() => {
    loader.classList.add("loaded");
  }, 1000);

  // Initialize components
  initHeader();
  initCart();
  initMenu();
  initDealTimer();
  initEventListeners();

  // Render initial menu items
  renderMenuItems();
  updateCartCount();
  renderCartItems();
});

// Initialize header
function initHeader() {
  // Header scroll effect
  window.addEventListener("scroll", function () {
    if (window.scrollY > 100) {
      header.classList.add("scrolled");
    } else {
      header.classList.remove("scrolled");
    }

    // Back to top button
    if (window.scrollY > 500) {
      backToTop.classList.add("visible");
    } else {
      backToTop.classList.remove("visible");
    }
  });

  // Navigation active state
  navLinks.forEach((link) => {
    link.addEventListener("click", function () {
      navLinks.forEach((l) => l.classList.remove("active"));
      this.classList.add("active");

      // Close mobile menu if open
      if (window.innerWidth <= 768) {
        nav.classList.remove("active");
      }
    });
  });

  // Mobile menu toggle
  mobileMenuToggle.addEventListener("click", function () {
    nav.classList.toggle("active");
  });

  // Search toggle
  searchToggle.addEventListener("click", function () {
    searchBox.classList.toggle("active");
    if (searchBox.classList.contains("active")) {
      searchInput.focus();
    }
  });

  // Close search when clicking outside
  document.addEventListener("click", function (event) {
    if (
      !searchBox.contains(event.target) &&
      !searchToggle.contains(event.target)
    ) {
      searchBox.classList.remove("active");
    }
  });

  // User dropdown toggle
  userToggle.addEventListener("click", function () {
    userDropdown.classList.toggle("active");
  });

  // Close user dropdown when clicking outside
  document.addEventListener("click", function (event) {
    if (
      !userDropdown.contains(event.target) &&
      !userToggle.contains(event.target)
    ) {
      userDropdown.classList.remove("active");
    }
  });
}

// Initialize cart
function initCart() {
  // Cart toggle
  cartToggle.addEventListener("click", toggleCart);
  closeCart.addEventListener("click", toggleCart);
  cartOverlay.addEventListener("click", toggleCart);

  // Apply coupon
//   applyCoupon.addEventListener("click", function () {
//     const couponCode = couponInput.value.trim();
//     if (couponCode === "WELCOME20") {
//       showToast("Áp dụng mã giảm giá 20% thành công!", "success");
//       couponInput.value = "";
//       updateCartSummary();
//     } else if (couponCode === "FREESHIP") {
//       showToast("Miễn phí vận chuyển đã được áp dụng!", "success");
//       couponInput.value = "";
//       updateCartSummary();
//     } else if (couponCode) {
//       showToast("Mã giảm giá không hợp lệ!", "error");
//     }
//   });

  // Checkout button
//   checkoutBtn.addEventListener("click", function () {
//     if (cart.length === 0) {
//       showToast("Giỏ hàng của bạn đang trống!", "error");
//       return;
//     }

//     const total = calculateTotal();
//     showToast(
//       `Chuyển hướng đến trang thanh toán. Tổng tiền: ${total.toLocaleString()} đ`,
//       "success"
//     );

//     // In a real application, you would redirect to checkout page
//     // window.location.href = '/checkout.html';
//   });
}

// Initialize menu
function initMenu() {
  // Category filter buttons
  categoryButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const category = this.getAttribute("data-category");

      // Update active button
      categoryButtons.forEach((btn) => btn.classList.remove("active"));
      this.classList.add("active");

      // Update current category and render items
      currentCategory = category;
      displayedItems = 6;
      renderMenuItems();
    });
  });

  // Sort select
  sortSelect.addEventListener("change", function () {
    currentSort = this.value;
    renderMenuItems();
  });

  // Load more button
  loadMoreBtn.addEventListener("click", function () {
    displayedItems += 6;
    renderMenuItems();

    // Hide button if all items are displayed
    const filteredItems = getFilteredItems();
    if (displayedItems >= filteredItems.length) {
      loadMoreBtn.style.display = "none";
    }
  });

  // Search input
  searchInput.addEventListener("input", function () {
    renderMenuItems();
  });
}

// Initialize deal timer
function initDealTimer() {
  // Set end date (24 hours from now)
  const endDate = new Date();
  endDate.setDate(endDate.getDate() + 1);

  function updateTimer() {
    const now = new Date().getTime();
    const distance = endDate - now;

    if (distance < 0) {
      clearInterval(timerInterval);
      dealTimer.innerHTML = '<div class="expired">Ưu đãi đã kết thúc</div>';
      return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor(
      (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    );
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    daysElement.textContent = days.toString().padStart(2, "0");
    hoursElement.textContent = hours.toString().padStart(2, "0");
    minutesElement.textContent = minutes.toString().padStart(2, "0");
    secondsElement.textContent = seconds.toString().padStart(2, "0");
  }

  updateTimer();
  const timerInterval = setInterval(updateTimer, 1000);
}

// Initialize event listeners
function initEventListeners() {
  // Close promotion banner
  closePromotion.addEventListener("click", function () {
    promotionBanner.style.display = "none";
  });

  // Back to top button
  backToTop.addEventListener("click", function () {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });

  // Close modals
  closeModalButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const modal = this.closest(".modal");
      const overlay =
        document.getElementById(modal.id + "Overlay") || modalOverlay;

      modal.classList.remove("active");
      overlay.classList.remove("active");
    });
  });

  // Close modals when clicking overlay
  document.querySelectorAll(".modal-overlay").forEach((overlay) => {
    overlay.addEventListener("click", function () {
      const modalId = this.id.replace("Overlay", "");
      const modal = document.getElementById(modalId);

      if (modal) {
        modal.classList.remove("active");
        this.classList.remove("active");
      }
    });
  });

  // Contact form submission
  if (contactForm) {
    contactForm.addEventListener("submit", function (e) {
      e.preventDefault();

      // Get form values
      const name = document.getElementById("name").value;
      const phone = document.getElementById("phone").value;
      const email = document.getElementById("email").value;
      const subject = document.getElementById("subject").value;
      const message = document.getElementById("message").value;

      // In a real application, you would send this data to a server
      console.log("Contact form submitted:", {
        name,
        phone,
        email,
        subject,
        message,
      });

      // Show success message
      showToast(
        "Tin nhắn của bạn đã được gửi thành công! Chúng tôi sẽ liên hệ với bạn sớm nhất.",
        "success"
      );

      // Reset form
      this.reset();
    });
  }

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      const href = this.getAttribute("href");

      if (href === "#") return;

      e.preventDefault();
      const target = document.querySelector(href);

      if (target) {
        window.scrollTo({
          top: target.offsetTop - 100,
          behavior: "smooth",
        });
      }
    });
  });
}

// Get filtered items based on current category, search and sort
// Get filtered items based on current category, search and sort


// Render menu items

// Get category name in Vietnamese
function getCategoryName(category) {
  switch (category) {
    case "vietnamese":
      return "Món Việt";
    case "asian":
      return "Món Á";
    case "fastfood":
      return "Fast Food";
    case "drinks":
      return "Đồ uống";
    case "dessert":
      return "Tráng miệng";
    default:
      return "";
  }
}

// Add item to cart


// Calculate subtotal
function calculateSubtotal() {
  return cart.reduce((total, item) => total + item.price * item.quantity, 0);
}

// Calculate shipping
function calculateShipping(subtotal) {
  // Free shipping for orders over 200,000 VND
  if (subtotal >= 200000) {
    return 0;
  }

  // Standard shipping fee
  return 15000;
}

// Calculate total
function calculateTotal() {
  const subtotal = calculateSubtotal();
  const shipping = calculateShipping(subtotal);
  return subtotal + shipping;
}

// Update cart count
function updateCartCount() {
  const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
  cartCount.textContent = totalItems;
}

// Toggle cart sidebar
function toggleCart() {
  cartSidebar.classList.toggle("active");
  cartOverlay.classList.toggle("active");

  // Render cart items when opening
  if (cartSidebar.classList.contains("active")) {
    renderCartItems();
  }
}

// Show quick view modal
function showQuickView(itemId) {
  const item = menuItems.find((item) => item.id === itemId);

  if (!item) return;

  currentQuickViewItem = item;

  quickViewContent.innerHTML = `
        <div class="quick-view-content">
            <div class="quick-view-image">
                <img src="${item.image}" alt="${item.name}">
            </div>
            <div class="quick-view-info">
                <h3>${item.name}</h3>
                <div class="quick-view-price">${item.price.toLocaleString()} đ</div>
                <p class="quick-view-description">${item.description}</p>

                <div class="quick-view-actions">
                    <div class="quick-view-quantity">
                        <button class="quick-view-quantity-btn" id="qvDecrease">-</button>
                        <span class="quick-view-quantity-value" id="qvQuantity">1</span>
                        <button class="quick-view-quantity-btn" id="qvIncrease">+</button>
                    </div>
                    <button class="btn btn-primary" id="qvAddToCart">
                        <i class="fas fa-cart-plus"></i>
                        <span>Thêm vào giỏ</span>
                    </button>
                </div>

                <div class="quick-view-details">
                    <h4>Thông tin chi tiết</h4>
                    <div class="details-list">
                        <div class="detail-item">
                            <span>Danh mục:</span>
                            <span>${getCategoryName(item.category)}</span>
                        </div>
                        <div class="detail-item">
                            <span>Calories:</span>
                            <span>${item.details.calories}</span>
                        </div>
                        <div class="detail-item">
                            <span>Thời gian chuẩn bị:</span>
                            <span>${item.details.prepTime}</span>
                        </div>
                        <div class="detail-item">
                            <span>Độ cay:</span>
                            <span>${item.details.spicyLevel}</span>
                        </div>
                        <div class="detail-item">
                            <span>Thành phần chính:</span>
                            <span>${item.details.ingredients}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

  // Show modal
  quickViewModal.classList.add("active");
  quickViewOverlay.classList.add("active");

  // Add event listeners for quick view
  let qvQuantity = 1;
  const qvQuantityElement = document.getElementById("qvQuantity");
  const qvIncrease = document.getElementById("qvIncrease");
  const qvDecrease = document.getElementById("qvDecrease");
  const qvAddToCart = document.getElementById("qvAddToCart");

  qvIncrease.addEventListener("click", () => {
    qvQuantity++;
    qvQuantityElement.textContent = qvQuantity;
  });

  qvDecrease.addEventListener("click", () => {
    if (qvQuantity > 1) {
      qvQuantity--;
      qvQuantityElement.textContent = qvQuantity;
    }
  });

  qvAddToCart.addEventListener("click", () => {
    addToCart(item.id, qvQuantity);
    quickViewModal.classList.remove("active");
    quickViewOverlay.classList.remove("active");
  });
}

// Show toast notification
function showToast(message, type = "info") {
  // Set toast content and style
  toast.textContent = message;

  // Reset classes
  toast.className = "toast";

  // Add type class
  if (type === "success") {
    toast.classList.add("success");
    toast.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
  } else if (type === "error") {
    toast.classList.add("error");
    toast.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
  } else if (type === "warning") {
    toast.classList.add("warning");
    toast.innerHTML = `<i class="fas fa-exclamation-triangle"></i> ${message}`;
  } else {
    toast.innerHTML = `<i class="fas fa-info-circle"></i> ${message}`;
  }

  // Show toast
  toast.classList.add("show");

  // Hide toast after 3 seconds
  setTimeout(() => {
    toast.classList.remove("show");
  }, 3000);
}

// Initialize animations on scroll
function initAnimations() {
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate__animated", "animate__fadeInUp");
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  // Observe elements to animate
  document
    .querySelectorAll(
      ".feature-card, .menu-item, .testimonial-card, .order-method"
    )
    .forEach((el) => {
      observer.observe(el);
    });
}

// Initialize animations when page loads
window.addEventListener("load", initAnimations);
function sortMenuItems() {
    const itemsContainer = document.querySelector(".menu-items");
    const items = Array.from(itemsContainer.querySelectorAll(".menu-item"));

    let sortedItems = items;

    if (currentSort === "price-asc") {
        sortedItems = items.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
    } else if (currentSort === "price-desc") {
        sortedItems = items.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
    } else if (currentSort === "name") {
        sortedItems = items.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name));
    }else if (currentSort === "popular") {
    sortedItems = items.sort((a, b) => parseInt(b.dataset.popular) - parseInt(a.dataset.popular));
    }


    // Xóa items cũ và append items đã sort
    itemsContainer.innerHTML = "";
    sortedItems.forEach(item => itemsContainer.appendChild(item));
}
document.getElementById("sortSelect").addEventListener("change", function() {
    currentSort = this.value;
    sortMenuItems();
});
