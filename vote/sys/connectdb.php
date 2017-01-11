<?php
  $url = 'localhost';
  $user = 'root';
  $pass = 'q1w2e3r4t5';
  $db = 'monograph';
  date_default_timezone_set("Asia/Taipei");
  $connect = new mysqli($url, $user, $pass, $db);
  if ($connect->connect_error) {
      die('Connect Error (' . $connect->connect_errno . ') ' . $connect->connect_error);
  }
  $connect->query("SET NAMES utf8");

?>
