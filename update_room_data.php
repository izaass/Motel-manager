<?php
if (isset($_POST['id'])) {
     // Get the ID of the row to update
     $id = $_POST['id'];

     // Get the form data
     $roomNumber = $_POST['roomNumber'];
     $electric = $_POST['electric'];
     $watter = $_POST['watter'];
     $ariseFee = $_POST['ariseFee'];
     $month = $_POST['month'];
     $year = $_POST['year'];
     $electricFee = $_POST['electricFee'];
     $watterFee = $_POST['watterFee'];
     $roomFee = $_POST['roomFee'];

     // Load the existing data from the JSON file
     $data = json_decode(file_get_contents("data.json"), true);

     // Find the room with the specified ID
     $index = array_search($id, array_column($data, "id"));
     if ($index !== false) {
          // Update the room's values
          $data[$index]["roomNumber"] = $roomNumber;
          $data[$index]["electric"] = $electric;
          $data[$index]["watter"] = $watter;
          $data[$index]["electricFee"] = $electricFee;
          $data[$index]["watterFee"] = $watterFee;
          $data[$index]["roomFee"] = $roomFee;
          $data[$index]["ariseFee"] = $ariseFee;
          $data[$index]["month"] = $month;
          $data[$index]["year"] = $year;

          // Save the updated data to the JSON file
          file_put_contents("data.json", json_encode($data));

          // Return a success response
          echo "Update Success";
     } else {
          // Return an error response if the room was not found
          echo json_encode(array("status" => "error", "message" => "Room not found"));
     }
} else {
     // Return an error response if the ID parameter is not set
     echo json_encode(array("status" => "error", "message" => "ID parameter not set"));
}
