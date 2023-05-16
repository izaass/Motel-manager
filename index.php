<!DOCTYPE html>
<html>

<head>
     <title>Hiển thị bảng dữ liệu từ file JSON</title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- Thêm các đường link CSS của Bootstrap -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


     <!-- Thêm đường link CSS riêng của trang web -->
     <style>
          body {
               background-color: #f8f9fa;
               padding-top: 50px;
          }

          h1 {
               text-align: center;
               margin-bottom: 30px;
          }

          .table {
               margin-top: 30px;
          }

          .table th {
               text-align: center;
               vertical-align: middle;
          }

          .table td {
               text-align: center;
               vertical-align: middle;
          }

          .form-group {
               margin-bottom: 20px;
          }

          .form-group label {
               margin-right: 10px;
          }
     </style>
</head>

<body>
     <div class="container">
          <div class="row">
               <!-- Button to open the modal -->
               <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add data</button>
               <br>
               <!-- Add Modal -->
               <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                         <div class="modal-content">
                              <div class="modal-header">
                                   <h5 class="modal-title" id="addModalLabel">Add data</h5>
                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                   </button>
                              </div>
                              <div class="modal-body">
                                   <form id="addDataForm">
                                        <div class="form-group">
                                             <label for="addRoomNumber">Room number</label>
                                             <input type="text" class="form-control" id="addRoomNumber" name="addRoomNumber" required>
                                        </div>
                                        <div class="form-group">
                                             <label for="addElectric">Electric</label>
                                             <input type="text" class="form-control" id="addElectric" name="addElectric" required>
                                        </div>
                                        <div class="form-group">
                                             <label for="addWatter">Watter</label>
                                             <input type="text" class="form-control" id="addWatter" name="addWatter" required>
                                        </div>
                                        <div class="form-group">
                                             <label for="addMonth">Month</label>
                                             <input type="text" class="form-control" id="addMonth" name="addMonth" required>
                                        </div>
                                        <div class="form-group">
                                             <label for="addYear">Year</label>
                                             <input type="text" class="form-control" id="addYear" name="addYear" required>
                                        </div>
                                   </form>
                              </div>
                              <div class="modal-footer">
                                   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                   <button type="button" class="btn btn-primary" id="addDataBtn">Add Data</button>
                              </div>
                         </div>
                    </div>
               </div>
               <!-- Add Modal -->

               <!-- Edit Modal -->
               <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                         <div class="modal-content">
                              <div class="modal-header">
                                   <h5 class="modal-title" id="editModalLabel">Edit Room Data</h5>
                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                   </button>
                              </div>
                              <div class="modal-body">
                                   <form id="editForm" method="POST" action="update_room_data.php">
                                        <input type="hidden" name="id" id="roomId">

                                        <div class="form-group">
                                             <label for="roomNumber">Room Number</label>
                                             <input type="text" class="form-control" id="roomNumber" name="roomNumber" required>
                                        </div>
                                        <div class="form-group">
                                             <label for="electric">Electric</label>
                                             <input type="text" class="form-control" id="electric" name="electric" required>
                                        </div>
                                        <div class="form-group">
                                             <label for="watter">Water</label>
                                             <input type="text" class="form-control" id="watter" name="watter" required>
                                        </div>
                                        <div class="form-group">
                                             <label for="electricLastMonth">Electric Last Month</label>
                                             <input type="text" class="form-control" id="electricLastMonth" name="electricLastMonth" required>
                                        </div>
                                        <div class="form-group">
                                             <label for="watterLastMonth">Water Last Month</label>
                                             <input type="text" class="form-control" id="watterLastMonth" name="watterLastMonth" required>
                                        </div>
                                        <div class="form-group">
                                             <label for="usedElectric">Electric Used</label>
                                             <input type="text" class="form-control" id="usedElectric" name="usedElectric" disabled required>
                                        </div>
                                        <div class="form-group">
                                             <label for="usedWatter">Water Used</label>
                                             <input type="text" class="form-control" id="usedWatter" name="usedWatter" disabled required>
                                        </div>
                                        <div class="form-group">
                                             <label for="month">Month</label>
                                             <input type="text" class="form-control" id="month" name="month" required>
                                        </div>
                                        <div class="form-group">
                                             <label for="year">Year</label>
                                             <input type="text" class="form-control" id="year" name="year" required>
                                        </div>

                                        <div class="modal-footer">
                                             <input type="hidden" id="roomId">
                                             <button type="submit" class="btn btn-primary">Save Changes</button>
                                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                   </form>
                              </div>
                         </div>
                    </div>
               </div>
               <!-- Edit Modal -->

               <table class="table table-striped table-bordered table-hover">

                    <?php
                    // Lấy dữ liệu từ tệp JSON
                    $data = file_get_contents('data.json');
                    $data = json_decode($data, true);

                    // Tạo mảng để lưu trữ kết quả tính toán
                    $results = array();

                    // Lặp qua mỗi phần tử trong dữ liệu JSON
                    foreach ($data as $item) {

                         // Lấy các giá trị cần thiết
                         $id = $item['id'];
                         $roomNumber = $item['roomNumber'];
                         $electric = $item['electric'];
                         $watter = $item['watter'];
                         $month = $item['month'];
                         $year = $item['year'];

                         // Tìm phần tử có cùng phòng và năm nhưng tháng trước đó
                         $prevMonthItem = null;
                         foreach ($data as $prevItem) {
                              if ($prevItem['roomNumber'] == $roomNumber && $prevItem['year'] == $year && $prevItem['month'] == $month - 1) {
                                   $prevMonthItem = $prevItem;
                                   break;
                              }
                         }

                         // Nếu không tìm thấy phần tử tháng trước đó, hiển thị thông báo
                         if ($prevMonthItem == null) {
                              $results[] = array(
                                   'id' => $id,
                                   'roomNumber' => $roomNumber,
                                   'electric' => $electric,
                                   'watter' => $watter,
                                   'electricLastMonth' => 0,
                                   'watterLastMonth' => 0,
                                   'usedElectric' => 0,
                                   'usedWatter' => 0,
                                   'month' => $month,
                                   'year' => $year
                              );
                         } else {
                              // Tính toán số điện đã sử dụng
                              $usedElectric = $electric - $prevMonthItem['electric'];
                              $usedWatter = $watter - $prevMonthItem['watter'];
                              // Lưu kết quả tính toán vào mảng kết quả
                              $results[] = array(
                                   'id' => $id,
                                   'roomNumber' => $roomNumber,
                                   'electric' => $electric,
                                   'watter' => $watter,
                                   'electricLastMonth' => $prevMonthItem['electric'],
                                   'watterLastMonth' => $prevMonthItem['watter'],
                                   'usedElectric' => $usedElectric,
                                   'usedWatter' => $usedWatter,
                                   'month' => $month,
                                   'year' => $year
                              );
                         }
                    }

                    // Ghi kết quả vào file data.json
                    file_put_contents('data.json', json_encode($results));

                    // Hiển thị kết quả trong bảng HTML
                    echo "<tr>
