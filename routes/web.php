<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

// API Routes
Route::post('/user-registration', [UserController::class, 'UserRegistration'])->name('userRegistration');
Route::post('/user-login', [UserController::class, 'UserLogin'])->name('userLogin');
Route::post('/send-otp', [UserController::class, 'SendOtpCOde'])->name('sendOtp');
Route::post('/verify-otp', [UserController::class, 'VerifyOtpCOde'])->name('verifyOtp');
// Token Verification Middleware
Route::post('/reset-password', [UserController::class, 'ResetPassword'])->name('resetPassword')->middleware([TokenVerificationMiddleware::class]);

// Profile Routes
Route::get('/user-profile', [UserController::class, 'UserProfile'])->name('userProfile')->middleware([TokenVerificationMiddleware::class]);
Route::post('/user-update', [UserController::class, 'UpdateProfile'])->name('userUpdate')->middleware([TokenVerificationMiddleware::class]);

// Pages Routes
Route::get('/', [UserController::class, 'welcome'])->name('welcome');
Route::get('/registration', [UserController::class, 'RegistrationPage'])->name('registration');
Route::get('/login', [UserController::class, 'LoginPage'])->name('login');
Route::get('/forgotPassword', [UserController::class, 'ForgotPasswordPage'])->name('forgotPassword');
Route::get('/otpVerification', [UserController::class, 'OTPVerificationPage'])->name('otpVerification');
Route::get('/resetPassword', [UserController::class, 'ResetPasswordPage'])->name('resetPassword')->middleware([TokenVerificationMiddleware::class]);
Route::get('/dashboard', [DashboardController::class, 'DashboardPage'])->name('dashboard')->middleware([TokenVerificationMiddleware::class]);
Route::get('/profile', [UserController::class, 'ProfilePage'])->name('profile')->middleware([TokenVerificationMiddleware::class]);
Route::get('/category', [CategoryController::class, 'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/customer', [CustomerController::class, 'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/product', [ProductController::class, 'ProductPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/invoice', [InvoiceController::class, 'InvoicePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/sales', [InvoiceController::class, 'SalesPage'])->middleware([TokenVerificationMiddleware::class]);

// Category API
Route::post("/create-category", [CategoryController::class, 'AddCategory'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/list-category", [CategoryController::class, 'CategoryList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/delete-category", [CategoryController::class, 'DeleteCategory'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/update-category", [CategoryController::class, 'UpdateCategory'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/category-by-id", [CategoryController::class, 'CategoryByID'])->middleware([TokenVerificationMiddleware::class]);

// Customer API
Route::post("/create-customer", [CustomerController::class, 'CustomerCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/list-customer", [CustomerController::class, 'CustomerList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/delete-customer", [CustomerController::class, 'CustomerDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/update-customer", [CustomerController::class, 'CustomerUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/customer-by-id", [CustomerController::class, 'CustomerByID'])->middleware([TokenVerificationMiddleware::class]);

// Product API
Route::post("/create-product", [ProductController::class, 'CreateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/delete-product", [ProductController::class, 'DeleteProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/update-product", [ProductController::class, 'UpdateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/list-product", [ProductController::class, 'ProductList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/product-by-id", [ProductController::class, 'ProductByID'])->middleware([TokenVerificationMiddleware::class]);

// Invoice API
Route::post("/invoice-create", [InvoiceController::class, 'invoiceCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/invoice-select", [InvoiceController::class, 'invoiceSelect'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/invoice-details", [InvoiceController::class, 'InvoiceDetails'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/invoice-delete", [InvoiceController::class, 'invoiceDelete'])->middleware([TokenVerificationMiddleware::class]);

// Logout Route
Route::get('/logout', [UserController::class, 'UserLogout'])->name('logout');
