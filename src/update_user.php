
<?php
    // Get data base connection
    require('../config/database.php');

    // Data received from the form
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $mobile_phone = $_POST['mobile_phone'];

    // ---------- VALIDATE EMAIL ----------

    $sql = 'SELECT id FROM users
            WHERE email = $1 AND id != $2';

    $result = pg_query_params(
        $local_conn,
        $sql,
        array($email, $id)
    );

    if (pg_num_rows($result) > 0) {
        echo "<script>
                alert('Error: este correo ya existe');
                window.location.href = 'edit_user.php?id=$id';
              </script>";
        exit;
    }

    // ---------- PART A: Update user data ----------

    $sql = 'UPDATE users
        SET firstname = $1,
            lastname = $2,
            email = $3,
            mobile_phone = $4
        WHERE id = $5';

$result = pg_query_params(
    $local_conn,
    $sql,
    array($firstname, $lastname, $email, $mobile_phone, $id)
);

    if (!$result) {
        echo "Error al actualizar los datos";
        exit;
    }

    // ---------- PART B: Upload photo ----------

    if ($_FILES['photo']['name'] != "") {

        // Get file extension
        $ext = strtolower(pathinfo(
            $_FILES['photo']['name'],
            PATHINFO_EXTENSION
        ));

        if ($ext == "jpg" || $ext == "jpeg" || $ext == "png") {

            if ($_FILES['photo']['error'] != UPLOAD_ERR_OK) {
                echo "Error al subir la foto";
                exit;
            }

            // Photo name = mobile phone + extension
            $photo_url = "photos/" . $mobile_phone . "." . $ext;

            // Move photo to src/photos
            if (move_uploaded_file(
                $_FILES['photo']['tmp_name'],
                __DIR__ . "/" . $photo_url
            )) {

                // Update photo URL in database
                $sql = 'UPDATE users
                        SET photo_url = $1
                        WHERE id = $2';

                $result = pg_query_params(
                    $local_conn,
                    $sql,
                    array($photo_url, $id)
                );

                if (!$result) {
                    echo "Error al actualizar la foto en la base de datos";
                    exit;
                }

            } else {
                echo "No se pudo guardar la foto. Revisa la carpeta photos.";
                exit;
            }

        } else {
            echo "Solo se permiten fotos JPG o PNG.
                  <a href='edit_user.php?id=$id'>Volver</a>";
            exit;
        }
    }

    // ---------- PART C: Redirect to user list ----------

    header("Location: list_users.php");
    exit;
?>
