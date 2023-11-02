<?php
// DATABASE
include "../../database/database.php";

// CLASS
include "../class/member.php";

$path = ( isset($_GET["path"]) && $_GET["path"] != "") ? $_GET["path"] : "";

$member = new Member($conn);
$member -> logout($path);