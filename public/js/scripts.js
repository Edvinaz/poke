getUserList();
function pokeUser(user) {
    console.log(user);
    $.ajax({
        type: 'GET',
        url: 'users.php',
        data: { poked_user: user, data: 'poke_user'},
        success: function(response) {
            // Handle the server response
            var responseObject = JSON.parse(response);
            if (responseObject.status === 'success') {
                // Process the list data
                getUserList();
                console.log(JSON.parse(responseObject.data));
                // var listData = responseObject.data;
                // Update the HTML with the list data
                // document.getElementById('listContainer').innerHTML = listData;
                // alert(responseObject.message);
            } else {
                alert('Error: ' + responseObject.message);
            }
        },
        error: function() {
            alert('An error occurred during the AJAX request.');
        }
    });
}
function getPokes() {
    $.ajax({
        type: 'GET',
        url: 'users.php',
        data: { data: 'pokes'},
        success: function(response) {
            // Handle the server response
            var responseObject = JSON.parse(response);
            if (responseObject.status === 'success') {
                // Process the list data
                console.log(JSON.parse(responseObject.data));
                // var listData = responseObject.data;
                // Update the HTML with the list data
                // document.getElementById('listContainer').innerHTML = listData;
                // alert(responseObject.message);
            } else {
                alert('Error: ' + responseObject.message);
            }
        },
        error: function() {
            alert('An error occurred during the AJAX request.');
        }
    });
}

function getUserList() {
    $.ajax({
        type: 'GET',
        url: 'users.php',
        data: { data: 'list'},
        success: function(response) {
            // Handle the server response
            var responseObject = JSON.parse(response);
            var dataObject = JSON.parse(responseObject.data);

            if (responseObject.status === 'success') {
                var table = document.getElementById('userList');
                var tbody = table.getElementsByTagName('tbody')[0];
                tbody.innerHTML = ''; // Clear existing table data

                // Populate the table with data
                for (var i = 0; i < dataObject.length; i++) {
                    var record = dataObject[i];
                    console.log(record);
                    var row = tbody.insertRow();
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                    var cell5 = row.insertCell(4);

                    cell1.innerHTML = record.name;
                    cell2.innerHTML = record.surname;
                    cell3.innerHTML = record.email;
                    cell4.innerHTML = record.poke;
                    cell5.innerHTML = '<button onclick="pokeUser(' + record.id + ')">POKE</button>'
                }
            } else {
                alert('Error: ' + data.message);
            }
        },
        error: function() {
            alert('An error occurred during the AJAX request.');
        }
    });
}
