<?php
    // Get data base connection
    require('../config/database.php');

    // Get user ID from URL
    $id = $_GET['id'];

    // Search user
    $sql = 'SELECT * FROM users WHERE id = $1';

    $result = pg_query_params($local_conn, $sql, array($id));

    // Get user information
    $user = pg_fetch_assoc($result);

    if (!$user) {
        die("User not found");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar usuario</title>
</head>
<body>

    <h1>Editar usuario</h1>

    <form action="update_user.php" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id"
               value="<?php echo htmlspecialchars($user['id']); ?>">

        <label>Nombre</label><br>
        <input type="text" name="firstname"
               value="<?php echo htmlspecialchars($user['firstname']); ?>"
               required><br><br>

        <label>Apellido</label><br>
        <input type="text" name="lastname"
               value="<?php echo htmlspecialchars($user['lastname']); ?>"
               required><br><br>

        <label>Correo</label><br>
        <input type="email" name="email"
               value="<?php echo htmlspecialchars($user['email']); ?>"
               required><br><br>

        <label>Celular</label><br>
        <input type="text" name="mobile_phone"
               value="<?php echo htmlspecialchars($user['mobile_phone']); ?>"
               required><br><br>
               <label>Estado del usuario</label><br>


        <?php if ($user['photo_url'] != "") { ?>

            <p>Foto actual:</p>

            <img src="<?php echo htmlspecialchars($user['photo_url']); ?>"
                 width="120"><br><br>

        <?php } ?>

        <label>Foto (JPG o PNG)</label><br>
        <input type="file" name="photo"
               accept=".jpg,.jpeg,.png"><br><br>

        <button type="submit">Guardar</button>

        <a href="list_users.php">Cancelar</a>

    </form>

</body>
</html>