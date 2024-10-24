<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface de Messagerie</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        .nav-bar {
            background-color: #fff;
            padding: 10px 20px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }

        .nav-bar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .nav-bar li {
            margin-right: 20px;
            font-size: 14px;
            color: #555;
            cursor: pointer;
            padding: 5px 10px;
            border-bottom: 2px solid transparent;
        }

        .nav-bar li.active {
            border-bottom: 2px solid teal;
            color: teal;
        }

        .actions {
            display: flex;
            justify-content: flex-start;
            padding: 10px 20px;
            background-color: #fff;
        }

        .btn {
            border: none;
            padding: 8px 12px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 10px;
        }

        .btn.primary {
            background-color: teal;
            color: white;
        }

        .btn.secondary {
            background-color: #f0f0f0;
            color: #555;
        }

        .search-bar {
            padding: 10px 20px;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 -1px 2px rgba(0, 0, 0, 0.1);
        }

        .search-bar input {
            width: 100%;
            max-width: 400px;
            padding: 8px 12px;
            border-radius: 20px;
            border: 1px solid #ddd;
        }

        .user-list {
            padding: 10px 20px;
        }

        .user {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }

        .user:hover {
            background-color: #f0f0f0;
        }

        .user-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .user-info {
            flex-grow: 1;
        }

        .user-name {
            font-weight: bold;
            color: #333;
        }

        .user-status {
            color: #777;
        }

        .user-time {
            font-size: 12px;
            color: #aaa;
        }

        .message-form {
            display: none;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }

        .message-form input,
        .message-form textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .message-form .form-actions {
            display: flex;
            justify-content: flex-end;
        }

        .message-form .form-actions .btn {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    
    <div class="nav-bar">
        <ul>
            <li class="active" onclick="filterUsers('all')">ALL</li>
            <li onclick="filterUsers('teachers')">LES ENSEIGNANTS</li>
            <li onclick="filterUsers('students')">LES ÉTUDIANTS</li>
          
            
        </ul>
    </div>
    
    <div class="search-bar">
        <input type="text" placeholder="Rechercher des utilisateurs par nom.." onkeyup="searchUsers(this.value)">
    </div>
    <div class="user-list">
        <!-- Les utilisateurs filtrés seront affichés ici -->
    </div>
   
    <script>
        function filterUsers(group) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_users.php?group=' + group, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    document.querySelector('.user-list').innerHTML = this.responseText;
                    addClickEventToUsers();
                }
            }
            xhr.send();
        }

        function searchUsers(query) {
            const users = document.querySelectorAll('.user');
            users.forEach(user => {
                if (user.innerText.toLowerCase().includes(query.toLowerCase())) {
                    user.style.display = '';
                } else {
                    user.style.display = 'none';
                }
            });
        }

        function addClickEventToUsers() {
            const users = document.querySelectorAll('.user');
            users.forEach(user => {
                user.addEventListener('click', function() {
                    showMessageForm();
                });
            });
        }

        function showMessageForm() {
            document.querySelector('.message-form').style.display = 'block';
        }

        function hideMessageForm() {
            document.querySelector('.message-form').style.display = 'none';
        }

        // Load all users by default
        filterUsers('all');
    </script>
</body>
</html>
