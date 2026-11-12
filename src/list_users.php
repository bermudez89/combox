
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
            <td><?php echo $row['user_status']; ?></td>

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
                    <a href="view_user.php?id=<?php echo $row['id']; ?>">
                        <img src="icons/search.png" width="15">
                </a>&nbsp;&nbsp;

            <!-- Edit -->
            <a href="edit_user.php?id=<?php echo $row['id']; ?>">
                <img src="icons/edit.png" width="15">
            </a>&nbsp;&nbsp;

            <!-- Delete -->
            <a href="delete_user.php?id=<?php echo $row['id']; ?>"
       onclick="return confirm('Are you sure you want to delete this user?');">
             <img src="icons/delete.png" width="15">
            </a>
        </td>

        </tr>

        <?php
            }
        ?>

    </table>

</body>
</html>
