function deleteRow(id) {
     if (confirm("Bạn có chắc chắn muốn xóa dòng này không?")) {
          $.ajax({
               type: "POST",
               url: "delete_row.php",
               data: {
                    id: id
               },
               success: function (response) {
                    // Xóa dòng từ bảng HTML
                    $("#" + id).remove();
                    alert(response);
                    location.reload();
               },
          });
     }
}
$(document).ready(function () {
     $('#data-table').DataTable({
          order: [
               [9, 'desc']
          ],
          language: {
               url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/vi.json',
          }
     });
     fetch('rooms.json')
          .then(response => response.json())
          .then(data => {
               const stk = document.getElementById('stk');
               const sdt = document.getElementById('sdt');
               const fee1 = document.getElementById('fee1');
               const fee2 = document.getElementById('fee2');
               const nameFee1 = document.getElementById('nameFee1');
               const nameFee2 = document.getElementById('nameFee2');
               const id = document.getElementById('id');

               // Assuming there is only one row in the JSON data
               const row = data[0];

               fee1.value = row.fee1;
               fee2.value = row.fee2;
               nameFee2.value = row.nameFee2;
               nameFee1.value = row.nameFee1;
               sdt.value = row.sdt;
               stk.value = row.stk;
               id.value = row.id;
          })
          .catch(error => {
               console.log('Error:', error);
          });
     $('#editDefaultModal').on('click', function () {
          // Get the ID of the room to edit from the data-id attribute of the button
          const id = $(this).data('idDF');
          // Send AJAX request to get data for the room with the given ID
          $.ajax({
               url: 'get_default_info.php',
               type: 'GET',
               data: {
                    id: id,
               },
               dataType: 'json',
               success: function (data) {
                    // Populate the form with the data for the room
                    console.log(data);
                    $('#id').val(data.id);
                    $('#stk').val(data.stk);
                    $('#sdt').val(data.sdt);
                    $('#nameFee1').val(data.nameFee1);
                    $('#nameFee2').val(data.nameFee2);
                    $('#fee1').val(data.fee1);
                    $('#fee2').val(data.fee2);
                    $('#editInfoModal').modal('show');
               },
               error: function () {
                    alert('Error getting room data');
               }
          });
     });
     // Edit button click event
     $('.edit').on('click', function () {
          // Get the ID of the room to edit from the data-id attribute of the button
          const id = $(this).data('id');
          // Send AJAX request to get data for the room with the given ID
          $.ajax({
               url: 'get_room_data.php',
               type: 'GET',
               data: {
                    id: id,
               },
               dataType: 'json',
               success: function (data) {
                    // Populate the form with the data for the room
                    console.log(data);
                    $('#roomId').val(data.id);
                    $('#roomNumber').val(data.roomNumber);
                    $('#electric').val(data.electric);
                    $('#watter').val(data.watter);
                    $('#roomFee').val(data.roomFee);
                    $('#electricFee').val(data.electricFee);
                    $('#watterFee').val(data.watterFee);
                    $('#ariseFee').val(data.ariseFee);
                    $('#month').val(data.month);
                    $('#year').val(data.year);
                    // Open the edit modal
                    $('#editModal').modal('show');
               },
               error: function () {
                    alert('Error getting room data');
               }
          });
     });

     // Submit button click event
     $('#editForm').on('submit', function (event) {
          event.preventDefault();
          const id = $(this).data('id');
          // Send AJAX request to update data for the room
          $.ajax({
               url: 'update_room_data.php',
               type: 'POST',
               data: $(this).serialize(),
               success: function (response) {
                    // Close the edit modal
                    $('#editModal').modal('hide');
                    // Reload the table or show success message
                    alert(response);
                    location.reload();
               },
               error: function () {
                    alert('Error updating room data');
               }
          });
     });
     // Submit button click event
     $('#editDefault').on('submit', function (event) {
          event.preventDefault();
          const id = $(this).attr('id');
          var formData = $(this).serialize();
          // Send AJAX request to update data for the room
          $.ajax({
               url: 'default_info_process.php',
               type: 'POST',
               data: formData,
               success: function (response) {
                    console.log(response);
                    // Close the edit modal
                    $('#editInfoModal').modal('hide');
                    // Reload the table or show success message
                    alert(response);
                    location.reload();
               },
               error: function () {
                    alert('Error updating room data');
               }
          });
     });


});
$('.copy').on('click', function () {
     if (confirm("Bạn có chắc chắn muốn copy dòng này không?")) {
          // Get the ID of the room to edit from the data-id attribute of the button
          const currentDate = new Date();
          const currentMonth = currentDate.getMonth() + 1; // Month starts from 0, so add 1
          const currentYear = currentDate.getFullYear();
          const id = $(this).data('id');
          // Send AJAX request to get data for the room with the given ID
          $.ajax({
               url: 'get_room_data.php',
               type: 'GET',
               data: {
                    id: id,
               },
               dataType: 'json',
               success: function (data, response) {
                    // Populate the form with the data for the room
                    console.log(data);
                    addData(data.roomNumber + " (copy)", data.electric, data.watter, currentMonth, currentYear, data.roomFee, data.electricFee, data.watterFee);
                    alert(response);
               },
               error: function () {
                    alert('Error getting room data');
               }
          });
     }
});


