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
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
     <title>RoomFee <?= $month . ' ' . $year ?></title>
     <style>
          @media print {
               .hidden-print {
                    display: none !important;
               }
          }



          /* .row {
               margin: 10px;
          }

          .khoangcach {
               padding: 5px;
               margin: 5px;
          }

          th,
          td {
               padding: 2px;

          } */
     </style>
</head>

<body><a href="./index.php" class="btn btn-info hidden-print">Home</a>
     <div class="row grid-container">

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
                              'allFee' => 0,
                              'month' => $month,
                              'year' => $year
                         );
                    } else {
                         $previousResult = end($results);
                         $previousAllFee = isset($previousResult['allFee']) ? $previousResult['allFee'] : 0;
                         // Tính toán số điện đã sử dụng
                         $usedElectric = $electric - $prevMonthItem['electric'];
                         $usedWatter = $watter - $prevMonthItem['watter'];
                         $tongtien = ($usedElectric * $info[0]['electricFee']) + ($usedWatter * $info[0]['watterFee']) + $info[0]['socialFee'] + $info[0]['roomFee'];
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
                              'allFee' => ($previousAllFee == 0) ? $tongtien : $previousAllFee,
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
          $tongtheothang = 0;
          $tongdientheothang = 0;
          $tongnuoctheothang = 0;
          foreach ($results as $result) {
               $sumElectric = $result['usedElectric'] *  $info[0]['electricFee'];
               $sumWatter = $result['usedWatter'] *  $info[0]['watterFee'];
               $tongTienPhong = $sumElectric + $sumWatter + $info[0]['socialFee'] + $info[0]['roomFee'];
               $tongdientheothang += $result['usedElectric'];
               $tongnuoctheothang += $result['usedWatter'];
               $tongtheothang += $result['allFee'];
          ?>
               <div class="grid-item">
                    <table border="1" class="khoangcach">
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
                                   <td><?= number_format($info[0]['roomFee'], 0, '.', '.'); ?> vnd</td>
                                   <td rowspan="4"> <?= number_format($tongTienPhong, 0, '.', '.'); ?> vnd</td>
                              </tr>
                              <tr>
                                   <td>Tiền điện</td>
                                   <td> <?= number_format($info[0]['electricFee'], 0, '.', '.'); ?> /kg</td>
                              </tr>
                              <tr>
                                   <td>Tiền nước</td>
                                   <td><?= number_format($info[0]['watterFee'], 0, '.', '.'); ?> /Khối</td>
                              </tr>
                              <tr>
                                   <td>Tiền an ninh + rác </td>
                                   <td><?= number_format($info[0]['socialFee'], 0, '.', '.') ?> vnd</td>
                              </tr>
                         </tbody>
                    </table>
               </div>
          <?php } ?>
     </div>
     <table class="table table-bordered table-dark hidden-print">
          <tr>
               <td>Tổng tiền</td>
               <td><?= number_format($tongtheothang, 0, '.', '.') ?></td>
          </tr>
          <tr>
               <td>Tổng số nước đã sử dụng</td>
               <td><?= number_format($tongnuoctheothang, 0, '.', '.') ?></td>
          </tr>
          <tr>
               <td>Tổng số điện đã sử dụng</td>
               <td><?= number_format($tongdientheothang, 0, '.', '.') ?></td>
          </tr>
     </table>
</body>

</html>