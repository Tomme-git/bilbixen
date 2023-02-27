<?php

include 'core/init.php';

if (session_destroy()) {
    header("Location: index.php");
}
