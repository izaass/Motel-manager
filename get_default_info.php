<?php
// Read rooms data from file
$roomsData = file_get_contents('rooms.json');
$rooms = json_decode($roomsData, true);

// Get the ID of the room to edit
$id = $_GET['id'];

// Find the room with the given ID
$room = null;
foreach ($rooms as $r) {
     if ($r['id'] == $id) {
          $room = $r;
          //break;
     }
}

// Return the data for the room as JSON
echo json_encode($room);
