
<?php
    // Get data base connection
    require('../config/database.php');

    $sql = "
        SELECT
            id,
            firstname,
            lastname,
            mobile_phone,
            email,
            CASE
                WHEN u.status = true THEN 'Active'
                ELSE 'Inactive'
            END AS user_status,
            photo_url
        FROM users u
        ORDER BY lastname ASC;
    ";

    $res = pg_query($local_conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List users</title>

    <style>
        /* Same size for all boxes */
        .active, .inactive, .button {
            width: 105px;
            height: 32px;
            box-sizing: border-box;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
            font-size: 13px;
            text-decoration: none;
            white-space: nowrap;
            vertical-align: middle;
        }

        /* Active */
        .active {
            background-color: lightgreen;
            border: 1px solid green;
            color: black;
        }

        /* Inactive */
        .inactive {
            background-color: lightcoral;
            border: 1px solid red;
            color: black;
        }

        /* General button */
        .button {
            gap: 3px;
            color: black;
        }

        /* Search */
        .search {
            background-color: #cce5ff;
            border: 1px solid #007bff;
        }

        /* Edit */
        .edit {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
        }

        /* Delete */
        .delete {
            background-color: #f8d7da;
            border: 1px solid #dc3545;
        }

        /* Activate / Deactivate */
        .status-button {
            background-color: #e2e3e5;
            border: 1px solid #6c757d;
        }
    </style>
</head>

<body>

    <center><h3>List all users</h3></center>

    <table border="1" align="center" cellpadding="8">

        <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Mobile phone</th>
            <th>Email</th>
            <th>Status</th>
            <th>Photo</th>
            <th>...</th>
        </tr>

        <?php
            while($row = pg_fetch_assoc($res)){
        ?>

        <tr>
            <td><?php echo $row['firstname']; ?></td>
            <td><?php echo $row['lastname']; ?></td>
            <td><?php echo $row['mobile_phone']; ?></td>
            <td><?php echo $row['email']; ?></td>

            <td align="center">
                <?php if ($row['user_status'] == 'Active') { ?>
                    <span class="active">Active</span>
                <?php } else { ?>
                    <span class="inactive">Inactive</span>
                <?php } ?>
            </td>

            <td align="center">
                <?php if ($row['photo_url'] != "") { ?>
                    <img src="<?php echo $row['photo_url']; ?>"
                         width="50" height="50">
                <?php } else { ?>
                    Sin foto
                <?php } ?>
            </td>

            <td>
                <!-- Search -->
                <a class="button search"
                   href="view_user.php?id=<?php echo $row['id']; ?>">
                    <img src="icons/search.png" width="15">
                    Buscar
                </a>

                <!-- Edit -->
                <a class="button edit"
                   href="edit_user.php?id=<?php echo $row['id']; ?>">
                    <img src="icons/edit.png" width="15">
                    Editar
                </a>

                <!-- Delete -->
                <a class="button delete"
                   href="delete_user.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Are you sure you want to delete this user?');">
                    <img src="icons/delete.png" width="15">
                    Eliminar
                </a>

                <!-- Activate / Deactivate -->
                <?php if ($row['user_status'] == 'Active') { ?>

                    <a class="button status-button"
                       href="change_status.php?id=<?php echo $row['id']; ?>&status=false"
                       onclick="return confirm('Are you sure you want to deactivate this user?');">
                        Desactivar
                    </a>

                <?php } else { ?>

                    <a class="button status-button"
                       href="change_status.php?id=<?php echo $row['id']; ?>&status=true"
                       onclick="return confirm('Are you sure you want to activate this user?');">
                        Activar
                    </a>

                <?php } ?>
            </td>
        </tr>

        <?php
            }
        ?>

    </table>

</body>
</html>
