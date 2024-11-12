<?php
session_start();
if(!isset($_SESSION['username'])){
    header("location: LoginPage.php?error=Need to login first");
    exit();
}

include "DBConnect.php";

$tableName = $_GET['tableName'];
$id = $_GET['id'];

$sql = "DELETE FROM $tableName WHERE id=$id";
if ($conn->query($sql) === TRUE)
    echo '<script>alert("刪除成功");window.location.href = "EditPage.php";</script>';
else
    echo $sql. '<script>alert("刪除失敗");window.location.href = "EditPage.php";</script>';
?>