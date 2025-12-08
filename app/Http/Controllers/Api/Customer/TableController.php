<?php
namespace App\Http\Controllers\Api\Customer;

use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TableController extends Controller
{
    // Lấy danh sách bàn
    public function index() {
        $tables = Table::all();
        return response()->json($tables);
    }

    // Đặt bàn (thêm vào session)
    public function reserve(Request $request) {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'guests' => 'required|integer|min:1',
            'reservation_time' => 'required|date|after:now'
        ]);

        $reservationData = [
            'table_id' => $request->table_id,
            'guests' => $request->guests,
            'reservation_time' => $request->reservation_time
        ];

        $reservations = session()->get('reservations', []);
        $reservations[] = $reservationData;
        session()->put('reservations', $reservations);

        return response()->json(['message' => 'Đặt bàn thành công', 'reservations' => $reservations]);
    }

    // Hủy đặt bàn (theo index)
    public function cancel(Request $request, $index) {
        $reservations = session()->get('reservations', []);
        if(isset($reservations[$index])) {
            unset($reservations[$index]);
            session()->put('reservations', array_values($reservations));
        }
        return response()->json(['message' => 'Hủy đặt bàn thành công', 'reservations' => $reservations]);
    }

    // Xem danh sách đặt bàn hiện tại
    public function current() {
        $reservations = session()->get('reservations', []);
        return response()->json($reservations);
    }
}
