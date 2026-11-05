
<?php

    session_start();

    if(!isset($_SESSION['userId'])){
        header('Location: signin.html');
        exit;
    }else{
        $full_name = $_SESSION['fName'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    Username : <?php echo $full_name; ?>

    <a href="logout.php">logout</a>

</body>
</html>
