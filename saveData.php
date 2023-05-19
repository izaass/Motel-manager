<?php
if (isset($_POST['data'])) {
     $data = json_decode($_POST['data'], true);
     file_put_contents('data.json', json_encode($data));
     echo "Add new success";
} else {
     // Return an error message if the ID parameter is not set
     echo "Error: data not valid.";
}
