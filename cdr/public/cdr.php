<?php

/*
 * The mod json cdr request
 * author: typefo
 * e-mail: typefo@qq.com
 */

define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_USER', 'root');
define('DB_PASS', '123456');
define('DB_NAME', 'bitcc');

try {

    // Initialize mysql database
    $db = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);

    // get post json data
    $data = json_decode(file_get_contents('php://input'), true);
    if ($data) {
        $rep = $data['variables'];
        $uuid = $rep['uuid'];
        $caller = $rep['sip_from_user'];
        $called = $rep['sip_to_user'];
        $duration = intval($rep['billsec']);
        $file = date('Y/m/d/', intval($rep['start_epoch'])) . $caller . '-' . $called . '-' . $uuid . '.wav';
        $create_time = urldecode($rep['start_stamp']);

        $db->query("INSERT INTO cdr(caller, called, duration, file, create_time) values('$caller', '$called', $duration, '$file', '$create_time')");
    } else {
        error_log('php parse cdr application/json data failure', 0);
    }

    // close mysql connection
    $db = null;
} catch (PDOException $e) {
    error_log($e->getMessage(), 0);
}