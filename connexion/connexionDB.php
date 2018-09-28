<?php
define('DB_NAME', 'starzcloexerp');
//define('DB_USER', 'starzcloexerp');
//define('DB_PASS', 'ERP2018nn');
//define('DB_HOST', 'starzcloexerp.mysql.db');

$link = mysql_connect('starzcloexerp.mysql.db', 'starzcloexerp', 'ERP2018nn');

if (!$link) {
    dir('There was a problem when trying to connect to the host. Please contact Tech Support. Error: ' . mysql_error());
}

$db_selected = mysql_select_db('starzcloexerp', $link);

if (!$link) {
    dir('There was a problem when trying to connect to the database. Please contact Tech Support. Error: ' . mysql_error());
}
?>