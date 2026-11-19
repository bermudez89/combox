
<?php
    // Get data base connection
    require('../config/database.php');

    // Get user ID from URL
    $id = $_GET['id'];

    // Delete user
    $sql = 'DELETE FROM users WHERE id = $1';

    $result = pg_query_params(
        $local_conn,
        $sql,
        array($id)
    );

    if (!$result) {
        echo "Error al eliminar el usuario";
        exit;
    }

    // Redirect to user list
    header("Location: list_users.php");
    exit;
?>
