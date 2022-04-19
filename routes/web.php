<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('demo/index');
});
Route::get('/advanced-ui-kits-image-crop', function () {
    return view('demo/advanced-ui-kits-image-crop');
});
Route::get('/advanced-ui-kits-jquery-confirm', function () {
    return view('demo/advanced-ui-kits-jquery-confirm');
});
Route::get('/advanced-ui-kits-nestable', function () {
    return view('demo/advanced-ui-kits-nestable');
});
Route::get('/advanced-ui-kits-pnotify', function () {
    return view('demo/advanced-ui-kits-pnotify');
});
Route::get('/advanced-ui-kits-range-slider', function () {
    return view('demo/advanced-ui-kits-range-slider');
});
Route::get('/advanced-ui-kits-ratings', function () {
    return view('demo/advanced-ui-kits-ratings');
});
Route::get('/advanced-ui-kits-session-timeout', function () {
    return view('demo/advanced-ui-kits-session-timeout');
});
Route::get('/advanced-ui-kits-sweet-alerts', function () {
    return view('demo/advanced-ui-kits-sweet-alerts');
});
Route::get('/advanced-ui-kits-switchery', function () {
    return view('demo/advanced-ui-kits-switchery');
});
Route::get('/advanced-ui-kits-toolbar', function () {
    return view('demo/advanced-ui-kits-toolbar');
});
Route::get('/advanced-ui-kits-tour', function () {
    return view('demo/advanced-ui-kits-tour');
});
Route::get('/advanced-ui-kits-treeview', function () {
    return view('demo/advanced-ui-kits-treeview');
});
Route::get('/apps-calender', function () {
    return view('demo/apps-calender');
});
Route::get('/apps-chat', function () {
    return view('demo/apps-chat');
});
Route::get('/apps-email-compose', function () {
    return view('demo/apps-email-compose');
});
Route::get('/apps-email-inbox', function () {
    return view('demo/apps-email-inbox');
});
Route::get('/apps-email-open', function () {
    return view('demo/apps-email-open');
});
Route::get('/apps-kanban-board', function () {
    return view('demo/apps-kanban-board');
});
Route::get('/apps-onboarding-screens', function () {
    return view('demo/apps-onboarding-screens');
});
Route::get('/basic-ui-kits-alerts', function () {
    return view('demo/basic-ui-kits-alerts');
});
Route::get('/basic-ui-kits-badges', function () {
    return view('demo/basic-ui-kits-badges');
});
Route::get('/basic-ui-kits-buttons', function () {
    return view('demo/basic-ui-kits-buttons');
});
Route::get('/basic-ui-kits-cards', function () {
    return view('demo/basic-ui-kits-cards');
});
Route::get('/basic-ui-kits-carousel', function () {
    return view('demo/basic-ui-kits-carousel');
});
Route::get('/basic-ui-kits-collapse', function () {
    return view('demo/basic-ui-kits-collapse');
});
Route::get('/basic-ui-kits-dropdowns', function () {
    return view('demo/basic-ui-kits-dropdowns');
});
Route::get('/basic-ui-kits-embeds', function () {
    return view('demo/basic-ui-kits-embeds');
});
Route::get('/basic-ui-kits-grids', function () {
    return view('demo/basic-ui-kits-grids');
});
Route::get('/basic-ui-kits-images', function () {
    return view('demo/basic-ui-kits-images');
});
Route::get('/basic-ui-kits-media', function () {
    return view('demo/basic-ui-kits-media');
});
Route::get('/basic-ui-kits-modals', function () {
    return view('demo/basic-ui-kits-modals');
});
Route::get('/basic-ui-kits-paginations', function () {
    return view('demo/basic-ui-kits-paginations');
});
Route::get('/basic-ui-kits-popovers', function () {
    return view('demo/basic-ui-kits-popovers');
});
Route::get('/basic-ui-kits-progressbars', function () {
    return view('demo/basic-ui-kits-progressbars');
});
Route::get('/basic-ui-kits-spinners', function () {
    return view('demo/basic-ui-kits-spinners');
});
Route::get('/basic-ui-kits-tabs', function () {
    return view('demo/basic-ui-kits-tabs');
});
Route::get('/basic-ui-kits-toasts', function () {
    return view('demo/basic-ui-kits-toasts');
});
Route::get('/basic-ui-kits-tooltips', function () {
    return view('demo/basic-ui-kits-tooltips');
});
Route::get('/basic-ui-kits-typography', function () {
    return view('demo/basic-ui-kits-typography');
});
Route::get('/chart-apex', function () {
    return view('demo/chart-apex');
});
Route::get('/chart-c3', function () {
    return view('demo/chart-c3');
});
Route::get('/chart-chartistjs', function () {
    return view('demo/chart-chartistjs');
});
Route::get('/chart-chartjs', function () {
    return view('demo/chart-chartjs');
});
Route::get('/chart-flot', function () {
    return view('demo/chart-flot');
});
Route::get('/chart-knob', function () {
    return view('demo/chart-knob');
});
Route::get('/chart-morris', function () {
    return view('demo/chart-morris');
});
Route::get('/chart-piety', function () {
    return view('demo/chart-piety');
});
Route::get('/chart-sparkline', function () {
    return view('demo/chart-sparkline');
});
Route::get('/crm-clients', function () {
    return view('demo/crm-clients');
});
Route::get('/crm-lead-status', function () {
    return view('demo/crm-lead-status');
});
Route::get('/crm-projects', function () {
    return view('demo/crm-projects');
});
Route::get('/dashboard-ecommerce', function () {
    return view('demo/dashboard-ecommerce');
});
Route::get('/dashboard-hospital', function () {
    return view('demo/dashboard-hospital');
});
Route::get('/ecommerce-cart', function () {
    return view('demo/ecommerce-cart');
});
Route::get('/ecommerce-checkout', function () {
    return view('demo/ecommerce-checkout');
});
Route::get('/ecommerce-myaccount', function () {
    return view('demo/ecommerce-myaccount');
});
Route::get('/ecommerce-order-detail', function () {
    return view('demo/ecommerce-order-detail');
});
Route::get('/ecommerce-order-list', function () {
    return view('demo/ecommerce-order-list');
});
Route::get('/ecommerce-product-detail', function () {
    return view('demo/ecommerce-product-detail');
});
Route::get('/ecommerce-product-list', function () {
    return view('demo/ecommerce-product-list');
});
Route::get('/ecommerce-shop', function () {
    return view('demo/ecommerce-shop');
});
Route::get('/ecommerce-single-product', function () {
    return view('demo/ecommerce-single-product');
});
Route::get('/ecommerce-thankyou', function () {
    return view('demo/ecommerce-thankyou');
});
Route::get('/error-404', function () {
    return view('demo/error-404');
});
Route::get('/error-500', function () {
    return view('demo/error-500');
});
Route::get('/error-comingsoon', function () {
    return view('demo/error-comingsoon');
});
Route::get('/error-maintenance', function () {
    return view('demo/error-maintenance');
});
Route::get('/form-colorpickers', function () {
    return view('demo/form-colorpickers');
});
Route::get('/form-datepickers', function () {
    return view('demo/form-datepickers');
});
Route::get('/form-editors', function () {
    return view('demo/form-editors');
});
Route::get('/form-file-uploads', function () {
    return view('demo/form-file-uploads');
});
Route::get('/form-groups', function () {
    return view('demo/form-groups');
});
Route::get('/form-input-mask', function () {
    return view('demo/form-input-mask');
});
Route::get('/form-inputs', function () {
    return view('demo/form-inputs');
});
Route::get('/form-layouts', function () {
    return view('demo/form-layouts');
});
Route::get('/form-maxlength', function () {
    return view('demo/form-maxlength');
});
Route::get('/form-selects', function () {
    return view('demo/form-selects');
});
Route::get('/form-touchspin', function () {
    return view('demo/form-touchspin');
});
Route::get('/form-validations', function () {
    return view('demo/form-validations');
});
Route::get('/form-wizards', function () {
    return view('demo/form-wizards');
});
Route::get('/form-xeditable', function () {
    return view('demo/form-xeditable');
});
Route::get('/hospital-appointment', function () {
    return view('demo/hospital-appointment');
});
Route::get('/hospital-doctor', function () {
    return view('demo/hospital-doctor');
});
Route::get('/hospital-patient', function () {
    return view('demo/hospital-patient');
});
Route::get('/icon-dripicons', function () {
    return view('demo/icon-dripicons');
});
Route::get('/icon-feather', function () {
    return view('demo/icon-feather');
});
Route::get('/icon-flag', function () {
    return view('demo/icon-flag');
});
Route::get('/icon-font-awesome', function () {
    return view('demo/icon-font-awesome');
});
Route::get('/icon-ionicons', function () {
    return view('demo/icon-ionicons');
});
Route::get('/icon-line-awesome', function () {
    return view('demo/icon-line-awesome');
});
Route::get('/icon-material-design', function () {
    return view('demo/icon-material-design');
});
Route::get('/icon-simple-line', function () {
    return view('demo/icon-simple-line');
});
Route::get('/icon-socicon', function () {
    return view('demo/icon-socicon');
});
Route::get('/icon-themify', function () {
    return view('demo/icon-themify');
});
Route::get('/icon-svg', function () {
    return view('demo/icon-svg');
});
Route::get('/icon-typicons', function () {
    return view('demo/icon-typicons');
});
Route::get('/map-google', function () {
    return view('demo/map-google');
});
Route::get('/map-vector', function () {
    return view('demo/map-vector');
});
Route::get('/page-blog', function () {
    return view('demo/page-blog');
});
Route::get('/page-faq', function () {
    return view('demo/page-faq');
});
Route::get('/page-gallery', function () {
    return view('demo/page-gallery');
});
Route::get('/page-invoice', function () {
    return view('demo/page-invoice');
});
Route::get('/page-pricing', function () {
    return view('demo/page-pricing');
});
Route::get('/page-starter', function () {
    return view('demo/page-starter');
});
Route::get('/page-timeline', function () {
    return view('demo/page-timeline');
});
Route::get('/table-bootstrap', function () {
    return view('demo/table-bootstrap');
});
Route::get('/table-datatable', function () {
    return view('demo/table-datatable');
});
Route::get('/table-editable', function () {
    return view('demo/table-editable');
});
Route::get('/table-footable', function () {
    return view('demo/table-footable');
});
Route::get('/table-rwdtable', function () {
    return view('demo/table-rwdtable');
});
Route::get('/user-forgotpsw', function () {
    return view('demo/user-forgotpsw');
});
Route::get('/user-lock-screen', function () {
    return view('demo/user-lock-screen');
});
Route::get('/user-login', function () {
    return view('demo/user-login');
});
Route::get('/user-register', function () {
    return view('demo/user-register');
});
Route::get('/widgets', function () {
    return view('demo/widgets');
});
