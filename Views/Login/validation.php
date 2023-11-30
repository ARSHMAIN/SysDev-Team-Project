<?php
include_once 'Models/User.php';
include_once 'Models/Role.php';
$user = User::getUserByCredentials($_POST['email'], md5($_POST['password']));
if (!$user) header("Location: /?controller=login&action=login&error=incorrectCredentials");
if (!$user->getRoleId()) header("Location: /?controller=login&action=login");
session_start();
$_SESSION["userRole"] = $user->getRoleId();
$_SESSION["user_id"] = $user->getUserId();
header("Location: /?controller=home&action=home");