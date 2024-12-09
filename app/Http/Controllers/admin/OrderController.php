<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SgoOrder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $page = 'Đơn hàng';
        $title = 'Danh sách dơn hàng';
        if ($request->ajax()) {
            return datatables()->of(SgoOrder::select(['id', 'first_name', 'last_name', 'address', 'city', 'country', 'phone', 'total_price', 'status'])->get())
                ->addColumn('total_price', function ($row) {
                    return number_format($row->total_price, 0, ',', '.') . ' VND';
                })
                ->addColumn('name', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('full_address', function ($row) {
                    return $row->address . ', ' . $row->city . ', ' . $row->country;
                })
                ->addColumn('status', function ($row) {
                    $statusMap = [
                        'pending' => 'Đang chờ',
                        'completed' => 'Đã hoàn thành',
                        'cancelled' => 'Đã hủy',
                    ];
                    return $statusMap[$row->status] ?? 'Không xác định';
                })
                ->addColumn('action', function ($row) {
                    return '
                    <div class="btn-group">
                        <a class="btn btn-warning btn-sm order-detail-btn" href="' . route('admin.order.detail', $row->id) . '">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-danger btn-sm delete-order-btn" data-url="' . route('admin.product.delete', $row->id) . '">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                ';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('backend.order.index', compact('page', 'title'));
    }

    public function detail($id)
    {
        $page = 'Đơn hàng';
        $title = 'Thông tin đơn hàng';
        // Lấy đơn hàng từ bảng sgo_orders
        $order = SgoOrder::findOrFail($id);

        // Lấy chi tiết sản phẩm của đơn hàng
        $orderDetails = $order->orderDetails()->select('product_name', 'price', 'quantity')->get();

        // Trả về thông tin chi tiết sản phẩm dưới dạng JSON
        return view('backend.order.detail', compact('order', 'page', 'title'));
    }

    public function updateOrderStatus(Request $request)
    {
        try {
            $order = SgoOrder::findOrFail($request->id);
            $order->status = $request->input('order_status');
            $order->save();

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error("Failed to change this order's status" . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Cập nhật trạng thái đơn hàng thất bại', 'error' => $e->getMessage()]);
        }
    }
}
