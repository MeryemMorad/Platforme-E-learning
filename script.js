document.addEventListener('DOMContentLoaded', function () {
    const entriesSelect = document.getElementById('entries');
    const searchInput = document.getElementById('search');
    const rows = Array.from(document.querySelectorAll('tbody tr'));

    function updateTable() {
        const entries = parseInt(entriesSelect.value);
        const searchTerm = searchInput.value.toLowerCase();

        let count = 0;
        rows.forEach((row) => {
            const isVisible = Array.from(row.cells).some((cell) =>
                cell.textContent.toLowerCase().includes(searchTerm)
            );
            if (isVisible && count < entries) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });
    }

    entriesSelect.addEventListener('change', updateTable);
    searchInput.addEventListener('keyup', updateTable);

    updateTable(); // Initial call to set the correct number of rows

    
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.btn-edit'); // Update this selector as needed

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const username = this.getAttribute('data-username');
            const role = this.getAttribute('data-role');
            const status = this.getAttribute('data-status');
            document.getElementById('editId').value = id;
            document.getElementById('editUsername').value = username;
            document.getElementById('editRole').value = role;
            document.getElementById('editStatus').value = status;
        });
    });
});
const addUserBtn = document.getElementById('addUserBtn');
    const modal = document.getElementById('addUserModal');
    const closeBtn = document.getElementsByClassName('close')[0];

    addUserBtn.addEventListener('click', function () {
        modal.style.display = 'block';
    });

    closeBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });

    document.getElementById('addUserForm').addEventListener('submit', function (event) {
        event.preventDefault();

        // Get form data
        const formData = new FormData(event.target);

        // AJAX request to add user (replace URL with your actual endpoint)
        fetch('add_user_endpoint.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('User added successfully');
                modal.style.display = 'none';
                // Optionally, refresh the user table or add the new user row dynamically
            } else {
                alert('Error adding user: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    fetch('count_user.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('etudiant-count').textContent = data.etudiant;
            document.getElementById('enseignant-count').textContent = data.enseignant;
            document.getElementById('facilitateur-count').textContent = data.facilitateur;
          
        })
        .catch(error => console.error('Error fetching user counts:', error));
});
$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: '2017-03-01',
        editable: true,
        events: [
            {
                title: 'All Day Event',
                start: '2017-03-01'
            },
            {
                title: 'Long Event',
                start: '2017-03-07',
                end: '2017-03-10'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2017-03-09T16:00:00'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2017-03-16T16:00:00'
            },
            {
                title: 'Conference',
                start: '2017-03-11',
                end: '2017-03-13'
            },
            {
                title: 'Meeting',
                start: '2017-03-12T10:30:00',
                end: '2017-03-12T12:30:00'
            },
            {
                title: 'Lunch',
                start: '2017-03-12T12:00:00'
            },
            {
                title: 'Meeting',
                start: '2017-03-12T14:30:00'
            },
            {
                title: 'Happy Hour',
                start: '2017-03-12T17:30:00'
            },
            {
                title: 'Dinner',
                start: '2017-03-12T20:00:00'
            },
            {
                title: 'Birthday Party',
                start: '2017-03-13T07:00:00'
            },
            {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2017-03-28'
            }
        ]
    });
});
//SLIDER