$('#addDataBtn').click(function () {
     $.getJSON('data.json', function (data) {
          // Lấy dữ liệu từ các trường input của modal
          const roomNumber = document.getElementById("addRoomNumber").value;
          const electric = document.getElementById("addElectric").value;
          const watter = document.getElementById("addWatter").value;
          const tienphong = document.getElementById("addRoomFee").value;
          const tiendien = document.getElementById("addElectricFee").value;
          const tiennuoc = document.getElementById("addWatterFee").value;
          //const month = new Date().getMonth() + 1; // Lấy tháng hiện tại
          const month = document.getElementById("addMonth").value;
          const year = new Date().getFullYear(); // Lấy năm hiện tại

          // Kiểm tra tính hợp lệ của dữ liệu
          if (!roomNumber || !electric || !watter) {
               alert("Vui lòng nhập đầy đủ thông tin!");
               return;
          }
          if (isNaN(roomNumber) || isNaN(electric) || isNaN(watter)) {
               alert("Vui lòng nhập số cho các trường số liệu!");
               return;
          }

          // Tạo đối tượng mới chứa thông tin mới và thêm vào mảng data
          const newData = {
               id: String(data.length + 1),
               roomNumber,
               electric,
               ariseFee: 0,
               electricFee: tiendien,
               watterFee: tiennuoc,
               roomFee: tienphong,
               watter,
               month,
               year,
          };
          data.push(newData);

          // Lưu mảng data vào file JSON
          $.ajax({
               type: "POST",
               url: "saveData.php",
               data: {
                    data: JSON.stringify(data)
               },
               success: function (response) {
                    // Đóng modal và làm mới trang để hiển thị dữ liệu mới
                    $("#myModal").modal("hide");
                    alert(response);
                    location.reload();
               },
               error: function () {
                    alert("Lỗi khi lưu dữ liệu vào file JSON!");
               }
          });
     });
});

function addData(roomNumber, electric, watter, month, year, roomFee, electricFee, watterFee) {
     // Construct the new data object
     $.getJSON('data.json', function (data) {
          const newData = {
               id: String(data.length + 1),
               roomNumber: roomNumber,
               electric: electric,
               watter: watter,
               electricFee: electricFee,
               watterFee: watterFee,
               roomFee: roomFee,
               ariseFee: 0,
               allFee: 0,
               month: month,
               year: year,
          };
          data.push(newData);
          // Send AJAX request to save the data
          $.ajax({
               type: "POST",
               url: "saveData.php",
               data: {
                    data: JSON.stringify(data)
               },
               success: function () {
                    // Close the modal and reload the page to display the updated data
                    location.reload();
               },
               error: function () {
                    alert("Lỗi khi lưu dữ liệu vào file JSON!");
               }
          });
     });
}