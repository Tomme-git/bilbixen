<?php

require_once ('core/init.php');

$db = new DB();

$catid = $_GET['cid'];
$carsid = $_GET['carsid'];
$comid = $_GET['commentid'];

//$update = $db->update("cms_category", $data, "id=$id");

if ($db->delete("bb_category", "id=$catid")) {
    header("location: admin.php");
} elseif ($db->delete("bb_cars", "id=$carsid")) {
    header("location: edit.php");
} elseif ($db->delete("bb_comments", "id=$comid")) {
    header("location: comments.php");
} else {
    header("Location: admin.php");
}
