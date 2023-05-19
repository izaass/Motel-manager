<?php
if (isset($_POST['id'])) {
    // Get the ID of the row to update
    $id = $_POST['id'];
    // Get the form data
    $sdt = $_POST['sdt'];
    $stk = $_POST['stk'];
    $nameFee1 = $_POST['nameFee1'];
    $nameFee2 = $_POST['nameFee2'];
    $fee1 = $_POST['fee1'];
    $fee2 = $_POST['fee2'];

    // Load the existing data from the JSON file
    $data = json_decode(file_get_contents("rooms.json"), true);

    // Assuming there is only one row in the JSON data
    $index = array_search($id, array_column($data, "id"));
    if ($index !== false) {

        // Update the row's values
        $data[$index]["sdt"] = $sdt;
        $data[$index]["stk"] = $stk;
        $data[$index]["nameFee1"] = $nameFee1;
        $data[$index]["nameFee2"] = $nameFee2;
        $data[$index]["fee1"] = $fee1;
        $data[$index]["fee2"] = $fee2;

        // Save the updated data to the JSON file
        file_put_contents("rooms.json", json_encode($data));

        // Redirect to the success page or perform any other actions
        echo "Update Success";
    } else {
        // Return an error response if the room was not found
        echo json_encode(array("status" => "error", "message" => "Room not found"));
    }
} else {
    // Return an error response if the ID parameter is not set
    echo json_encode(array("status" => "error", "message" => "ID parameter not set"));
}