<th>ID</th>
<th>Phòng</th>
<th>Số điện</th>
<th>Số nước</th>
<th>Số điện tháng trước</th>
<th>số nước tháng trước</th>
<th>Số điện sử dụng</th>
<th>Số nước sử dụng</th>
<th>Tháng/Năm</th>
<th>Xem</th>
<th>Chỉnh sửa</th>
<th>Xóa</th>
</tr>";
                    foreach ($results as $result) {
                         $url = "fee_by_month.php?month=" . $result['month'] . "&year=" . $result['year'];
                         echo "<tr>
     <td>" . $result['id'] . "</td>
     <td>" . $result['roomNumber'] . "</td>
     <td>" . $result['electric'] . "</td>
     <td>" . $result['watter'] . "</td>
     <td>" . $result['electricLastMonth'] . "</td>
     <td>" . $result['watterLastMonth'] . "</td>
     <td>" . $result['usedElectric'] . "</td>
     <td>" . $result['usedWatter'] . "</td>
     <td>" . $result['month'] . "/" . $result['year'] . "</td>
     <td>
     <a class='btn btn-primary btn-sm' href='" . $url . "' target='_blank'>View</a>
     </td>
     <td>
          <button class='btn btn-warning btn-sm edit' data-id='" . $result['id'] . "'>Edit</button>
     </td>
     <td><button class='btn btn-danger btn-sm' onclick='deleteRow(" . $result['id'] . ")'>Delete</button></td>                   
</tr>";
                    }
                    echo "</table>";
                    ?>
          </div>
     </div>
     <script src="script.js"></script>
</body>

</html>