<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function cart()
    {
        $cartItems = session('cart', []);

        return view('cart', ['cartItems' => $cartItems]);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request, $productId)
    {
        $product = Product::find($productId);

        if ($product) {
            $cartItems = session('cart', []);

            $existingItem = collect($cartItems)->where('product_id', $product->id)->first();

            if ($existingItem) {
                $existingItem['quantity']++;
            } else {
                $cartItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'product_image' => $product->image_path,
                    'quantity' => 1,
                ];
            }

            session(['cart' => $cartItems]);

            return response()->json(['message' => 'Product added to cart successfully', 'cartItems' => $cartItems]);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart(Request $request, $productId)
    {
        $cartItems = session('cart', []);

        $cartItems = array_filter($cartItems, function ($item) use ($productId) {
            return $item['product_id'] != $productId;
        });

        session(['cart' => $cartItems]);

        return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully.');
    }

    // Các hàm khác nếu cần
}