<!doctype html>
<html>
<head>
    <title>HUGE</title>
    <!-- META -->
    <meta charset="utf-8">
    <!-- send empty favicon fallback to prevent user's browser hitting the server for lots of favicon requests resulting in 404s -->
    <link rel="icon" href="data:;base64,=">
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/style.css" />

    <!-- DataTables stylesheet for table design-->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.min.css">
</head>
<body>
    <!-- wrapper, to center website -->
    <div class="wrapper">

        <!-- logo -->
        <div class="logo"></div>

        <!-- navigation -->
        <ul class="navigation">
            <li <?php if (View::checkForActiveController($filename, "index")) { echo ' class="active" '; } ?> >
                <a href="<?php echo Config::get('URL'); ?>index/index">Index</a>
            </li>
            <li <?php if (View::checkForActiveController($filename, "profile")) { echo ' class="active" '; } ?> >
                <a href="<?php echo Config::get('URL'); ?>profile/index">Profiles</a>
            </li>
            <?php if (Session::userIsLoggedIn()) { ?>
                <li <?php if (View::checkForActiveController($filename, "dashboard")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>dashboard/index">Dashboard</a>
                </li>
                <li <?php if (View::checkForActiveController($filename, "note")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>note/index">My Notes</a>
                </li>
                <?php $unread_count = MessengerModel::getUnreadMessageCount(Session::get('user_id')); ?>
                <li <?php if (View::checkForActiveController($filename, "messenger")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>messenger/index">
                        Messenger
                        <?php if ($unread_count > 0) { ?>
                            <span style="background:red; color:white; border-radius:50%; padding:2px 6px; margin-left:4px; font-size:11px;">
                                <?php echo $unread_count; ?>
                            </span>
                        <?php } ?>
                    </a>
                </li>
                <li <?php if (View::checkForActiveController($filename, "gallery")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>gallery/index">Gallery</a>
                </li>
                <li <?php if (View::checkForActiveController($filename, "training") || View::checkForActiveController($filename, "exercise") || View::checkForActiveController($filename, "calendar")) { echo ' class="active" '; } ?> >
                    <a href="#">Fitness Tracker</a>
                    <ul class="navigation-submenu">
                        <li>
                            <a href="<?php echo Config::get('URL'); ?>training/index">Training</a>
                        </li>
                        <li>
                            <a href="<?php echo Config::get('URL'); ?>exercise/index">Übungen</a>
                        </li>
                        <li>
                            <a href="<?php echo Config::get('URL'); ?>calendar/index">Kalender</a>
                        </li>
                    </ul>
                </li>


            <?php } else { ?>
                <!-- for not logged in users -->
                <li <?php if (View::checkForActiveControllerAndAction($filename, "login/index")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>login/index">Login</a>
                </li>
                <!--Took out the register link for others as only admins should see it-->
            <?php } ?>
        </ul>

        <!-- my account -->
        <ul class="navigation right">
        <?php if (Session::userIsLoggedIn()) : ?>
            <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                <a href="<?php echo Config::get('URL'); ?>user/index">My Account</a>
                <ul class="navigation-submenu">
                    <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>user/changeUserRole">Change account type</a>
                    </li>
                    <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>user/editAvatar">Edit your avatar</a>
                    </li>
                    <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>user/editusername">Edit my username</a>
                    </li>
                    <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>user/edituseremail">Edit my email</a>
                    </li>
                    <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>user/changePassword">Change Password</a>
                    </li>
                    <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>login/logout">Logout</a>
                    </li>
                </ul>
            </li>
            <?php if (Session::get("user_account_type") == 7) : ?>
                <!--Register is now only visible for admins-->
                <li <?php if (View::checkForActiveController($filename, "register")) {
                        echo ' class="active" ';
                } ?> >
                    <a href="<?php echo Config::get('URL'); ?>register/index">Register</a>
                 </li>
                
                <li <?php if (View::checkForActiveController($filename, "admin")) {
                    echo ' class="active" ';
                } ?> >
                    <a href="<?php echo Config::get('URL'); ?>admin/">Admin</a>
                </li>
            <?php endif; ?>
        <?php endif; ?>
        </ul>