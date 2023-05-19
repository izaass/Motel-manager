<!DOCTYPE html>
<html>

<head>
     <title>Quản lý phòng trọ</title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- Thêm các đường link CSS của Bootstrap -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">



     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
     <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
     <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
     <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>


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
     <div class="table-responsive">
          <div class="container">
               <div class="row">
                    <!-- Button to open the modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Thêm Phòng mới</button>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-idDF="1" data-target="#editInfoModal">Sửa thông tin mặc định</button>
                    <br><br><br>
                    <!-- Add Modal -->
                    <div class="modal fade" id="addModal" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                         <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                   <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h5 class="modal-title" id="addModalLabel">Thêm phòng mới</h5>
                                   </div>
                                   <div class="modal-body">
                                        <form id="addDataForm">
                                             <div class="form-group">
                                                  <label for="addRoomNumber">Số phòng</label>
                                                  <input type="text" class="form-control" id="addRoomNumber" name="addRoomNumber" required>
                                             </div>
                                             <div class="form-group">
                                                  <label>Tiền Phòng mặc định</label>
                                                  <input type="text" class="form-control" id="addRoomFee" name="addRoomFee" required>
                                             </div>
                                             <div class="form-group">
                                                  <label>Tiền điện mặc định</label>
                                                  <input type="text" name="addElectricFee" class="form-control" id="addElectricFee">
                                             </div>
                                             <div class="form-group">
                                                  <label>Tiền nước mặc định</label>
                                                  <input type="text" name="addWatterFee" class="form-control" id="addWatterFee">
                                             </div>
                                             <div class="form-group">
                                                  <label for="addElectric">Số điện hiện tại</label>
                                                  <input type="text" class="form-control" id="addElectric" name="addElectric" required>
                                             </div>
                                             <div class="form-group">
                                                  <label for="addWatter">Số nước hiện tại</label>
                                                  <input type="text" class="form-control" id="addWatter" name="addWatter" required>
                                             </div>
                                             <div class="form-group">
                                                  <label for="addMonth">Tháng</label>
                                                  <input type="text" class="form-control" id="addMonth" name="addMonth" required>
                                             </div>
                                             <div class="form-group">
                                                  <label for="addYear">Năm</label>
                                                  <input type="text" class="form-control" id="addYear" name="addYear" required>
                                             </div>
                                        </form>
                                   </div>
                                   <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="addDataBtn">Thêm mới</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <!-- Add Modal -->

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                         <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                   <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h5 class="modal-title" id="editModalLabel">Cập nhật phòng</h5>
                                   </div>
                                   <div class="modal-body">
                                        <form id="editForm" method="POST" action="update_room_data.php">
                                             <input type="hidden" name="id" id="roomId">

                                             <div class="form-group">
                                                  <label for="roomNumber">Têm phòng</label>
                                                  <input type="text" class="form-control" id="roomNumber" name="roomNumber" required>
                                             </div>
                                             <div class="form-group">
                                                  <label for="ariseFee">Chi phí phát sinh</label>
                                                  <input type="text" class="form-control" id="ariseFee" name="ariseFee" required>
                                             </div>
                                             <div class="form-group">
                                                  <label for="electric">Số Điện mới</label>
                                                  <input type="text" class="form-control" id="electric" name="electric" required>
                                             </div>
                                             <div class="form-group">
                                                  <label for="watter">Số nước mới</label>
                                                  <input type="text" class="form-control" id="watter" name="watter" required>
                                             </div>
                                             <div class="form-group">
                                                  <label>Tiền phòng mặc định</label>
                                                  <input type="text" class="form-control" id="roomFee" name="roomFee" required>
                                             </div>
                                             <div class="form-group">
                                                  <label for="ariseFee">Tiền điện mặc định</label>
                                                  <input type="text" class="form-control" id="electricFee" name="electricFee" required>
                                             </div>
                                             <div class="form-group">
                                                  <label for="electric">Tiền nước mặc định</label>
                                                  <input type="text" class="form-control" id="watterFee" name="watterFee" required>
                                             </div>
                                             <div class="form-group">
                                                  <label for="month">Tháng</label>
                                                  <input type="text" class="form-control" id="month" name="month" required>
                                             </div>
                                             <div class="form-group">
                                                  <label for="year">Năm</label>
                                                  <input type="text" class="form-control" id="year" name="year" required>
                                             </div>

                                             <div class="modal-footer">
                                                  <input type="hidden" id="roomId">
                                                  <button type="submit" class="btn btn-primary">Lưu</button>
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                                             </div>
                                        </form>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <!-- Edit Modal -->

                    <!-- edit default info modal -->
                    <div class="modal fade" id="editInfoModal" role="dialog" aria-labelledby="editInfoModalLabel" aria-hidden="true">
                         <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                   <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h5 class="modal-title" id="editInfoModalLabel">Sửa thông tin mặc định</h5>
                                   </div>
                                   <div class="modal-body">
                                        <form method="POST" id="editDefault" action="default_info_process.php">
                                             <input type="hidden" name="id" id="id">
                                             <div class="form-group">
                                                  <label>Số tài khoản</label>
                                                  <input type="text" name="stk" class="form-control" id="stk">
                                             </div>
                                             <div class="form-group">
                                                  <label>Số điện thoại</label>
                                                  <input type="text" name="sdt" class="form-control" id="sdt">
                                             </div>
                                             <div class="form-group">
                                                  <label>Tên khoản phí 1</label>
                                                  <input type="text" name="nameFee1" class="form-control" id="nameFee1">
                                             </div>
                                             <div class="form-group">
                                                  <label>Mệnh giá khoản phí 1</label>
                                                  <input type="text" name="fee1" class="form-control" id="fee1">
                                             </div>
                                             <div class="form-group">
                                                  <label>Tên khoản phí 2</label>
                                                  <input type="text" name="nameFee2" class="form-control" id="nameFee2">
                                             </div>
                                             <div class="form-group">
                                                  <label>Mệnh giá khoản phí 2</label>
                                                  <input type="text" name="fee2" class="form-control" id="fee2">
                                             </div>

                                             <div class="modal-footer">
                                                  <input type="hidden" id="roomId">
                                                  <button type="submit" class="btn btn-primary">Lưu</button>
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                                             </div>
                                        </form>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <!-- edit default info modal -->


                    <?php
                    // Lấy dữ liệu từ tệp JSON
                    $data = file_get_contents('data.json');
                    $data = json_decode($data, true);
                    $info = file_get_contents('rooms.json');
                    $info = json_decode($info, true);

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
                         $ariseFee = $item['ariseFee'];
                         $roomFee = $item['roomFee'];
                         $watterFee = $item['watterFee'];
                         $electricFee = $item['electricFee'];
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
                                   'allFee' => 0,
                                   'electricFee' => $electricFee,
                                   'watterFee' => $watterFee,
                                   'roomFee' => $roomFee,
                                   "ariseFee" => 0,
                                   'month' => $month,
                                   'year' => $year
                              );
                         } else {
                              // Tính toán số điện đã sử dụng
                              $usedElectric = $electric - $prevMonthItem['electric'];
                              $usedWatter = $watter - $prevMonthItem['watter'];
                              $tongtien = ($usedElectric * $electricFee) + ($usedWatter * $watterFee) + $info[0]['fee1'] + $info[0]['fee2'] + $roomFee + $ariseFee;

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
                                   'allFee' => $tongtien,
                                   'electricFee' => $electricFee,
                                   'watterFee' => $watterFee,
                                   'roomFee' => $roomFee,
                                   "ariseFee" => $ariseFee,
                                   'month' => $month,
                                   'year' => $year
                              );
                         }
                    }

                    // Ghi kết quả vào file data.json
                    file_put_contents('data.json', json_encode($results));

                    // Hiển thị kết quả trong bảng HTML
                    ?>
                    <table id="data-table" class="table table-striped table-bordered table-hover">
                         <thead>

                              <tr>
                                   <th>ID</th>
                                   <th>Phòng</th>
                                   <th>Số điện mới</th>
                                   <th>Số nước mới</th>
                                   <th>Số điện cũ</th>
                                   <th>Số nước cũ</th>
                                   <th>Số điện đã sử dụng</th>
                                   <th>Số nước đã sử dụng</th>
                                   <th>Chi phí phát sinh</th>
                                   <th>Tháng/Năm</th>
                                   <th>Xem</th>
                                   <th>Sao chép</th>
                                   <th>Chỉnh sửa</th>
                                   <th>Xóa</th>
                              </tr>
                         </thead>
                         <tbody>
                              <?php
                              foreach ($results as $result) {
                                   $url = "print.php?month=" . $result['month'] . "&year=" . $result['year']; ?>
                                   <tr>
                                        <td><?= $result['id'] ?></td>
                                        <td><?= $result['roomNumber'] ?></td>
                                        <td><?= $result['electric'] ?></td>
                                        <td><?= $result['watter'] ?></td>
                                        <td><?= $result['electricLastMonth'] ?></td>
                                        <td><?= $result['watterLastMonth'] ?></td>
                                        <td><?= $result['usedElectric'] ?></td>
                                        <td><?= $result['usedWatter'] ?></td>
                                        <td><?= $result['ariseFee'] ?></td>
                                        <td><?= $result['month'] . "/" . $result['year'] ?></td>
                                        <td>
                                             <a class='btn btn-primary btn-sm' href="<?= $url ?>" target='_blank'>Xem</a>
                                        </td>
                                        <td>
                                             <button class='btn btn-info btn-sm copy' data-id=" <?= $result['id'] ?>">Sao chép</button>
                                        </td>
                                        <td>
                                             <button class='btn btn-warning btn-sm edit' data-id=" <?= $result['id'] ?>">Sửa</button>
                                        </td>
                                        <td><button class='btn btn-danger btn-sm' onclick="deleteRow(<?= $result['id'] ?>)">Xóa</button></td>
                                   </tr><?php } ?>
                         </tbody>
                    </table>
               </div>
          </div>
     </div>
     <script src="script.js"></script>
</body>

</html>