<?php
$servername = "localhost"; // 서버 주소
$username = "root"; // DB 아이디
$password = ""; // DB 비밀번호
$databasename = "alcohol"; // 사용 할 DB

try {
    $conn = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
    $conn -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $conn -> setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "<script>alert('Database Connection Success!!');</script>";
} catch (PDOException $e) {
    echo "<p>".$e -> getMessage()."</p>";
    exit;
}
