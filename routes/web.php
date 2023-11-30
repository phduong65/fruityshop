<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommentPostController;
use App\Http\Controllers\CommentProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryPostController;
use App\Http\Controllers\ProfileController;
use App\Models\CategoryPost;
use App\Models\Product;
use App\Models\CommentPost;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\SettingController;
use App\Models\Order;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewedProductController;
use App\Http\Controllers\WishlistController;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;


use function Laravel\Prompts\search;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Trang thanh toán
// Route::get('/checkout',[OrderController::class,'index'])->name('orders.index');
// trang index
Route::get('/', [ProductController::class, 'getProductHome'])->name('home');
// filter-home
Route::get('/fillter', [ProductController::class, 'getNewProducts'])->name('fillter');
// search-home

Route::get('/search', [ProductController::class, 'search'])->name('search');
// best-seller
Route::get('/products_new', [ProductController::class, 'getNewProducts'])->name('products_new');
// Lưu đơn hàng
Route::resource('orders', OrderController::class);
Route::resource('ordersitems', OrderItemController::class);
Route::get('/success', [OrderController::class, 'store'])->name('orders.store');
Route::get('/manager_orders', [OrderController::class, 'managerOrders'])->name('managerOrders');
//managerDonHang
Route::post('orders/update', [OrderController::class,'changeStatus'])->name('orders.changeStatus');
Route::post('/voucher_code', [OrderController::class,'applyVoucher'])->name('orders.applyVoucher');
Route::delete('/manager_orders/{orderCode}', [OrderController::class,'deleteOrder'])->name('orders.delete');
Route::post('orders/update', [OrderController::class, 'changeStatus'])->name('orders.changeStatus');
Route::delete('/manager_orders/{orderCode}', [OrderController::class, 'deleteOrder'])->name('orders.delete');
// manage
Route::post('/viewed-products/{id}', [ViewedProductController::class, 'destroy'])->name('viewedproducts.destroy');
Route::post('orders/view', [OrderItemController::class, 'view'])->name('orders.view');
// trí
Route::get('/post', [PostController::class, 'getallpublishpost'])->name('post');
Route::get('/post/category/', [PostController::class, 'showcategorypost'])->name('post.showcategorypost');
Route::get('/post/categorypost/{id}', [PostController::class, 'categorypostdata']);
Route::get('/manager', function () {
    return view('manager.doashboard');
});
// points
Route::get('/points', [PointController::class, 'showPoints'])->middleware('auth')->name('user.points');
Route::resource('products', ProductController::class);
Route::resource('vouchers', VoucherController::class);
Route::resource('posts', PostController::class)->middleware('checkCategoryPost');
Route::resource('comments', CommentProductController::class);
Route::resource('commentpost', CommentPostController::class);

// routes/web.php
Route::get('/viewed-products', [ProductController::class,'viewedProducts'])->name('viewed.products');

Route::get('/home', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('/');

Route::middleware('auth')->group(function () {
    Route::resource('profile', ProfileController::class);
    Route::get('/upload.cover/{id}', [ProfileController::class, 'uploadCover'])->name('upload.cover');
});

Route::group(['middleware' => ['web']], function () {

    Route::get('/cart', [CartController::class, 'cart'])->name('cart');
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/add-to-cart-detail', [CartController::class, 'addToCartDetail'])->name('cart.add.detail');
    Route::post('/remove-from-cart/{productId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
});


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

// ... Các tuyến đường khác

require __DIR__ . '/auth.php';


Route::get('/manager', function () {
    return view('manager.doashboard');
});
//Dat

Route::resource('categoriesProduct', CategoryController::class);
Route::resource('categoriesPost', CategoryPostController::class);

Route::get('allproduct', [ProductController::class, 'getAllProduct'])->name('allproducts.index');
Route::get('/allproduct/sort/{order}', [ProductController::class, 'sort'])->name('products.sort');

//Dat CURD CategoryProduct
route::post('/create', [CategoryController::class, 'create']);
route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('categoryP.delete');
route::put('/editcategory/{id}', [CategoryController::class, 'update'])->name('category.update');

//Dat CURD CategoryPost
route::post('/createPost',[CategoryPostController::class,'create']);
route::delete('/deletePost/{id}',[CategoryPostController::class,'deletePost'])->name('categoryPost.delete');
route::put('/editcategoryPost/{id}',[CategoryPostController::class,'update'])->name('categorypost.update');
route::get('/manager',[ProductController::class,'managerproduct']);



//Quản lý user Kien
Route::resource('users', UserController::class);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::get('/users/{user}/unDisable', [UserController::class, 'unDisable'])->name('users.unDisable');
Route::get('/users/{user}/disable', [UserController::class, 'disable'])->name('users.disable');

//Sản phẩm vừa xem
Route::get('/recently-viewed', function () {
    $recentlyViewedProductIds = session('recently_viewed_products', []);
    if(count($recentlyViewedProductIds) > 0) {
        $productIdsString = implode(',', $recentlyViewedProductIds);
        $recentlyViewedProducts = DB::select("SELECT id, name, photo, price FROM products WHERE id IN ($productIdsString) ORDER BY FIELD(id, $productIdsString)");
        return view('profile.recent', ['recentlyViewedProducts' => $recentlyViewedProducts]);
    }
    else {
        $productClone = $recentlyViewedProductIds;
        return view('profile.recent', ['recentlyViewedProducts' => $productClone]);
    }
});

//sản phẩm đã thích
Route::get('/wishlist/{id}', [WishlistController::class, 'toggle'])->name('wishlist');
Route::get('/wishlists', [WishlistController::class, 'index'])->middleware('auth');
Route::delete('/wishlists/{id}', [WishlistController::class, 'destroy']);

//Setting
Route::resource('setting',SettingController::class);

