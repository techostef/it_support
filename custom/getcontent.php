<?php
$data = file_get_contents("https://server-status-tsp.firebaseapp.com/status");
$data = json_decode($data);
echo json_encode($data);
?>