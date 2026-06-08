<?php
declare(strict_types=1);

use Calyo\Controllers\AuthController;
use Calyo\Controllers\BookingController;
use Calyo\Controllers\ClientController;
use Calyo\Controllers\DashboardController;
use Calyo\Controllers\EnquiryController;
use Calyo\Controllers\EventController;
use Calyo\Controllers\FilesController;
use Calyo\Controllers\GalleryController;
use Calyo\Controllers\NotificationController;
use Calyo\Controllers\PopupController;
use Calyo\Controllers\ServiceController;
use Calyo\Controllers\SettingsController;
use Calyo\Controllers\UserController;
use Calyo\Core\Router;
use Calyo\Middleware\AdminOnlyMiddleware;
use Calyo\Middleware\AuthMiddleware;
use Calyo\Middleware\CsrfMiddleware;
use Calyo\Middleware\GuestMiddleware;

return function (Router $router): void {
    // Public / guest routes
    $router->get('/',       [AuthController::class, 'showLogin'], [GuestMiddleware::class]);
    $router->get('/login',  [AuthController::class, 'showLogin'], [GuestMiddleware::class]);
    $router->post('/login', [AuthController::class, 'login'],     [CsrfMiddleware::class, GuestMiddleware::class]);

    // Authenticated routes
    $router->post('/logout',    [AuthController::class,    'logout'], [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->get('/dashboard',  [DashboardController::class, 'index'], [AuthMiddleware::class]);

    // Clients — static routes before wildcard
    $router->get('/clients',                 [ClientController::class, 'index'],   [AuthMiddleware::class]);
    $router->get('/clients/export',          [ClientController::class, 'export'],  [AuthMiddleware::class]);
    $router->post('/clients/store',          [ClientController::class, 'store'],   [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/clients/{id}/update',    [ClientController::class, 'update'],  [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/clients/{id}/delete',    [ClientController::class, 'destroy'], [CsrfMiddleware::class, AuthMiddleware::class]);

    // Services & Workshops — static routes before wildcards
    $router->get('/services',                 [ServiceController::class, 'index'],   [AuthMiddleware::class]);
    $router->post('/services/store',          [ServiceController::class, 'store'],   [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/services/{id}/update',    [ServiceController::class, 'update'],  [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/services/{id}/delete',    [ServiceController::class, 'destroy'], [CsrfMiddleware::class, AuthMiddleware::class]);

    // Events — static routes before wildcards
    $router->get('/events',                 [EventController::class, 'index'],   [AuthMiddleware::class]);
    $router->post('/events/store',          [EventController::class, 'store'],   [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/events/{id}/update',    [EventController::class, 'update'],  [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/events/{id}/delete',    [EventController::class, 'destroy'], [CsrfMiddleware::class, AuthMiddleware::class]);

    // Gallery — website gallery images (upload or direct URL); static routes before wildcards
    $router->get('/gallery',                 [GalleryController::class, 'index'],   [AuthMiddleware::class]);
    // Gallery categories — managed inside the Gallery page (static paths, before image wildcards)
    $router->post('/gallery/categories/store',       [GalleryController::class, 'storeCategory'],   [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/gallery/categories/{id}/update', [GalleryController::class, 'updateCategory'],  [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/gallery/categories/{id}/delete', [GalleryController::class, 'destroyCategory'], [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/gallery/store',          [GalleryController::class, 'store'],   [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/gallery/{id}/update',    [GalleryController::class, 'update'],  [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/gallery/{id}/delete',    [GalleryController::class, 'destroy'], [CsrfMiddleware::class, AuthMiddleware::class]);

    // Popups — website promo modals; static routes before wildcards
    $router->get('/popups',                 [PopupController::class, 'index'],   [AuthMiddleware::class]);
    $router->post('/popups/store',          [PopupController::class, 'store'],   [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/popups/{id}/update',    [PopupController::class, 'update'],  [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/popups/{id}/delete',    [PopupController::class, 'destroy'], [CsrfMiddleware::class, AuthMiddleware::class]);

    // Bookings — static routes before wildcards
    $router->get('/bookings',                       [BookingController::class, 'index'],        [AuthMiddleware::class]);
    $router->get('/bookings/export',                [BookingController::class, 'export'],       [AuthMiddleware::class]);
    $router->post('/bookings/store',                [BookingController::class, 'store'],        [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/bookings/{id}/status',          [BookingController::class, 'updateStatus'], [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/bookings/{id}/images',          [BookingController::class, 'uploadImage'],  [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/bookings/{id}/images/delete',   [BookingController::class, 'deleteImage'],  [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/bookings/{id}/delete',          [BookingController::class, 'destroy'],      [CsrfMiddleware::class, AuthMiddleware::class]);

    // Files — reference images attached to completed bookings (storage cleanup)
    $router->get('/files', [FilesController::class, 'index'], [AuthMiddleware::class]);

    // Enquiries — General Enquiry rows in bookings, with their own admin view
    $router->get('/enquiries',                       [EnquiryController::class, 'index'],        [AuthMiddleware::class]);
    $router->post('/enquiries/store',                [EnquiryController::class, 'store'],        [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/enquiries/{id}/status',          [EnquiryController::class, 'updateStatus'], [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/enquiries/{id}/delete',          [EnquiryController::class, 'destroy'],      [CsrfMiddleware::class, AuthMiddleware::class]);

    // Notifications — broadcast email to clients (admin role only)
    $router->get('/notifications',       [NotificationController::class, 'index'], [AuthMiddleware::class, AdminOnlyMiddleware::class]);
    $router->post('/notifications/send', [NotificationController::class, 'send'],  [CsrfMiddleware::class, AuthMiddleware::class, AdminOnlyMiddleware::class]);

    // Settings — profile / password (all auth users), studio + appearance (admin only)
    $router->get('/settings',                       [SettingsController::class, 'index'],            [AuthMiddleware::class]);
    $router->post('/settings/profile',              [SettingsController::class, 'updateProfile'],    [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/settings/password',             [SettingsController::class, 'updatePassword'],   [CsrfMiddleware::class, AuthMiddleware::class]);
    $router->post('/settings/studio',               [SettingsController::class, 'updateStudio'],     [CsrfMiddleware::class, AuthMiddleware::class, AdminOnlyMiddleware::class]);
    $router->post('/settings/appearance',           [SettingsController::class, 'updateAppearance'], [CsrfMiddleware::class, AuthMiddleware::class, AdminOnlyMiddleware::class]);

    // Admin Management — staff/admin accounts (admin role only)
    $router->get('/users',                 [UserController::class, 'index'],   [AuthMiddleware::class, AdminOnlyMiddleware::class]);
    $router->post('/users/store',          [UserController::class, 'store'],   [CsrfMiddleware::class, AuthMiddleware::class, AdminOnlyMiddleware::class]);
    $router->post('/users/{id}/update',    [UserController::class, 'update'],  [CsrfMiddleware::class, AuthMiddleware::class, AdminOnlyMiddleware::class]);
    $router->post('/users/{id}/delete',    [UserController::class, 'destroy'], [CsrfMiddleware::class, AuthMiddleware::class, AdminOnlyMiddleware::class]);
};
