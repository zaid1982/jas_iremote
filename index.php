<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['menu_list'])) {
    echo '<script> parent.location="login.php"; </script>';
    exit;
}
$arrMenuList = $_SESSION['menu_list'];    
if (isset($_POST['mid']) && isset($_POST['m2id']) && isset($_POST['m3id'])) {
    $mid = $_POST['mid'];
    $m2id = $_POST['m2id'];
    $m3id = $_POST['m3id'];
    if ($m2id == '0')
        $pg_address = $arrMenuList[$mid]['userMenu_page'];
    else if ($m3id == '0')
        $pg_address = $arrMenuList[$mid]['sub_menu'][$m2id]['userMenu_page'];
    else
        $pg_address = $arrMenuList[$mid]['sub_menu'][$m2id]['sub_menu'][$m3id]['userMenu_page'];
} else {
    echo '<script> parent.location="login.php"; </script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en-us">
    <head>
        <style> 
/*            svg {
                display:block;
                width:90%;
                height:1%;  fix webkit 
                overflow:hidden; fix IE 
            }*/ 
        </style>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

        <title> iRemote System</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Basic Styles -->
        <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/animate.css">

        <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
        <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production-plugins.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-skins.min.css">

        <!-- SmartAdmin RTL Support  -->
        <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-rtl.min.css">

        <!-- We recommend you use "your_style.css" to override SmartAdmin
             specific styles this will also ensure you retrain your customization with each SmartAdmin update. -->
        <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">

        <!-- FAVICONS -->
        <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
        <link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon">-->

        <!-- GOOGLE FONT -->
        <!--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">-->
        <link rel="stylesheet" type="text/css" media="screen" href="css/font-googleapis.css">
        
        <!-- Specifying a Webpage Icon for Web Clip
                 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
        <link rel="apple-touch-icon" href="img/splash/sptouch-icon-iphone.png">
        <link rel="apple-touch-icon" sizes="76x76" href="img/splash/touch-icon-ipad.png">
        <link rel="apple-touch-icon" sizes="120x120" href="img/splash/touch-icon-iphone-retina.png">
        <link rel="apple-touch-icon" sizes="152x152" href="img/splash/touch-icon-ipad-retina.png">

        <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <!-- Startup image for web apps -->
        <link rel="apple-touch-startup-image" href="img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
        <link rel="apple-touch-startup-image" href="img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
        <link rel="apple-touch-startup-image" href="img/splash/iphone.png" media="screen and (max-device-width: 320px)">

    </head>

    <!--

    TABLE OF CONTENTS.

    Use search to find needed section.

    ===================================================================

    |  01. #CSS Links                |  all CSS links and file paths  |
    |  02. #FAVICONS                 |  Favicon links and file paths  |
    |  03. #GOOGLE FONT              |  Google font link              |
    |  04. #APP SCREEN / ICONS       |  app icons, screen backdrops   |
    |  05. #BODY                     |  body tag                      |
    |  06. #HEADER                   |  header tag                    |
    |  07. #PROJECTS                 |  project lists                 |
    |  08. #TOGGLE LAYOUT BUTTONS    |  layout buttons and actions    |
    |  09. #MOBILE                   |  mobile view dropdown          |
    |  10. #SEARCH                   |  search field                  |
    |  11. #NAVIGATION               |  left panel & navigation       |
    |  12. #RIGHT PANEL              |  right panel userlist          |
    |  13. #MAIN PANEL               |  main panel                    |
    |  14. #MAIN CONTENT             |  content holder                |
    |  15. #PAGE FOOTER              |  page footer                   |
    |  16. #SHORTCUT AREA            |  dropdown shortcuts area       |
    |  17. #PLUGINS                  |  all scripts and plugins       |

    ===================================================================

    -->

    <!-- #BODY -->
    <!-- Possible Classes

            * 'smart-style-{SKIN#}'
            * 'smart-rtl'         - Switch theme mode to RTL
            * 'menu-on-top'       - Switch to top navigation (no DOM change required)
            * 'no-menu'			  - Hides the menu completely
            * 'hidden-menu'       - Hides the main menu but still accessable by hovering over left edge
            * 'fixed-header'      - Fixes the header
            * 'fixed-navigation'  - Fixes the main menu
            * 'fixed-ribbon'      - Fixes breadcrumb
            * 'fixed-page-footer' - Fixes footer
            * 'container'         - boxed layout mode (non-responsive: will not work with fixed-navigation & fixed-ribbon)
    -->
    <body class="fixed-navigation fixed-header fixed-ribbon">

        <!-- HEADER -->
        <header id="header">
            <div id="logo-group">

                <!-- PLACE YOUR LOGO HERE -->
                <span id="logo"> <h6>iRemote System </h6> </span>
                <!-- END LOGO PLACEHOLDER -->

                <!-- Note: The activity badge color changes when clicked and resets the number to 0
                Suggestion: You may want to set a flag when this happens to tick off all checked messages / notifications -->
                <span id="activity" class="activity-dropdown"> <i class="fa fa-tasks"></i> <b class="badge bg-color-red" id="total_notification"> <span class="total_notification"></span> </b> </span>

                <!-- AJAX-DROPDOWN : control this dropdown height, look and feel from the LESS variable file -->
                <div class="ajax-dropdown">

                    <!-- the ID links are fetched via AJAX to the ajax container "ajax-notifications" -->
                    <div class="btn-group btn-group-justified" data-toggle="buttons">
                        <label class="btn btn-default active" id="label_notify_task" onclick="$('#content-notify-info').hide(); $('#content-notify-task').show();">
                            <input type="radio" name="activity">
                            Tasks (<span class="total_notification"></span>) </label>
                        <label class="btn btn-default" id="label_notify_info" onclick="$('#content-notify-task').hide(); $('#content-notify-info').show();">
                            <input type="radio" name="activity">
                            Notification </label>
                    </div>

                    <!-- notification content -->
                    <div class="ajax-notifications custom-scroll">
                        <ul class="notification-body" id="content-notify-task"></ul>
                        <ul class="notification-body" id="content-notify-info">                            
                            <li>
                                <span class="padding-10">
                                    <em class="badge padding-5 no-border-radius bg-color-red pull-left margin-right-5">
                                        <i class="fa fa-database fa-fw fa-2x"></i>
                                    </em>
                                    <span>
                                        <a href="javascript:void(0);" class="display-normal"><strong>Data Pooling</strong></a>: <span id="lbl_notify_total_fail_pooling"></span> premise's stacks fail to complete data pooling since yesterday
                                        <br><span class="pull-right font-xs text-muted"><i><?=date("F j, Y", time() - 60 * 60 * 24) ?></i></span>
                                    </span>
                                </span>
                            </li>
                            <li>
                                <span class="padding-10">
                                    <em class="badge padding-5 no-border-radius bg-color-orangeDark pull-left margin-right-5">
                                        <i class="fa fa-warning fa-fw fa-2x"></i>
                                    </em>
                                    <span>
                                        <a href="javascript:void(0);" class="display-normal"><strong>Data Compliance</strong></a>: <span id="lbl_notify_total_fail_compliance"></span> premise's stacks fail to comply since yesterday
                                        <br><span class="pull-right font-xs text-muted"><i><?=date("F j, Y", time() - 60 * 60 * 24) ?></i></span>
                                    </span>
                                </span>
                            </li>
                            <li id="li_notify_application_grouped"></li>
<!--                            <li>
                                <span class="padding-10 unread">
                                    <em class="badge padding-5 no-border-radius bg-color-green pull-left margin-right-5">
                                        <i class="fa fa-check fa-fw fa-2x"></i>
                                    </em>
                                    <span>
                                        19 CEMS / PEMS Applications are late than 15 process days - <a href="javascript:void(0);" class="display-normal">Click here</a>
                                        <br>
                                        <span class="pull-right font-xs text-muted"><i>1 day ago...</i></span>
                                    </span>
                                </span>
                            </li>
                            <li>
                                <span class="padding-10">
                                    <em class="badge padding-5 no-border-radius bg-color-teal pull-left margin-right-5">
                                        <i class="fa fa-check fa-fw fa-2x"></i>
                                    </em>
                                    <span>
                                        3 Consultants Registration Application are late than 15 process days - <a href="javascript:void(0);" class="display-normal">Click here</a>
                                        <br>
                                        <span class="pull-right font-xs text-muted"><i>1 day ago...</i></span>
                                    </span>
                                </span>
                            </li>-->
                        </ul>
                    </div>
                    <!-- end notification content -->

                    <!-- footer: refresh area 12/12/2013 9:43AM -->
                    <span> Last updated on : &nbsp;&nbsp;<i><span id="lbl_notify_current_time"></span></i>
                        <button type="button" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Loading..." class="btn btn-xs btn-default pull-right" onclick="f_main_alert();">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </span>
                    <!-- end footer -->

                </div>
                <!-- END AJAX-DROPDOWN -->
            </div>

            <!-- pulled right: nav area -->
            <div class="pull-right">

                <!-- collapse menu button -->
                <div id="hide-menu" class="btn-header pull-right">
                    <span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
                </div>
                <!-- end collapse menu -->

                <!-- logout button -->
                <div id="logout" class="btn-header transparent pull-right">
                    <span> <a href="login.php" title="Sign Out" data-action="userLogout" data-logout-msg="Are you sure you want to log out from this system?"><i class="fa fa-sign-out"></i></a> </span>
                </div>
                <!-- end logout button -->

                <!-- fullscreen button -->
                <div id="fullscreen" class="btn-header transparent pull-right">
                    <span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
                </div>
                <!-- end fullscreen button -->

                <div id="ss" class="btn-header pull-right">
                    <span> <a href="javascript:void(0);" title="User Profile" onclick="f_load_profile(1,<?=$_SESSION['user_id']?>,'idx');"><i class="fa fa-user"></i></a> </span>
                </div>

<!--                <ul class="header-dropdown-list hidden-xs">
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="img/blank.gif" class="flag flag-gb" alt="English"> <span> English </span> <i class="fa fa-angle-down"></i> </a>
                        <ul class="dropdown-menu pull-right">
                            <li class="active">
                                <a href="javascript:void(0);"><img src="img/blank.gif" class="flag flag-gb" alt="English"> English</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"><img src="img/blank.gif" class="flag flag-my" alt="Bahasa Melayu"> Bahasa Melayu</a>
                            </li>
                        </ul>
                    </li>
                </ul>-->

            </div>
            <!-- end pulled right: nav area -->

        </header>
        <!-- END HEADER -->

        <!-- Left panel : Navigation area -->
        <!-- Note: This width of the aside area can be adjusted through LESS variables -->
        <aside id="left-panel">

            <!-- User info -->
            <div class="login-info">
                <span> <!-- User image size is adjusted inside CSS, it should stay as it -->

                    <a>
                        <span>
                            <span id="l_login_name"><?= $_SESSION["login_name"] ?></span>
                        </span>
                    </a>

                </span>
            </div>
            <!-- end user info -->

            <!-- NAVIGATION : This navigation is also responsive-->
            <nav>
                <!--
                NOTE: Notice the gaps after each icon usage <i></i>..
                Please note that these links work a bit different than
                traditional href="" links. See documentation for details.
                -->
                <ul>
                    <?php
                    foreach ($arrMenuList as $menu_id => $menuList) {
                        $pmenu_active = $menu_id == $mid ? 'class="active"' : '';
                        echo ('<li '.$pmenu_active.'>');
                        if (!empty($menuList['sub_menu'])) {
                            echo ('<a href="#" title="'.$menuList['menu_name'].'"><i class="fa fa-lg fa-fw '.$menuList['userMenu_icons'].'"></i><span class="menu-item-parent">'.$menuList['menu_name'].'</span></a>');
                            echo ('<ul>');
                            foreach ($menuList['sub_menu'] as $menu2nd_id => $menu2ndList) {
                                $pmenu_active = $menu2nd_id == $m2id ? 'class="active"' : '';
                                if (!empty($menu2ndList['sub_menu'])) {
                                    echo ('<li '.$pmenu_active.'><a href="#" title="'.$menu2ndList['menu2nd_name'].'">'.$menu2ndList['menu2nd_name'].'</a>');
                                    echo ('<ul>');
                                    foreach ($menu2ndList['sub_menu'] as $menu3rd_id => $menu3rdList) {
                                        $pmenu_active = $menu3rd_id == $m3id ? 'class="active"' : '';
                                        echo ('<li '.$pmenu_active.'><a href="#" title="'.$menu3rdList['menu3rd_name'].'" onclick="f_menu_redirect('.$menu_id.','.$menu2nd_id.','.$menu3rd_id.');">'.$menu3rdList['menu3rd_name'].'</a></li>');
                                    }
                                    echo ('</ul>');
                                } else
                                    echo ('<li '.$pmenu_active.'><a href="#" title="'.$menu2ndList['menu2nd_name'].'" onclick="f_menu_redirect('.$menu_id.','.$menu2nd_id.',0);">'.$menu2ndList['menu2nd_name'].'</a>');
                                echo ('</li>');
                            }
                            echo ('</ul>');
                        } else
                            echo ('<a href="#" title="'.$menuList['menu_name'].'" onclick="f_menu_redirect('.$menu_id.',0,0);"><i class="fa fa-lg fa-fw '.$menuList['userMenu_icons'].'"></i><span class="menu-item-parent">'.$menuList['menu_name'].'</span></a>');
                        echo ('</li>');
                    }
                    ?>
                </ul>
            </nav>

            <span class="minifyme" data-action="minifyMenu">
                <i class="fa fa-arrow-circle-left hit"></i>
            </span>

            <form action="index.php" id="form_menu" method="post">
                <input type="hidden" name="mid" id="mid" value="<?= $menu_id ?>">
                <input type="hidden" name="m2id" id="m2id" value="<?= $menu2nd_id ?>">
                <input type="hidden" name="m3id" id="m3id" value="<?= $menu3rd_id ?>">
                <input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['user_id'] ?>">
                <input type="hidden" name="user_type" id="user_type" value="<?= $_SESSION['user_type'] ?>">
                <input type="hidden" name="index_wfGroup_id" id="index_wfGroup_id" value="">
            </form>

        </aside>
        <!-- END NAVIGATION -->

        <!-- MAIN PANEL -->
        <div id="main" role="main">

            <input type="hidden" id="login_name" value="<?= $_SESSION["login_name"] ?>" />
            <?php include 'view/'.$pg_address.'.php'; ?>

        </div>
        <!-- END MAIN PANEL -->

        <!-- PAGE FOOTER -->
        <div class="page-footer">
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <span class="txt-color-white">JAS <span class="hidden-xs"> - CEMS 2.0</span> © 2016</span>
                </div>
            </div>
        </div>
        <!-- END PAGE FOOTER -->

        <?php
        include 'view/modal/modal_waiting.php';
        include 'view/modal/modal_profile.php';
        include 'view/modal/modal_pdf.php';
        ?>

        <!-- SHORTCUT AREA : With large tiles (activated via clicking user name tag)
        Note: These tiles are completely responsive,
        you can add as many as you like
        -->
        <div id="shortcut">
            <ul>
                <li>
                    <a href="inbox.html" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-envelope fa-4x"></i> <span>Mail <span class="label pull-right bg-color-darken">14</span></span> </span> </a>
                </li>
                <li>
                    <a href="calendar.html" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i class="fa fa-calendar fa-4x"></i> <span>Calendar</span> </span> </a>
                </li>
                <li>
                    <a href="gmap-xml.html" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-map-marker fa-4x"></i> <span>Maps</span> </span> </a>
                </li>
                <li>
                    <a href="invoice.html" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-book fa-4x"></i> <span>Invoice <span class="label pull-right bg-color-darken">99</span></span> </span> </a>
                </li>
                <li>
                    <a href="gallery.html" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-picture-o fa-4x"></i> <span>Gallery </span> </span> </a>
                </li>
                <li>
                    <a href="profile.html" class="jarvismetro-tile big-cubes selected bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>My Profile </span> </span> </a>
                </li>
            </ul>
        </div>
        <!-- END SHORTCUT AREA -->

        <!--================================================== -->

        <!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
        <script data-pace-options='{ "restartOnRequestAfter": true }' src="js/plugin/pace/pace.min.js"></script>

        <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
<!--        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script> if (!window.jQuery) {
                document.write('<script src="js/libs/jquery-2.1.1.min.js"><\/script>');
            }</script>

        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script> if (!window.jQuery.ui) {
                document.write('<script src="js/libs/jquery-ui-1.10.3.min.js"><\/script>');
            }</script>-->
        
        <script src="js/libs/jquery-2.1.1.min.js"></script>
        <script src="js/libs/jquery-ui-1.10.3.min.js"></script>

        <!-- IMPORTANT: APP CONFIG -->
        <script src="js/app.config.js"></script>

        <!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
        <script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script>

        <!-- BOOTSTRAP JS -->
        <script src="js/bootstrap/bootstrap.min.js"></script>

        <!-- CUSTOM NOTIFICATION -->
        <script src="js/notification/SmartNotification.min.js"></script>

        <!-- JARVIS WIDGETS -->
        <script src="js/smartwidgets/jarvis.widget.min.js"></script>

        <!-- EASY PIE CHARTS -->
        <script src="js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

        <!-- SPARKLINES -->
        <script src="js/plugin/sparkline/jquery.sparkline.min.js"></script>

        <!-- JQUERY VALIDATE -->
        <script src="js/plugin/jquery-validate/jquery.validate.min.js"></script>

        <!-- JQUERY MASKED INPUT -->
        <script src="js/plugin/masked-input/jquery.maskedinput.min.js"></script>

        <!-- JQUERY SELECT2 INPUT -->
        <script src="js/plugin/select2/select2.min.js"></script>

        <!-- JQUERY UI + Bootstrap Slider -->
        <script src="js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

        <!-- browser msie issue fix -->
        <script src="js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

        <!-- FastClick: For mobile devices -->
        <script src="js/plugin/fastclick/fastclick.min.js"></script>

        <!--[if IE 8]>

        <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

        <![endif]-->

        <!-- MAIN APP JS FILE -->
        <script src="js/app.min.js"></script>

        <!-- Voice command : plugin -->
        <script src="js/speech/voicecommand.min.js"></script>

        <!-- SmartChat UI : plugin -->
        <script src="js/smart-chat-ui/smart.chat.ui.min.js"></script>
        <script src="js/smart-chat-ui/smart.chat.manager.min.js"></script>

        <!-- PAGE RELATED PLUGIN(S) -->
        <script src="js/plugin/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
        <script src="js/plugin/datatables/jquery.dataTables.min.js"></script>
        <script src="js/plugin/datatables/dataTables.colVis.min.js"></script>
        <script src="js/plugin/datatables/dataTables.tableTools.min.js"></script>
        <script src="js/plugin/datatables/dataTables.bootstrap.min.js"></script>
        <script src="js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

        <script src="js/plugin/bootstrapvalidator/bootstrapValidator.min.js"></script>
        <script src="js/plugin/fuelux/wizard/wizard.min.js"></script>
        <script src="js/plugin/summernote/summernote.min.js"></script>
        
<!--        <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>-->
        <script type="text/javascript" src="js/plugin/moment/moment.min.js"></script>
        <script type="text/javascript" src="js/plugin/daterangepicker/daterangepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="js/plugin/daterangepicker/daterangepicker.css" />

        <script src="library/general.js"></script>

        <?php
        include 'view/js/j_modal_profile.php';
        include 'view/js/j_'.$pg_address.'.php';
        include 'view/js/j_modal_pdf.php';
        ?>

        <script type="text/javascript">
            
            var IDLE_TIMEOUT = 900; //seconds
            var _idleSecondsCounter = 0;
            document.onclick = function () {
                _idleSecondsCounter = 0;
            };
            document.onmousemove = function () {
                _idleSecondsCounter = 0;
            };
            document.onkeypress = function () {
                _idleSecondsCounter = 0;
            };
            var general_interval = window.setInterval(CheckIdleTime, 10000);
            function CheckIdleTime() {
                _idleSecondsCounter++;
                var oPanel = document.getElementById("SecondsUntilExpire");
                if (oPanel)
                    oPanel.innerHTML = (IDLE_TIMEOUT - _idleSecondsCounter) + "";
                if (_idleSecondsCounter >= IDLE_TIMEOUT) {
                    clearInterval(general_interval);
                    $.SmartMessageBox({
                        title : "<i class='fa fa-sign-out'></i> Session Timeout!",
                        content : "You have reach inactivity timeout. Please login back to the system.",
                        buttons : '[Login Back]'
                    }, function(ButtonPressed) {
                        if (ButtonPressed === "Login Back") {            
                            document.location.href = "login.php";
                        }
                    });
                }
            }

            runAllForms();
            //pageSetUp();
            /*
             * CONVERT DIALOG TITLE TO HTML
             * REF: http://stackoverflow.com/questions/14488774/using-html-in-a-dialogs-title-in-jquery-ui-1-10
             */
            $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
                _title: function (title) {
                    if (!this.options.title) {
                        title.html("&#160;");
                    } else {
                        title.html(this.options.title);
                    }
                }
            }));

            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };

            $(document).ready(function () {
                $('#content-notify-info').hide();
                f_main_alert();
            });

            function f_menu_redirect(menu_id, menu2nd_id, menu3rd_id) {
                $('#mid').val(menu_id);
                $('#m2id').val(menu2nd_id);
                $('#m3id').val(menu3rd_id);
                $('#form_menu').submit();
            }
            
            function f_main_alert() {
                var wf_group = f_get_general_info('wf_group_user', {user_id:$('#user_id').val(), wfGroupUser_status:'1', wfGroupUser_isMain:'1'});
                $('#index_wfGroup_id').val(wf_group.wfGroup_id);                
                $('#content-notify-task').html('');        
                $('.total_notification').html(0);
                f_submit_normal('get_notify_task', {wfGroup_id:$('#index_wfGroup_id').val()}, 'p_login');
                if (result_submit != '1') {
                    $.each(result_submit, function(u){
                        var stack_id = ''; 
                        stack_id = result_submit[u].indAll_stackNo != null ? '(Stack ID: '+result_submit[u].indAll_stackNo+')':'';
                        var html = '<li><span class="padding-10"><em class="badge padding-5 no-border-radius bg-color-'+result_submit[u].wfFlow_color+' txt-color-white pull-left margin-right-5">' + 
                            '<i class="fa fa-'+result_submit[u].wfFlow_icon+' fa-fw fa-2x"></i></em>' +
                            '<span class="text-muted">'+result_submit[u].wfFlow_desc+' - '+result_submit[u].wfTaskType_name+'</span><br><strong>'+replaceNull(result_submit[u].wfGroup_name, '-')+'</strong> '+stack_id+
                            '<span class="pull-right font-xs text-muted"><i>'+convert_date_to_format(result_submit[u].wfTask_timeCreated)+'</i></span></span></span></li>';
                        $('#content-notify-task').append(html);
                    });
                    $('.total_notification').html(result_submit.length);
                }
                if ($('#user_type').val() == '1') {
                    f_submit_normal('get_notify_info', {wfGroup_id:$('#index_wfGroup_id').val()}, 'p_login');
                    $('#lbl_notify_total_fail_pooling').html(formattedNumber(result_submit.total_fail_pooling));
                    $('#lbl_notify_total_fail_compliance').html(formattedNumber(result_submit.total_fail_compliance));
                    $('#li_notify_application_grouped').html('');    
                    $.each(result_submit.total_application_grouped, function(u){
                        var html = '<span class="padding-10"><em class="badge padding-5 no-border-radius bg-color-'+result_submit.total_application_grouped[u].wfFlow_color+' pull-left margin-right-5">' +
                                '<i class="fa fa-'+result_submit.total_application_grouped[u].wfFlow_icon+' fa-fw fa-2x"></i></em>' +
                                '<span><a href="javascript:void(0);" class="display-normal"><strong>'+result_submit.total_application_grouped[u].total+' '+result_submit.total_application_grouped[u].wfFlow_desc+'</strong></a> application submitted this month' +
                                    '<br><span class="pull-right font-xs text-muted"><i>'+moment().format('MMMM YYYY');+'</i></span>' +
                                '</span>' +
                            '</span>';
                        $('#li_notify_application_grouped').append(html); 
                    });
                } else if ($('#user_type').val() == '2') {
                    $('#label_notify_info').hide();
                }
                $('#lbl_notify_current_time').html(moment().format('MMM D, YYYY h:mm:ss A'));
                // link dataNew.column('1:visible').search('Amin').draw();
            } 

        </script>

    </body>

</html>