<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatus;
use App\Mail\OrderStatusMail;
use App\Models\SgoOrder;
use App\Models\SgoOrderDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $page = 'Đơn hàng';
        $title = 'Danh sách dơn hàng';
        if ($request->ajax()) {
            return datatables()->of(SgoOrder::select(['code', 'id', 'fullname', 'email', 'payment_method', 'phone', 'total_price', 'status', 'created_at', 'payment_status'])->get())
                ->addColumn('total_price', function ($row) {
                    return number_format($row->total_price, 0, ',', '.') . ' VND';
                })
                ->addColumn('email', function ($row) {
                    return "
                    <p>$row->fullname</p>
                    <p>$row->email</p>
                    <p>$row->phone</p>
                    ";
                })
                ->addColumn('id', function ($row) {
                    return '<a href="' . route('admin.order.detail', $row->id) . '">' . $row->id . '</a>';
                })
                ->addColumn('payment_method', function ($row) {
                    if ($row->payment_method == 'cod') {
                        return 'Thanh toán khi nhận hàng (COD)';
                    } elseif ($row->payment_method == 'bacs') {
                        return 'Thanh toán chuyển khoản';
                    } else {
                        return 'Thanh toán đặt cọc';
                    };
                })
                ->addColumn('status', function ($row) {
                    return statusColor($row->status);
                })
                ->addColumn('payment_status', function ($row) {
                    return paymentStatus($row->payment_status);
                })
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d/m/Y');
                })
                ->rawColumns(['id', 'email', 'payment_method', 'status', 'payment_status'])
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
        $orderItems = SgoOrder::with('products')->where('id', $id)->firstOrFail();

        // Trả về thông tin chi tiết sản phẩm dưới dạng JSON
        return view('backend.order.detail', compact('orderItems', 'page', 'title'));
    }

    public function updateOrderStatus(Request $request)
    {
        try {
            $order = SgoOrder::findOrFail($request->id);

            $orderDetails = SgoOrderDetail::where('order_id', $order->id)->first();

            $order->status = $request->input('order_status');

            Mail::to($order->email)->send(new OrderStatus($order, $orderDetails));

            $order->save();

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error("Failed to change this order's status: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Cập nhật trạng thái đơn hàng thất bại', 'error' => $e->getMessage()]);
        }
    }

    public function exportPDF(Request $request)
    {
        $orderId = $request->input('order_id');

        $order = SgoOrder::with('products')->find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $pdf = Pdf::loadView('invoices.template', compact('order'));

        return $pdf->download('hoa-don-' . $orderId . '.pdf');
    }

    public function changeOrderStatus(Request $request)
    {
        $order = SgoOrder::query()->findOrFail($request->orderId);

        $status = changeStatus($order->status);

        if ($status == 'completed') {
            if ($order->payment_status != 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Vui lòng xác nhận thanh toán trước khi toàn tất đơn hàng!'
                ], 400);
            }
        }

        $order->status = $status;

        $order->save();

        if ($order->status == 'confirmed') Mail::to($order->email)->send(new OrderStatusMail($order));

        return response()->json([
            'status' => true,
            'value' => $order->status
        ]);
    }

    public function cancelOrder(Request $request, string $id)
    {
        $request->validate(
            [
                'reason' => 'required|min:5|max:100'
            ]
        );

        $order = SgoOrder::query()->findOrFail($id);

        if ($order->status == 'completed') {
            return response()->json([
                'status' => false,
                'message' => 'Không thể hủy khi đơn hàng đã hoàn thành.'
            ]);
        }

        $order->status = 'cancelled';
        $order->reason = $request->reason;

        $order->save();

        Mail::to($order->email)->send(new OrderStatusMail($order));

        return response()->json([
            'status' => true,
            'message' => 'Đơn hàng đã hủy thành công.',
            'reason' => $order->reason
        ]);
    }

    public function confirmPayment(string $id)
    {
        $order = SgoOrder::query()->findOrFail($id);

        if ($order->payment_method == 'currency' && $order->deposit_amount < $order->total_price) {
            return response()->json([
                'status' => false,
                'message' => 'Số tiền còn thiếu. Vui lòng kiểm tra lại.'
            ], 400);
        }

        if ($order->status == 'pending') {
            return response()->json([
                'status' => false,
                'message' => 'Đơn hàng chưa được xác nhận.'
            ], 400);
        }

        $order->payment_status = 1;
        $order->save();

        return response()->json([
            'status' => true,
            'message' => 'Xác nhận thanh toán thành công.'
        ]);
    }
}
