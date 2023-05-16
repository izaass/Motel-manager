<?php
$data = json_decode($_POST['data'], true);
file_put_contents('data.json', json_encode($data));
