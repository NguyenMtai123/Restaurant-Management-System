
<div class="container">
    <h2 class="mb-4">Đặt bàn</h2>

    <!-- Danh sách bàn -->
    <div class="row" id="table-list">
        <!-- Bàn sẽ load bằng JS -->
    </div>

    <hr>

    <h3>Đặt bàn hiện tại</h3>
    <ul id="current-reservations">
        <!-- Danh sách đặt bàn hiện tại sẽ load bằng JS -->
    </ul>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Load danh sách bàn từ API
    function loadTables() {
        fetch('/api/customer/tables')
            .then(res => res.json())
            .then(tables => {
                const container = document.getElementById('table-list');
                container.innerHTML = '';
                tables.forEach(table => {
                    container.innerHTML += `
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">${table.name} (${table.capacity} khách)</h5>
                                    <p>Trạng thái: ${table.status}</p>
                                    <input type="number" min="1" max="${table.capacity}" value="1" id="guests-${table.id}" class="form-control mb-2">
                                    <input type="datetime-local" id="time-${table.id}" class="form-control mb-2">
                                    <button class="btn btn-primary" onclick="reserveTable(${table.id})">Đặt bàn</button>
                                </div>
                            </div>
                        </div>
                    `;
                });
            });
    }

    // Load danh sách đặt bàn hiện tại
    function loadReservations() {
        fetch('/api/customer/reservations')
            .then(res => res.json())
            .then(reservations => {
                const list = document.getElementById('current-reservations');
                list.innerHTML = '';
                reservations.forEach((res, index) => {
                    list.innerHTML += `
                        <li>
                            Bàn: ${res.table_id}, Số khách: ${res.guests}, Thời gian: ${res.reservation_time}
                            <button class="btn btn-sm btn-danger" onclick="cancelReservation(${index})">Hủy</button>
                        </li>
                    `;
                });
            });
    }

    // Đặt bàn
    window.reserveTable = function(tableId) {
        const guests = document.getElementById('guests-' + tableId).value;
        const time = document.getElementById('time-' + tableId).value;

        fetch('/api/customer/reserve', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ table_id: tableId, guests: guests, reservation_time: time })
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            loadReservations();
        });
    }

    // Hủy bàn
    window.cancelReservation = function(index) {
        fetch('/api/customer/reservations/' + index, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            loadReservations();
        });
    }

    // Initial load
    loadTables();
    loadReservations();
});
</script>
@endsection
