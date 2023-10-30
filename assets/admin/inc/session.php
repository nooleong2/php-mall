<?php
session_start();

$session_id = ( isset($_SESSION["session_id"]) && $_SESSION["session_id"] != "" ) ? $_SESSION["session_id"] : "";
$session_role = ( isset($_SESSION["session_role"]) && $_SESSION["session_role"] != "" ) ? $_SESSION["session_role"] : "";