<?php

use App\Http\Controllers\HomeController;
use App\Http\Middleware\SessionAuthenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\TokenVerificationMiddleware;
use App\Models\Category;
use App\Models\Customer;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::post('/user-registration', [UserController::class, 'UserRegistration'])->name('user.registration');
Route::post('/user-login', [UserController::class, 'UserLogin'])->name('user.login');
Route::post('/send-otp', [UserController::class, 'SendOtp'])->name('send.otp');
Route::post('/verify-otp', [UserController::class, 'VerifyOtp'])->name('verify.otp');

Route::middleware([SessionAuthenticate::class])->group(function () {
//reset password
    Route::post('/reset-password', [UserController::class, 'ResetPassword'])->name('reset.password');

    Route::get('/dashboard', [UserController::class, 'DashboardPage'])->name('dashboard');
    Route::get('/user-logout', [UserController::class, 'Logout'])->name('logout');

    //category routes
    Route::post('/create-category', [CategoryController::class, 'CreateCategory'])->name('create.category');
    Route::get('/category-list', [CategoryController::class, 'CategoryList'])->name('category.list');
    Route::post('/category-by-id', [CategoryController::class, 'CategoryById']);
    Route::post('/update-category', [CategoryController::class, 'UpdateCategory']);
    Route::post('/delete-category/{id}', [CategoryController::class, 'DeleteCategory']);

    //product routes
    Route::post('/create-product', [ProductController::class, 'CreateProduct'])->name('create.product');
    Route::get('/product-list', [ProductController::class, 'ProductList'])->name('product.list');
    Route::post('/product-by-id', [ProductController::class, 'ProductById']);
    Route::post('/update-product', [ProductController::class, 'UpdateProduct']);
    Route::post('/delete-product/{id}', [ProductController::class, 'DeleteProduct']);

    //customer routes
    Route::post('/create-customer', [CustomerController::class, 'CreateCustomer'])->name('create.customer');
    Route::get('/customer-list', [CustomerController::class, 'CustomerList'])->name('customer.list');
    Route::post('/customer-by-id', [CustomerController::class, 'CustomerById']);
    Route::post('/update-customer', [CustomerController::class, 'UpdateCustomer']);
    Route::post('/delete-customer/{id}', [CustomerController::class, 'DeleteCustomer']);

    //invoice routes
    Route::post('/create-invoice', [InvoiceController::class, 'CreateInvoice'])->name('create.invoice');
    Route::get('/invoice-list', [InvoiceController::class, 'InvoiceList'])->name('invoice.list');
    Route::post('/invoice-details', [InvoiceController::class, 'InvoiceDetails'])->name('invoice.details');
    Route::get('/invoice-delete/{id}', [InvoiceController::class, 'DeleteInvoice'])->name('invoice.delete');

    //dashboard-summary
    Route::get('/dashboard-summary', [DashboardController::class, 'DashboardSummary'])->name('dashboard.summary');

    //reset password page
    Route::get('reset-password', [UserController::class, 'ResetPasswordPage'])->name('reset.password.page');
});

//pages all routes
Route::get('/login',[UserController::class, 'LoginPage'])->name('login.page');
Route::get('/register',[UserController::class, 'RegisterPage'])->name('register.page');
Route::get('/send-otp',[UserController::class, 'SendOtpPage'])->name('send.otp.page');
Route::get('/verify-otp',[UserController::class, 'VerifyOtpPage'])->name('verify.otp.page');

