var limit = 40;
var offset = 0;
var pages = 0;

getUserList();
getPokes();

getPokedUsers();

function pokeUser(user) {
    $.ajax({
        type: 'GET',
        url: 'ajax.php',
        data: { poked_user: user, data: 'poke_user'},
        success: function(response) {
            var responseObject = JSON.parse(response);
            if (responseObject.status === 'success') {
                getUserList();

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
    console.log('get pokes');
    $.ajax({
        type: 'GET',
        url: 'ajax.php',
        data: { data: 'pokes'},
        success: function(response) {
            // Handle the server response
            var responseObject = JSON.parse(response);
            var dataObject = JSON.parse(responseObject.data);

            if (responseObject.status === 'success') {
                var table = document.getElementById('pokeList');
                var tbody = table.getElementsByTagName('tbody')[0];
                tbody.innerHTML = ''; // Clear existing table data

                for (var i = 0; i < dataObject.length; i++) {
                    var record = dataObject[i];

                    var row = tbody.insertRow();
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);

                    cell1.innerHTML = record.email;
                    cell2.innerHTML = record.date;
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

function getPokedUsers() {
    $.ajax({
        type: 'GET',
        url: 'ajax.php',
        data: { data: 'poked'},
        success: function(response) {
            // Handle the server response
            var responseObject = JSON.parse(response);
            var dataObject = JSON.parse(responseObject.data);

            if (responseObject.status === 'success') {
                var table = document.getElementById('pokedList');
                var tbody = table.getElementsByTagName('tbody')[0];
                tbody.innerHTML = ''; // Clear existing table data

                for (var i = 0; i < dataObject.length; i++) {
                    var record = dataObject[i];

                    var row = tbody.insertRow();
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);

                    cell1.innerHTML = record.email;
                    cell2.innerHTML = record.date;
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

function getUserList(search) {
    $.ajax({
        type: 'GET',
        url: 'ajax.php',
        data: {
            data: 'list',
            limit: limit,
            offset: offset,
            search: search,
        },
        success: function(response) {
            var responseObject = JSON.parse(response);
            var dataObject = JSON.parse(responseObject.data);
            pages = Math.ceil(responseObject.meta/limit);
            if (responseObject.status === 'success') {
                var table = document.getElementById('userList');
                var tbody = table.getElementsByTagName('tbody')[0];
                tbody.innerHTML = ''; // Clear existing table data

                for (var i = 0; i < dataObject.length; i++) {
                    var record = dataObject[i];

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
                var pages = document.getElementById('userPages');
                pages.innerHTML = '<button onclick="changePage(-1)">Ankstesnis</button>&nbsp;<button onclick="changePage(1)">Sekantis</button>'
            } else {
                alert('Error: ' + data.message);
            }
        },
        error: function() {
            alert('An error occurred during the AJAX request.');
        }
    });
}

function changePage(direction) {
    offset = offset + (direction * limit);
    if (offset < 0) {
        offset = 0;
    }
    getUserList()
}

$(document).ready(function () {
    $('#searchForm').on('submit', function (event) {
        event.preventDefault();
        var search = $('#search').val();
        getUserList(search);
    });
});
