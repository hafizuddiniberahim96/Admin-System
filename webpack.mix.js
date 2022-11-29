const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js')
//     .postCss('resources/css/app.css', 'public/css', [
//         //
//     ]);

mix.copy('node_modules/@coreui/chartjs/dist/css/coreui-chartjs.css', 'public/css');
mix.copy('node_modules/cropperjs/dist/cropper.css', 'public/css');
//main css
mix.sass('resources/sass/style.scss', 'public/css');

//************** SCRIPTS ****************** 
// general scripts
mix.copy('node_modules/@coreui/utils/dist/coreui-utils.js', 'public/js');
mix.copy('node_modules/axios/dist/axios.min.js', 'public/js'); 
//mix.copy('node_modules/pace-progress/pace.min.js', 'public/js');  
mix.copy('node_modules/@coreui/coreui/dist/js/coreui.bundle.min.js', 'public/js'); 
// views scripts
mix.copy('node_modules/chart.js/dist/Chart.min.js', 'public/js'); 
mix.copy('node_modules/@coreui/chartjs/dist/js/coreui-chartjs.bundle.js', 'public/js');

mix.copy('node_modules/cropperjs/dist/cropper.js', 'public/js');
// details scripts
mix.copy('resources/js/coreui/main.js', 'public/js');
mix.copy('resources/js/coreui/colors.js', 'public/js');
mix.copy('resources/js/coreui/charts.js', 'public/js');
mix.copy('resources/js/coreui/widgets.js', 'public/js');
mix.copy('resources/js/coreui/popovers.js', 'public/js');
mix.copy('resources/js/coreui/tooltips.js', 'public/js');
// details scripts admin-panel
mix.js('resources/js/coreui/menu-create.js', 'public/js');
mix.js('resources/js/coreui/menu-edit.js', 'public/js');
mix.js('resources/js/coreui/media.js', 'public/js');
mix.js('resources/js/coreui/media-cropp.js', 'public/js');
//*************** OTHER ****************** 
//fonts
mix.copy('node_modules/@coreui/icons/fonts', 'public/fonts');
//icons
mix.copy('node_modules/@coreui/icons/css/free.min.css', 'public/css');
mix.copy('node_modules/@coreui/icons/css/brand.min.css', 'public/css');
mix.copy('node_modules/@coreui/icons/css/flag.min.css', 'public/css');
mix.copy('node_modules/@coreui/icons/svg/flag', 'public/svg/flag');

mix.copy('node_modules/@coreui/icons/sprites/', 'public/icons/sprites');
//images
mix.copy('resources/assets', 'public/assets');

// Copy fonts straight to public
mix.copy( 'node_modules/font-awesome/'+ 'fonts', 'public/fonts');
//fontawesome
mix.copy('node_modules/font-awesome/css/font-awesome.min.css', 'public/css');
mix.copy('node_modules/font-awesome/fonts', 'public/fonts');

mix.copy('node_modules/animate.css/' + 'animate.min.css', 'public/vendors/animate/css');

// pnotify
mix.copy('node_modules/pnotify/dist/' + 'pnotify.css', 'public/vendors/pnotify/css');
mix.copy('node_modules/pnotify/dist/' + 'pnotify.brighttheme.css', 'public/vendors/pnotify/css');
mix.copy('node_modules/pnotify/dist/' + 'pnotify.buttons.css', 'public/vendors/pnotify/css');
mix.copy('node_modules/pnotify/dist/' + 'pnotify.mobile.css', 'public/vendors/pnotify/css');
mix.copy('node_modules/pnotify/dist/' + 'pnotify.history.css', 'public/vendors/pnotify/css');

// pnotify js
mix.copy('node_modules/pnotify/dist/' + 'pnotify.js', 'public/vendors/pnotify/js');
mix.copy('node_modules/pnotify/dist/' + 'pnotify.animate.js', 'public/vendors/pnotify/js');
mix.copy('node_modules/pnotify/dist/' + 'pnotify.buttons.js', 'public/vendors/pnotify/js');
mix.copy('node_modules/pnotify/dist/' + 'pnotify.confirm.js', 'public/vendors/pnotify/js');
mix.copy('node_modules/pnotify/dist/' + 'pnotify.nonblock.js', 'public/vendors/pnotify/js');
mix.copy('node_modules/pnotify/dist/' + 'pnotify.mobile.js', 'public/vendors/pnotify/js');
mix.copy('node_modules/pnotify/dist/' + 'pnotify.desktop.js', 'public/vendors/pnotify/js');
mix.copy('node_modules/pnotify/dist/' + 'pnotify.history.js', 'public/vendors/pnotify/js');
mix.copy('node_modules/pnotify/dist/' + 'pnotify.callbacks.js', 'public/vendors/pnotify/js');

//sweetalert
mix.copy('node_modules/sweetalert2/dist/' + 'sweetalert2.min.css', 'public/vendors/sweetalert/css');
mix.copy('node_modules/sweetalert2/dist/' + 'sweetalert2.min.js', 'public/vendors/sweetalert/js');

mix.sass(
    'resources/sass/sweetalert/sweetalert2.scss',
    'public/css/pages/sweet_alert.css'
).options({
    processCssUrls: false,
});

mix.styles('resources/css/pages/sweet_alert.css', 'public/css/pages/sweet_alert.css');
