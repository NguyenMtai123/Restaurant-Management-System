
<div class="search-container">
    <button class="search-btn" id="searchToggle">
        <i class="fas fa-search"></i>
    </button>
    <div class="search-box" id="searchBox">
        <input type="text" placeholder="Tìm kiếm món ăn..." id="searchInput" />
        <button class="search-submit"><i class="fas fa-search"></i></button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.querySelector('.search-submit');
    const categoryButtons = document.querySelectorAll('.category-btn');
    const sortSelect = document.getElementById('sortSelect');
    const loadMoreBtn = document.getElementById('loadMore');
    const menuItemsContainer = document.querySelector('.menu-items');

    let currentCategory = 'all';
    let currentSort = 'default';
    let displayedItems = 6;

    // Lấy menu items từ DOM
    const menuItems = Array.from(document.querySelectorAll('.menu-item')).map(item => ({
        element: item,
        name: item.dataset.name?.toLowerCase() || '',
        description: item.querySelector('p')?.innerText.toLowerCase() || '',
        category: item.dataset.category,
        price: parseFloat(item.dataset.price),
        popular: parseInt(item.dataset.popular)
    }));

    function renderMenuItems(scroll = false) {
        const searchTerm = searchInput.value.toLowerCase().trim();

        // lọc theo category + search
        let filtered = menuItems.filter(item => {
            const matchCategory = currentCategory === 'all' || item.category === currentCategory;
            const matchSearch = !searchTerm || item.name.includes(searchTerm) || item.description.includes(searchTerm);
            return matchCategory && matchSearch;
        });

        // sắp xếp
        if (currentSort === 'price-asc') filtered.sort((a,b) => a.price - b.price);
        else if (currentSort === 'price-desc') filtered.sort((a,b) => b.price - a.price);
        else if (currentSort === 'name') filtered.sort((a,b) => a.name.localeCompare(b.name));
        else if (currentSort === 'popular') filtered.sort((a,b) => b.popular - a.popular);

        // số item cần hiển thị
        const itemsToShow = filtered.slice(0, displayedItems);

        // xóa thông báo cũ nếu có
        const oldMsg = menuItemsContainer.querySelector('.no-results');
        if (oldMsg) oldMsg.remove();

        // ẩn hết trước
        menuItems.forEach(it => {
            if (it.element.parentNode !== menuItemsContainer) {
                menuItemsContainer.appendChild(it.element);
            }
            it.element.style.display = 'none';
        });

        // nếu không có sản phẩm thỏa điều kiện
        if (filtered.length === 0) {
            const noDiv = document.createElement('div');
            noDiv.className = 'no-results';
            noDiv.innerHTML = `
                <i class="fas fa-search"></i>
                <h3>Không tìm thấy món ăn phù hợp</h3>
                <p>Hãy thử từ khóa khác hoặc chọn danh mục khác</p>
            `;
            menuItemsContainer.appendChild(noDiv);
            loadMoreBtn.style.display = 'none';
        } else {
            // hiển thị những phần tử cần show
            itemsToShow.forEach(item => {
                if (item.element.parentNode !== menuItemsContainer) {
                    menuItemsContainer.appendChild(item.element);
                }
                item.element.style.display = 'block';
            });

            // ẩn/hiện nút load more
            loadMoreBtn.style.display = displayedItems >= filtered.length ? 'none' : 'inline-flex';
        }

        // scroll xuống thực đơn nếu cần
        if(scroll && filtered.length > 0) {
            const menuSection = document.querySelector('#menu') || menuItemsContainer;
            window.scrollTo({
                top: menuSection.offsetTop - 100, // trừ header nếu cần
                behavior: 'smooth'
            });
        }
    }

    // Category filter
    categoryButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            categoryButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentCategory = this.dataset.category;
            displayedItems = 6;
            renderMenuItems();
        });
    });

    // Sort
    sortSelect.addEventListener('change', function() {
        currentSort = this.value;
        renderMenuItems();
    });

    // Search input: live search
    searchInput.addEventListener('input', function() {
        displayedItems = 6;
        renderMenuItems(true);
    });

    // Search submit button
    searchBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const searchTerm = searchInput.value.trim();
        if(!searchTerm) return;

        // Nếu đang ở trang khác Home, redirect về Home
        if(window.location.pathname !== '/customer/home') {
            window.location.href = `/customer/home?search=${encodeURIComponent(searchTerm)}#menu`;
        } else {
            displayedItems = 6;
            renderMenuItems(true);
        }
    });

    // Load more
    loadMoreBtn.addEventListener('click', function() {
        displayedItems += 6;
        renderMenuItems();
    });

    // Kiểm tra từ khóa search từ URL
    const urlParams = new URLSearchParams(window.location.search);
    const searchTerm = urlParams.get('search');
    if(searchTerm) {
        searchInput.value = searchTerm;
        renderMenuItems(true);
    } else {
        renderMenuItems();
    }
});
</script>
