<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('products.index');
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + $item['price'] * $item['quantity'];
        }, 0);

        return view('cart.index', compact('cart', 'total'));
    }

    public function placeOrder()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.index');
        }

        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + $item['price'] * $item['quantity'];
        }, 0);

        $order = Order::create(['total_price' => $total]);

        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('products.index')->with('success', 'Заказ успешно оформлен!');
    }

    public function viewOrders()
    {
        $orders = Order::with('items.product')->get();
        $totalPrice = $orders->sum('total_price');

        return view('orders.index', compact('orders', 'totalPrice'));
    }

    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Заказ удален!');
    }
}

