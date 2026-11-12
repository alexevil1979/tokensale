<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenHubController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;

Route::get("/", [TokenHubController::class, "home"])->name("home");
Route::get("/models", [TokenHubController::class, "models"])->name("models");
Route::get("/login", [TokenHubController::class, "login"])->name("login");
Route::post("/login", [TokenHubController::class, "authenticate"]);
Route::get("/register", [TokenHubController::class, "register"])->name("register");
Route::post("/register", [TokenHubController::class, "storeUser"]);
Route::post("/logout", [TokenHubController::class, "logout"])->middleware("auth")->name("logout");

Route::middleware("auth")->group(function () {
    Route::get("/dashboard", [TokenHubController::class, "dashboard"])->name("dashboard");
    Route::post("/keys", [TokenHubController::class, "createKey"])->name("keys.create");
    Route::delete("/keys/{key}", [TokenHubController::class, "deleteKey"])->name("keys.delete");
    Route::post("/demo-topup", [TokenHubController::class, "demoTopup"])->name("demo.topup");
});

Route::get("/admin/login", [AdminAuthController::class, "showLogin"])->name("admin.login");
Route::post("/admin/login", [AdminAuthController::class, "login"])->name("admin.login.submit");
Route::post("/admin/logout", [AdminAuthController::class, "logout"])->middleware("auth")->name("admin.logout");

Route::middleware(["auth", "admin"])->prefix("admin")->group(function () {
    Route::get("/", [AdminController::class, "index"])->name("admin.index");
    Route::patch("/models/{model}", [AdminController::class, "updateModel"])->name("admin.models.update");
    Route::post("/models", [AdminController::class, "createModel"])->name("admin.models.create");
});
