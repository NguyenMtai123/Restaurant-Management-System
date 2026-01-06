<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
     // Hiển thị danh sách hóa đơn
    public function index(Request $request)
    {
        $query = Order::with('user', 'orderItems.menuItem');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('order_number', 'like', "%{$keyword}%")
                ->orWhereHas('user', function ($uq) use ($keyword) {
                    $uq->where('name', 'like', "%{$keyword}%");
                });
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }


    // Xem chi tiết hóa đơn
    public function show(Order $order)
    {
        $order->load('user', 'orderItems.menuItem');

        return response()->json([
            'order_number' => $order->order_number,
            'customer' => [
                'name'    => $order->user?->name ?? 'Khách vãng lai',
                'phone'   => $order->user?->phone ?? '',
                'address' => $order->user?->address ?? '',
            ],
            'status' => $order->status,
            'status_text' => match ($order->status) {
                'pending'   => 'Chờ xử lý',
                'delivered' => 'Đang giao',
                'completed' => 'Hoàn thành',
                'cancelled' => 'Đã hủy',
                default     => 'Không rõ'
            },
            'status_color' => match ($order->status) {
                'pending'   => 'warning',
                'delivered' => 'info',
                'completed' => 'success',
                'cancelled' => 'danger',
                default     => 'secondary'
            },
            'created_at' => $order->created_at->format('H:i - d/m/Y'),
            'note' => $order->note ?? 'Không có ghi chú.',
            'total' => number_format($order->total_amount) . ' ₫',
            'items' => $order->orderItems->map(fn ($item) => [
                'name'     => $item->menuItem->name ?? '—',
                'qty'      => $item->quantity,
                'price'    => number_format($item->unit_price) . ' ₫',
                'subtotal' => number_format($item->quantity * $item->unit_price) . ' ₫',
            ])
        ]);
    }


    // Cập nhật trạng thái hóa đơn
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,delivered,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    // Hủy hóa đơn
    public function cancel(Order $order)
    {
        $order->update(['status' => 'cancelled']);
        return redirect()->back()->with('success', 'Hóa đơn đã được hủy!');
    }
    public function exportPdf(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('keyword')) {
            $query->where('order_number', 'like', "%{$request->keyword}%");
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->latest()->get();
        $pdf = Pdf::loadView('admin.orders.pdf', compact('orders'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('bao-cao-don-hang.pdf');
    }
}
