<?php
// /WEBKIP/formaban/logout.php

session_start();

// Hapus semua session
$_SESSION = [];
session_destroy();

// Redirect ke login
header("Location: login.php");
exit;
