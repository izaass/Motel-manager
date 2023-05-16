<?php
// Get month and year from query parameters
$month = isset($_GET['month']) ? $_GET['month'] : null;
$year = isset($_GET['year']) ? $_GET['year'] : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>RoomFee <?= $month . ' ' . $year ?></title>
     <style>
          * {
               box-sizing: border-box;
          }

          .row {
               margin-left: -5px;
               margin-right: -5px;
          }

          .column {
               float: left;
               width: 50%;
               padding: 120px 5px;
          }

          /* Clearfix (clear floats) */
          .row::after {
               content: "";
               clear: both;
               display: table;
          }

          table {
               border-collapse: collapse;
               border-spacing: 0;
               width: 100%;
               border: 1px solid #ddd;
          }

          th,
          td {
               text-align: left;
               padding: 16px;
          }

          tr:nth-child(even) {
               background-color: #f2f2f2;
          }
     </style>
</head>

<body>
     <div class="row">
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
               $itemMonth = $item['month'];
               $itemYear = $item['year'];

               // Kiểm tra xem phần tử có thỏa mãn yêu cầu về tháng và năm hay không
               if ($itemMonth == $month && $itemYear == $year) {

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
          }

          // Hiển thị kết quả trong bảng HTML
          // echo "<table border='1'>";
          // echo "<tr><th>ID</th><th>Số phòng</th><th>Số điện sử dụng</th><th>Số nước sử dụng</th><th>Tháng</th><th>Năm</th></tr>";
          // foreach ($results as $result) {
          //      echo "<tr><td>" . $result['id'] . "</td><td>" . $result['roomNumber'] . "</td><td>" . $result['usedElectric'] . "</td><td>" . $result['usedWatter'] . "</td><td>" . $result['month'] . "</td><td>" . $result['year'] . "</td></tr>";
          // }
          // echo "</table>";

          $tienDien = 3000;
          $tienNuoc = 15000;
          $tienSinhHoat = 30000;
          $tienPhong = 1000000;
          foreach ($results as $result) {
               $sumElectric = $result['usedElectric'] *  $tienDien;
               $sumWatter = $result['usedWatter'] *  $tienNuoc;
               $tongTienPhong = $sumElectric + $sumWatter + $tienSinhHoat + $tienPhong;
          ?>
               <div class="column">
                    <table border='1'>
                         <thead>
                              <th>#</th>
                              <th>Phòng <?= $result['roomNumber'] ?></th>
                              <th>Thành tiền</th>
                         </thead>
                         <tbody>
                              <tr>
                                   <td>Số điện mới</td>
                                   <td><?= $result['electric'] ?></td>
                                   <td rowspan="3"> <?= number_format($sumElectric, 0, '.', '.'); ?> vnd</td>
                              </tr>
                              <tr>
                                   <td>Số điện cũ</td>
                                   <td><?= $result['electricLastMonth'] ?></td>
                              </tr>
                              <tr>
                                   <td>Tổng sử dụng</td>
                                   <td><?= $result['usedElectric'] ?> Kg</td>
                              </tr>
                              <tr>
                                   <td>Số nước mới</td>
                                   <td><?= $result['watter'] ?></td>
                                   <td rowspan="3"> <?= number_format($sumWatter, 0, '.', '.'); ?> vnd</td>
                              </tr>
                              <tr>
                                   <td>Số nước cũ</td>
                                   <td><?= $result['watterLastMonth'] ?></td>
                              </tr>
                              <tr>
                                   <td>Tổng sử dụng</td>
                                   <td><?= $result['usedWatter'] ?> Khối</td>
                              </tr>
                              <tr>
                                   <td>Tiền phòng</td>
                                   <td>1.000.000 vnd</td>
                                   <td rowspan="4"> <?= number_format($tongTienPhong, 0, '.', '.') ?> vnd</td>
                              </tr>
                              <tr>
                                   <td>Tiền điện</td>
                                   <td>3.000/kg</td>
                              </tr>
                              <tr>
                                   <td>Tiền nước</td>
                                   <td>15.000/Khối</td>
                              </tr>
                              <tr>
                                   <td>Tiền an ninh + rác</td>
                                   <td>30.000</td>
                              </tr>
                         </tbody>
                    </table>
               </div>
          <?php } ?>
     </div>
</body>

</html>