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

               img {
                    display: none !important;
               }
          }
     </style>
</head>

<body><a href="./index.php" class="btn btn-info hidden-print">Quay Lại</a>
     <button class="btn btn-dark hidden-print" onclick="window.print();"> In hóa Đơn </button>
     <div class="">

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
               $ariseFee = $item['ariseFee'];
               $allFee = $item['allFee'];
               $roomFee = $item['roomFee'];
               $watterFee = $item['watterFee'];
               $electricFee = $item['electricFee'];
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
                              'ariseFee' => 0,
                              'year' => $year
                         );
                    } else {
                         $previousResult = end($results);
                         $previousAllFee = isset($previousResult['allFee']) ? $previousResult['allFee'] : 0;
                         // Tính toán số điện đã sử dụng
                         $usedElectric = $electric - $prevMonthItem['electric'];
                         $usedWatter = $watter - $prevMonthItem['watter'];
                         $tongtien = ($usedElectric * $electricFee) + ($usedWatter * $watterFee) + $info[0]['fee1'] + $info[0]['fee2'] + $ariseFee;
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
                              'ariseFee' => $ariseFee,
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
               $sumElectric = $result['usedElectric'] *  $electricFee;
               $sumWatter = $result['usedWatter'] *  $watterFee;
               $tongTienPhong = $sumElectric + $sumWatter + $info[0]['fee1'] + $info[0]['fee2'] + $roomFee + $ariseFee;
               $tongdientheothang += $result['usedElectric'];
               $tongnuoctheothang += $result['usedWatter'];
               $tongtheothang += $tongTienPhong;
          ?>
               <div class="card">
                    <div class="card-body">
                         <div class="container mb-5 mt-3">

                              <div class="container">
                                   <div class="col-md-12">
                                        <div class="text-center">
                                             <i class="fab fa-mdb fa-4x ms-0" style="color:#5d9fc5 ;"></i>
                                             <p class="pt-0"><strong>THÔNG BÁO TIỀN PHÒNG TRỌ</strong></p>
                                        </div>

                                   </div>


                                   <div class="row">
                                        <div class="col-xl-12 text-center">
                                             <p class="text-muted">Tháng <?= $month ?> Năm <?= $year ?>
                                             </p>
                                             <ul class="list-unstyled">
                                                  <li class="text-muted"></i> <span class="fw-bold">Phòng:</span>#<?= $result['roomNumber'] ?></li>
                                                  <li class="text-muted"></i> <span class="fw-bold">Ngày lập: </span>15/<?= $month ?>/<?= $year ?></li>
                                             </ul>
                                        </div>
                                   </div>
                                   <hr width="80%">
                                   <div class="row my-2 mx-1 justify-content-center">
                                        <table class="table table-striped table-borderless">
                                             <thead>
                                                  <tr>
                                                       <th scope="col">#</th>
                                                       <th scope="col">Khoản </th>
                                                       <th scope="col">Chi tiết </th>
                                                       <th scope="col">Thành Tiền </th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <tr>
                                                       <th scope="row">1</th>
                                                       <td>Phòng</td>
                                                       <td></td>
                                                       <td><?= number_format($roomFee, 0, '.', '.'); ?></td>
                                                  </tr>
                                                  <tr>
                                                       <th scope="row">2</th>
                                                       <td>Điện</td>
                                                       <td>( <?= $result['electric'] ?> - <?= $result['electricLastMonth'] ?> ) = <?= $result['usedElectric'] ?>Kw x <?= number_format($electricFee, 0, '.', '.'); ?> đ/Kw</td>
                                                       <td><?= number_format($sumElectric, 0, '.', '.'); ?></td>
                                                  </tr>
                                                  <tr>
                                                       <th scope="row">3</th>
                                                       <td>Nước</td>
                                                       <td>( <?= $result['watter'] ?> - <?= $result['watterLastMonth'] ?> ) = <?= $result['usedWatter'] ?>m3 x <?= number_format($watterFee, 0, '.', '.'); ?> đ/m3</td>
                                                       <td><?= number_format($sumWatter, 0, '.', '.'); ?></td>
                                                  </tr>
                                                  <tr>
                                                       <th scope="row">4</th>
                                                       <td><?= $info[0]['nameFee1'] ?></td>
                                                       <td></td>
                                                       <td><?= number_format($info[0]['fee1'], 0, '.', '.') ?></td>
                                                  </tr>
                                                  <tr>
                                                       <th scope="row">5</th>
                                                       <td><?= $info[0]['nameFee2'] ?></td>
                                                       <td></td>
                                                       <td><?= number_format($info[0]['fee2'], 0, '.', '.') ?></td>
                                                  </tr>
                                             </tbody>

                                        </table>
                                   </div>
                                   <div class="row">
                                        <div class="col-xl-6">
                                             <ul class="list-unstyled">
                                                  <li class="text-muted ms-3 mt-2"><span class="text-black me-4">Chi phí phát sinh: </span><?= number_format($result['ariseFee'], 0, '.', '.') ?></li>
                                             </ul>
                                             <p class="text-black float-start"><span class="text-black me-3"> Tổng </span><span style="font-size: 25px;"><?= number_format($tongTienPhong, 0, '.', '.'); ?> vnd</span></p>
                                        </div>
                                   </div>
                                   <hr width="80%">
                                   <div class="row">
                                        <div class="col-xl-10">
                                             <p>Thông tin chuyển khoản: STK: <?= $info[0]['stk'] ?> <strong>SDT/Zalo: <?= $info[0]['sdt'] ?></strong></p>
                                        </div>
                                   </div>

                              </div>
                         </div>
                    </div>
               </div>
          <?php      } ?>
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