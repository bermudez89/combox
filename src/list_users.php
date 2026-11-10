<?php
    //get data base connection 
    require('../config/database.php');
    $sql = "
    select
        firstname,
        lastname,
        mobile_phone,
        email,
        case 
		    when u.status = true then 'Active' else 'Inactive'
	    end as user_status,
        photo_url
    from 
        users u
    order by 
        lastname asc;
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
    <table border="1" align="center">
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
                echo "<tr>";
                echo "<td>". $row['firstname']. "</td>";
                echo "<td>". $row['lastname']. "</td>";
                echo "<td>". $row['mobile_phone']. "</td>";
                echo "<td>". $row['email']. "</td>";
                echo "<td>". $row['user_status']. "</td>";
                echo "<td align='center'><img src ='". $row['photo_url']. "' width= '30'></td>";
                echo "<td>
                        <img src = 'icons/search.png' width='15'>&nbsp;&nbsp;
                        <img src = 'icons/edit.png' width='15'>&nbsp;&nbsp;
                        <img src = 'icons/delete.png' width='15'>
                    </td>
                ";
                echo "</tr>";
            }
        ?>
</body>
</html>