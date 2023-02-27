<?php
$objCon = new mysqli("localhost", "dbuser", "dbpw", "db");

if ($objCon->connect_errno) {
    die('can not connect (' . $objCon->connect_errno . ')'.$objCon->connect_error);
}
//echo "connected successfully";
$objCon->set_charset("utf8");