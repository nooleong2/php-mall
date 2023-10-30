<?php
// DATABASE
include "../../database/database.php";

// CLASS
include "../class/member.php";

$member = new Member($conn);
$member -> logout();