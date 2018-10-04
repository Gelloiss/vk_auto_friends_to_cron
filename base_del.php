<?
include 'db.php';
include 'path.php';

$id = $_GET['id'];
$mysqli->query("DELETE FROM `tokens` WHERE `id`='$id'");

header('location: '.$path.'/base.php');