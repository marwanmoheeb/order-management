<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\Payment\MockPaymentGateway;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string'
        ]);

        $user = $request->user();

        $order = Order::create([
            'user_id' => $user->id,
            'total' => 0,
        ]);

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $order->orderItems()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
        }
        $order->total = $order->orderItems->sum(fn ($oi) => $oi->quantity * $oi->price);
        $order->save();

        $paymentService = new PaymentService(new MockPaymentGateway());
        $paymentResult = $paymentService->initializePayment($order, $request->payment_method);

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order,
        ]);
    }

    public function index(Request $request)
    {
        $request->validate([
            'status' => 'sometimes|string|in:' . implode(',', Order::$statuses),
        ]);

        $query = Order::where('user_id', $request->user()->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->get();

        return response()->json([
            'orders' => $orders,
        ]);
    }

    public function confirm(Order $order)
    {
        $order = Order::find($order->id);

        $order->status = Order::STATUS_CONFIRMED;
        $order->save();

        $paymentService = new PaymentService(new MockPaymentGateway());
        $paymentResult = $paymentService->process($order);
        return response()->json([
            'message' => 'Order confirmed successfully',
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
        
        $order->orderItems()->delete();

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $order->orderItems()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
        }
        $order->total = $order->orderItems->sum(fn ($oi) => $oi->quantity * $oi->price);
        $order->save();
    }

    public function destroy(Order $order)
    {
        if ($order->payments()->exists()) {
            return response()->json([
                'message' => 'Order has payments, cannot be deleted',
            ], 400);
        }
        
        $order->orderItems()->delete();
        $order->delete();
        return response()->json([
            'message' => 'Order deleted successfully',
        ]);
    }   
}


