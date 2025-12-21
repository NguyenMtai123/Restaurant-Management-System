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

    function renderMenuItems() {
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

        // đảm bảo tất cả item gốc ở trong container (nếu bị di chuyển)
        menuItems.forEach(it => {
            if (it.element.parentNode !== menuItemsContainer) {
                menuItemsContainer.appendChild(it.element);
            }
            it.element.style.display = 'none'; // ẩn hết trước
        });

        // nếu không có sản phẩm thỏa điều kiện -> hiển thị thông báo và ẩn nút load more
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
            return;
        }

        // hiện những phần tử cần hiển thị (giữ element gốc để maintain event listeners)
        itemsToShow.forEach(item => {
            // nếu element không còn trong container thì append lại
            if (item.element.parentNode !== menuItemsContainer) {
                menuItemsContainer.appendChild(item.element);
            }
            item.element.style.display = 'block';
        });

        // ẩn/hiện nút load more
        loadMoreBtn.style.display = displayedItems >= filtered.length ? 'none' : 'inline-flex';
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

    // Search
    searchInput.addEventListener('input', function() {
        displayedItems = 6;
        renderMenuItems();
    });

    // Load more
    loadMoreBtn.addEventListener('click', function() {
        displayedItems += 6;
        renderMenuItems();
    });

    // Ban đầu render
    renderMenuItems();
});

</script>
