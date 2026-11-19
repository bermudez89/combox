
<?php
    // Get data base connection
    require('../config/database.php');

    // Get user ID and current status
    $id = $_GET['id'];
    $status = $_GET['status'];

    // Change user status
    $sql = 'UPDATE users
            SET status = $1
            WHERE id = $2';

    $result = pg_query_params(
        $local_conn,
        $sql,
        array($status, $id)
    );

    if (!$result) {
        echo "Error al cambiar el estado del usuario";
        exit;
    }

    // Redirect to user list
    header("Location: list_users.php");
    exit;
?>
