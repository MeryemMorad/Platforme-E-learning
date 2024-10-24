<?php
include 'database/config.php';

// Check if 'group' is set, otherwise default to 'all'
$group = isset($_GET['group']) ? $_GET['group'] : 'all';

// SQL query based on the group parameter
switch ($group) {
    case 'teachers':
        $sql = "SELECT e.id_EN AS id, e.username, 'teacher' AS role 
                FROM enseignant e";
        break;
    case 'students':
        $sql = "SELECT e.id_E AS id, e.username, 'student' AS role 
                FROM etudiant e";
        break;
       
    
    case 'all':
    default:
        $sql = "SELECT e.id_E AS id, e.username, 'student' AS role 
                FROM etudiant e 
                UNION 
                SELECT e.id_EN AS id, e.username, 'teacher' AS role 
                FROM enseignant e 
                ";
        break;
}

// Execute the query if it's not empty
if (!empty($sql)) {
    $result = $conn->query($sql);

    // Check for query execution error
    if (!$result) {
        die('Query Error: ' . $conn->error);
    }

    if ($result->num_rows > 0) {
        // Loop through and display each user
        while ($row = $result->fetch_assoc()) {
            // Create a link with user ID and role in query parameters
            echo '
            <a href="form.php?user_id=' . htmlspecialchars($row['id']) . '&role=' . htmlspecialchars($row['role']) . '">
                <div class="user" data-id="' . htmlspecialchars($row['id']) . '">
                    <div class="user-img" style="background-image:url(\'user-image.png\');"></div>
                    <div class="user-info">
                        <span class="user-name">' . htmlspecialchars($row['username']) . '</span>
                        <span class="user-status">' . htmlspecialchars($row['role']) . '</span>
                    </div>
                </div>
            </a>';
        }
    } else {
        echo '<div>No users found</div>';
    }
} else {
    echo '<div>No valid group selected</div>';
}

// Close the database connection
$conn->close();
?>
