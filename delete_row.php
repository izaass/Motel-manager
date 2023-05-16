<?php
if (isset($_POST['id'])) {
    // Get the ID of the row to delete
    $id = $_POST['id'];

    // Get the contents of the data file
    $data = file_get_contents('data.json');

    // Convert the JSON data to a PHP array
    $data = json_decode($data, true);

    // Loop through the data array to find the row with the matching ID
    foreach ($data as $key => $row) {
        if ($row['id'] == $id) {
            // Remove the row from the data array
            unset($data[$key]);
        }
    }

    // Encode the updated data array back to JSON format
    $data = json_encode($data);

    // Write the updated data back to the data file
    file_put_contents('data.json', $data);

    // Return a success message
    echo "Row with ID $id has been deleted.";
} else {
    // Return an error message if the ID parameter is not set
    echo "Error: ID parameter not set.";
}
