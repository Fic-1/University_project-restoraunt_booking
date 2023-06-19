<?php
session_start();
include_once("funkcije.php");
$_SESSION = [];
session_unset();
session_destroy();
header("Location: index.php?odjava=uspjesno");