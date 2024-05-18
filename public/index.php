<?php

use PBW\login\system\App\Router;
use PBW\login\system\Controller\MainController;
use PBW\login\system\Controller\AdminController;

require_once __DIR__ . '/../vendor/autoload.php';
//user
Router::add('GET', '/', MainController::class, 'index');
Router::add('GET', '/login_view', MainController::class, 'login_view');
Router::add('POST', '/login', MainController::class, 'login');
Router::add('GET', '/signup_view', MainController::class, 'signup_view');
Router::add('POST', '/signup', MainController::class, 'signup');
Router::add('GET', '/logout', MainController::class, 'logout');
Router::add('GET', '/welcome', MainController::class, 'welcome');
Router::add('GET', '/profile', MainController::class, 'profile');
Router::add('GET', '/edit-profile', MainController::class, 'editProfilePage');
Router::add('POST', '/update_profile', MainController::class, 'updateProfile');
Router::add('GET', '/change-password', MainController::class, 'changePasswordPage');
Router::add('POST', '/update_password', MainController::class, 'updatePassword');
Router::add('GET', '/password-recovery', MainController::class, 'passwordRecovery');
Router::add('POST', '/send-email', MainController::class, 'sendPasswordEmail');

// admin
Router::add('GET', '/admin', AdminController::class, 'index');
Router::add('POST', '/login-admin', AdminController::class, 'login');
Router::add('GET', '/dashboard', AdminController::class, 'dashboard');
Router::add('GET', '/manage-users', AdminController::class, 'manageUsers');
Router::add('GET', '/yesterday', AdminController::class, 'yesterdayUsers');
Router::add('GET', '/last7days', AdminController::class, 'last7DaysUsers');
Router::add('GET', '/last30days', AdminController::class, 'last30DaysUsers');
Router::add('GET', '/bwdates-report-ds', AdminController::class, 'bwdatesReportDs');
Router::add('POST', '/bwdates-report', AdminController::class, 'generateReport');
Router::add('POST', '/search', AdminController::class, 'searchUsers');
Router::add('GET', '/user-profile', AdminController::class, 'getUserProfile');
Router::add('GET', '/delete-user', AdminController::class, 'deleteUser');
Router::add('GET', '/admins-edit-profile', AdminController::class, 'editProfilePage');
Router::add('POST', '/admins-update_profile', AdminController::class, 'updateProfile');
Router::add('GET', '/admins-change-password', AdminController::class, 'changePasswordPage');
Router::add('POST', '/admins-update_password', AdminController::class, 'changePassword');

Router::run();