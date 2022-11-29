/*=========================================================================================
  File Name: app.js
  Description: Template related app JS.
  ----------------------------------------------------------------------------------------
  Item Name: Modern Admin - Clean Bootstrap 4 Dashboard HTML Template
 Version: 3.0
  Author: Pixinvent
  Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

(function(window, document, $) {
    'use strict';
    var $html = $('html');
    var $body = $('body');

    // setTimeout(function () {
    //    $("body").show();
    // },400);

    $(window).on('load',function(){
        var rtl;
        var compactMenu = false; // Set it to true, if you want default menu to be compact

        if($('html').data('textdirection') == 'rtl'){
            rtl = true;
        }

        setTimeout(function(){
            $html.removeClass('loading').addClass('loaded');
        }, 1200);

        $.app.menu.init(compactMenu);

        // Navigation configurations
        var config = {
            speed: 100 // set speed to expand / collpase menu
        };
        if($.app.nav.initialized === false){
            $.app.nav.init(config);
        }

        Unison.on('change', function(bp) {
            $.app.menu.change();
        });

        // Tooltip Initialization
        $('[data-toggle="tooltip"]').tooltip({
            container:'body'
        });

        // Top Navbars - Hide on Scroll
        if ($(".navbar-hide-on-scroll").length > 0) {
            $(".navbar-hide-on-scroll.fixed-top").headroom({
              "offset": 205,
              "tolerance": 5,
              "classes": {
                 // when element is initialised
                initial : "headroom",
                // when scrolling up
                pinned : "headroom--pinned-top",
                // when scrolling down
                unpinned : "headroom--unpinned-top",
              }
            });
            // Bottom Navbars - Hide on Scroll
            $(".navbar-hide-on-scroll.fixed-bottom").headroom({
              "offset": 205,
              "tolerance": 5,
              "classes": {
                 // when element is initialised
                initial : "headroom",
                // when scrolling up
                pinned : "headroom--pinned-bottom",
                // when scrolling down
                unpinned : "headroom--unpinned-bottom",
              }
            });
        }

        //Match content & menu height for content menu
        setTimeout(function(){
            if($('body').hasClass('vertical-content-menu')){
                setContentMenuHeight();
            }
        },500);
        function setContentMenuHeight(){
            var menuHeight = $('.main-menu').height();
            var bodyHeight = $('.content-body').height();
            if(bodyHeight<menuHeight){
                $('.content-body').css('height',menuHeight);
            }
        }

        // Collapsible Card
        $('a[data-action="collapse"]').on('click',function(e){
            e.preventDefault();
            $(this).closest('.card').children('.card-content').collapse('toggle');
            $(this).closest('.card').find('[data-action="collapse"] i').toggleClass('ft-plus ft-minus');

        });

        // Toggle fullscreen
        $('a[data-action="expand"]').on('click',function(e){
            e.preventDefault();
            $(this).closest('.card').find('[data-action="expand"] i').toggleClass('ft-maximize ft-minimize');
            $(this).closest('.card').toggleClass('card-fullscreen');
        });

        //  Notifications & messages scrollable
        if($('.scrollable-container').length > 0){
            $('.scrollable-container').each(function(){
                var scrollable_container = new PerfectScrollbar($(this)[0]); 
            });
        }

        // Reload Card
        $('a[data-action="reload"]').on('click',function(){
            var block_ele = $(this).closest('.card');

            // Block Element
            block_ele.block({
                message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
                timeout: 2000, //unblock after 2 seconds
                overlayCSS: {
                    backgroundColor: '#FFF',
                    cursor: 'wait',
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'none'
                }
            });
        });

        // Close Card
        $('a[data-action="close"]').on('click',function(){
            $(this).closest('.card').removeClass().slideUp('fast');
        });

        // Match the height of each card in a row
        setTimeout(function(){
            $('.row.match-height').each(function() {
                $(this).find('.card').not('.card .card').matchHeight(); // Not .card .card prevents collapsible cards from taking height
            });
        },500);


        $('.card .heading-elements a[data-action="collapse"]').on('click',function(){
            var $this = $(this),
            card = $this.closest('.card');
            var cardHeight;

            if(parseInt(card[0].style.height,10) > 0){
                cardHeight = card.css('height');
                card.css('height','').attr('data-height', cardHeight);
            }
            else{
                if(card.data('height')){
                    cardHeight = card.data('height');
                    card.css('height',cardHeight).attr('data-height', '');
                }
            }
        });

        // Add open class to parent list item if subitem is active except compact menu
        var menuType = $body.data('menu');
        if(menuType != 'vertical-compact-menu' && menuType != 'horizontal-menu' && compactMenu === false ){
            if( $body.data('menu') == 'vertical-menu-modern' ){
                if( localStorage.getItem("menuLocked") === "true"){
                    $(".main-menu-content").find('li.active').parents('li').addClass('open');
                }
            }
            else{
                $(".main-menu-content").find('li.active').parents('li').addClass('open');
            }
        }
        if(menuType == 'vertical-compact-menu' || menuType == 'horizontal-menu'){
            $(".main-menu-content").find('li.active').parents('li:not(.nav-item)').addClass('open');
            $(".main-menu-content").find('li.active').parents('li').addClass('active');
        }

        //card heading actions buttons small screen support
        $(".heading-elements-toggle").on("click",function(){
            $(this).parent().children(".heading-elements").toggleClass("visible");
        });

        //  Dynamic height for the chartjs div for the chart animations to work
        var chartjsDiv = $('.chartjs'),
        canvasHeight = chartjsDiv.children('canvas').attr('height');
        chartjsDiv.css('height', canvasHeight);

        if($body.hasClass('boxed-layout')){
            if($body.hasClass('vertical-overlay-menu') || $body.hasClass('vertical-compact-menu')){
               var menuWidth= $('.main-menu').width();
               var contentPosition = $('.app-content').position().left;
               var menuPositionAdjust = contentPosition-menuWidth;
               if($body.hasClass('menu-flipped')){
                    $('.main-menu').css('right',menuPositionAdjust+'px');
               }else{
                    $('.main-menu').css('left',menuPositionAdjust+'px');
               }
            }
        }

        $('.nav-link-search').on('click',function(){
            var $this = $(this),
            searchInput = $(this).siblings('.search-input');

            if(searchInput.hasClass('open')){
                searchInput.removeClass('open');
            }
            else{
                searchInput.addClass('open');
            }
        });
    });

    // Hide overlay menu on content overlay click on small screens
    $(document).on('click', '.sidenav-overlay', function(e) {
        // Hide menu
        $.app.menu.hide();
        return false;
    });

    // Execute below code only if we find hammer js for touch swipe feature on small screen
    if(typeof Hammer !== 'undefined'){

        // Swipe menu gesture
        var swipeInElement = document.querySelector('.drag-target');

        if( $(swipeInElement).length > 0 ){
            var swipeInMenu = new Hammer(swipeInElement);

            swipeInMenu.on("panright", function(ev) {
                if( $body.hasClass('vertical-overlay-menu') ){
                    $.app.menu.open();
                    return false;
                }
            });
        }

        // menu swipe out gesture
        setTimeout(function(){
            var swipeOutElement = document.querySelector('.main-menu');
            var swipeOutMenu;

            if( $(swipeOutElement).length > 0 ){
                swipeOutMenu = new Hammer(swipeOutElement);    
            
                swipeOutMenu.get('pan').set({ direction: Hammer.DIRECTION_ALL, threshold: 100 });

                swipeOutMenu.on("panleft", function(ev) {
                    if( $body.hasClass('vertical-overlay-menu') ){
                        $.app.menu.hide();
                        return false;
                    }
                });
            }
        }, 300);

        // menu overlay swipe out gestrue
        var swipeOutOverlayElement = document.querySelector('.sidenav-overlay');

        if( $(swipeOutOverlayElement).length > 0 ){

            var swipeOutOverlayMenu = new Hammer(swipeOutOverlayElement);

            swipeOutOverlayMenu.on("panleft", function(ev) {
                if( $body.hasClass('vertical-overlay-menu') ){
                    $.app.menu.hide();
                    return false;
                }
            });
        }
    }

    $(document).on('click', '.menu-toggle, .modern-nav-toggle', function(e) {
        e.preventDefault();

        // Hide dropdown of user profile section for material templates
        if($('.user-profile .user-info .dropdown').hasClass('show')){
            $('.user-profile .user-info .dropdown').removeClass('show');
            $('.user-profile .user-info .dropdown .dropdown-menu').removeClass('show');
        }

        // Toggle menu
        $.app.menu.toggle();

        setTimeout(function(){
            $(window).trigger( "resize" );
        },200);

        if($('#collapsed-sidebar').length > 0){
            setTimeout(function(){
                if($body.hasClass('menu-expanded') || $body.hasClass('menu-open')){
                    $('#collapsed-sidebar').prop('checked', false);
                }
                else{
                    $('#collapsed-sidebar').prop('checked', true);
                }
            },1000);
        }

        // Hides dropdown on click of menu toggle
        // $('[data-toggle="dropdown"]').dropdown('hide');
        
        // Hides collapse dropdown on click of menu toggle
        if($('.vertical-overlay-menu .navbar-with-menu .navbar-container .navbar-collapse').hasClass('show')){
            $('.vertical-overlay-menu .navbar-with-menu .navbar-container .navbar-collapse').removeClass('show');
        }

        return false;
    });

    $(document).on('click', '.open-navbar-container', function(e) {

        var currentBreakpoint = Unison.fetch.now();

        // Init drilldown on small screen
        $.app.menu.drillDownMenu(currentBreakpoint.name);

        // return false;
    });

    $(document).on('click', '.main-menu-footer .footer-toggle', function(e) {
        e.preventDefault();
        $(this).find('i').toggleClass('pe-is-i-angle-down pe-is-i-angle-up');
        $('.main-menu-footer').toggleClass('footer-close footer-open');
        return false;
    });

    // Add Children Class
    $('.navigation').find('li').has('ul').addClass('has-sub');

    $('.carousel').carousel({
      interval: 2000
    });

    // Page full screen
    $('.nav-link-expand').on('click', function(e) {
        if (typeof screenfull != 'undefined'){
            if (screenfull.enabled) {
                screenfull.toggle();
            }
        }
    });
    if (typeof screenfull != 'undefined'){
        if (screenfull.enabled) {
            $(document).on(screenfull.raw.fullscreenchange, function(){
                if(screenfull.isFullscreen){
                    $('.nav-link-expand').find('i').toggleClass('ft-minimize ft-maximize');
                }
                else{
                    $('.nav-link-expand').find('i').toggleClass('ft-maximize ft-minimize');
                }
            });
        }
    }

    $(document).on('click', '.mega-dropdown-menu', function(e) {
        e.stopPropagation();
    });

    $(document).ready(function(){

        /**********************************
        *   Form Wizard Step Icon
        **********************************/
        $('.step-icon').each(function(){
            var $this = $(this);
            if($this.siblings('span.step').length > 0){
                $this.siblings('span.step').empty();
                $(this).appendTo($(this).siblings('span.step'));
            }
        });
    });

    // Update manual scroller when window is resized
    $(window).resize(function() {
        $.app.menu.manualScroller.updateHeight();
    });

    $('#sidebar-page-navigation').on('click', 'a.nav-link', function(e){
        e.preventDefault();
        e.stopPropagation();
        var $this = $(this),
        href= $this.attr('href');
        var offset = $(href).offset();
        var scrollto = offset.top - 80; // minus fixed header height
        $('html, body').animate({scrollTop:scrollto}, 0);
        setTimeout(function(){
            $this.parent('.nav-item').siblings('.nav-item').children('.nav-link').removeClass('active');
            $this.addClass('active');
        }, 100);
    });

})(window, document, jQuery);
/*
 2019 Jason Mulligan <jason.mulligan@avoidwork.com>
 @version 4.1.2
*/
"use strict";!function(e){var h=/^(b|B)$/,M={iec:{bits:["b","Kib","Mib","Gib","Tib","Pib","Eib","Zib","Yib"],bytes:["B","KiB","MiB","GiB","TiB","PiB","EiB","ZiB","YiB"]},jedec:{bits:["b","Kb","Mb","Gb","Tb","Pb","Eb","Zb","Yb"],bytes:["B","KB","MB","GB","TB","PB","EB","ZB","YB"]}},x={iec:["","kibi","mebi","gibi","tebi","pebi","exbi","zebi","yobi"],jedec:["","kilo","mega","giga","tera","peta","exa","zetta","yotta"]};function t(e){var i,t,o,n,b,r,a,l,s,d,u,f,c,p,B=1<arguments.length&&void 0!==arguments[1]?arguments[1]:{},y=[],g=0,v=void 0,m=void 0;if(isNaN(e))throw new TypeError("Invalid number");return t=!0===B.bits,d=!0===B.unix,i=B.base||2,s=void 0!==B.round?B.round:d?1:2,r=void 0!==B.locale?B.locale:"",u=void 0!==B.separator?B.separator:"",f=void 0!==B.spacer?B.spacer:d?"":" ",p=B.symbols||{},c=2===i&&B.standard||"jedec",l=B.output||"string",n=!0===B.fullform,b=B.fullforms instanceof Array?B.fullforms:[],v=void 0!==B.exponent?B.exponent:-1,o=2<i?1e3:1024,(a=(m=Number(e))<0)&&(m=-m),(-1===v||isNaN(v))&&(v=Math.floor(Math.log(m)/Math.log(o)))<0&&(v=0),8<v&&(v=8),"exponent"===l?v:(0===m?(y[0]=0,y[1]=d?"":M[c][t?"bits":"bytes"][v]):(g=m/(2===i?Math.pow(2,10*v):Math.pow(1e3,v)),t&&o<=(g*=8)&&v<8&&(g/=o,v++),y[0]=Number(g.toFixed(0<v?s:0)),y[1]=10===i&&1===v?t?"kb":"kB":M[c][t?"bits":"bytes"][v],d&&(y[1]="jedec"===c?y[1].charAt(0):0<v?y[1].replace(/B$/,""):y[1],h.test(y[1])&&(y[0]=Math.floor(y[0]),y[1]=""))),a&&(y[0]=-y[0]),y[1]=p[y[1]]||y[1],!0===r?y[0]=y[0].toLocaleString():0<r.length?y[0]=y[0].toLocaleString(r):0<u.length&&(y[0]=y[0].toString().replace(".",u)),"array"===l?y:(n&&(y[1]=b[v]?b[v]:x[c][v]+(t?"bit":"byte")+(1===y[0]?"":"s")),"object"===l?{value:y[0],symbol:y[1]}:y.join(f)))}t.partial=function(i){return function(e){return t(e,i)}},"undefined"!=typeof exports?module.exports=t:"function"==typeof define&&void 0!==define.amd?define(function(){return t}):e.filesize=t}("undefined"!=typeof window?window:global);
//# sourceMappingURL=filesize.min.js.map