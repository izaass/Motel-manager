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
                         $('#electricLastMonth').val(data.electricLastMonth);
                         $('#watterLastMonth').val(data.watterLastMonth);
                         $('#usedElectric').val(data.usedElectric);
                         $('#usedWatter').val(data.usedWatter);
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


     });

     $('#addDataBtn').click(function () {
          $.getJSON('data.json', function (data) {
               // Lấy dữ liệu từ các trường input của modal
               const roomNumber = document.getElementById("addRoomNumber").value;
               const electric = document.getElementById("addElectric").value;
               const watter = document.getElementById("addWatter").value;
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
                    success: function () {
                         // Đóng modal và làm mới trang để hiển thị dữ liệu mới
                         $("#myModal").modal("hide");
                         location.reload();
                    },
                    error: function () {
                         alert("Lỗi khi lưu dữ liệu vào file JSON!");
                    }
               });
          });
     });