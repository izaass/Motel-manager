// Read the JSON data from the file
fetch('dulieu.json')
     .then(response => response.json())
     .then(data => {
          displayInfoTable(data.info);
          displayDataTable(data.info.data);
     })
     .catch(error => console.log(error));

// Display the Info table
function displayInfoTable(info) {
     const infoTable = document.getElementById('infoTable');
     const infoData = Object.entries(info);

     for (let [key, value] of infoData) {
          const row = infoTable.insertRow();
          const cell1 = row.insertCell(0);
          const cell2 = row.insertCell(1);

          cell1.innerHTML = key;
          cell2.innerHTML = value;
     }
}

// Display the Data table
function displayDataTable(data) {
     const dataTable = document.getElementById('dataTable');
     const headers = ['ID', 'Room Number', 'Electric', 'Water', 'Month', 'Year'];

     // Create header row
     const headerRow = dataTable.insertRow();
     for (let header of headers) {
          const headerCell = document.createElement('th');
          headerCell.innerHTML = header;
          headerRow.appendChild(headerCell);
     }

     // Create data rows
     for (let item of data) {
          const row = dataTable.insertRow();
          row.insertCell().innerHTML = item.id;
          row.insertCell().innerHTML = item.roomNumber;
          row.insertCell().innerHTML = item.electric;
          row.insertCell().innerHTML = item.watter;
          row.insertCell().innerHTML = item.month;
          row.insertCell().innerHTML = item.year;
     }
}
// Call the display functions with the provided JSON data
displayInfoTable(jsonData.info);
displayDataTable(jsonData.info.data);