
<?php

<<<<<<< Updated upstream
    //get data base connection 
    require('../config/database.php');
    //get data from html form obtener datos del cliente 

    $f_name =   $_POST['fname'];
    $l_name =   $_POST['lname'];
    $m_phone =  $_POST['mphone'];
    $e_email =  $_POST['email'];
    $p_assword = $_POST['pswd'];
    $pass_enc = md5($p_assword);

    // Insert into database hacer el insertar en la base de datos 
    $sql = "
        INSERT INTO users (
            firstname,
            lastname,
            mobile_phone,
            email,
            password
        )
        VALUES (
            '$f_name',
            '$l_name',
            '$m_phone',
            '$e_email',
            '$pass_enc'
        )
    ";
    $local_res= pg_query($local_conn,$sql);
    $supa_res= pg_query($supa_conn,$sql);

    if ($local_res){
        echo "<br>User has bean created succesfully into local database!!";
    }
    else
        echo"<br>User hasn't been created into local database!!";

    if ($supa_res){
        echo "<br>User has bean created succesfully into supa database!!";
    }
    else
        echo"<br>User hasn't been created into supa database!!";

    echo "<script>alert('User has been created succesfully :::')</script>";
    header('refresh:0;url=signin.html');
    //mostrar los datos 
    /*
    echo"<br>Fisrt name is: ". $f_name;
    echo"<br>Lastname is: ". $l_name;
    echo"<br>Mobile phone is: ". $m_phone;
    echo"<br>E-mail is: ". $e_email;
    echo"<br>password is: ". $p_assword;
*/
?>
=======
    //Get data from html form
    $f_name = $_POST['fname'];
    $l_name = $_POST['lname'];
    $m_phone = $_POST['mphone'];
    $e_mail = $_POST['email'];
    $p_assword = $_POST['pswd'];
    $p_assword = md5($p_assword);

    //Sql de validacion si el usuario existe
    $sql_validation = "
        SELECT
            u.email,
            u.mobile_phone
        FROM
            users u
        WHERE
            u.email = '$e_mail'
            OR u.mobile_phone = '$m_phone'
    ";

    $supa_res = pg_query($supa_conn, $sql_validation);

    if (pg_num_rows($supa_res) > 0) {

        $user = pg_fetch_assoc($supa_res);

        if ($user['email'] == $e_mail) {
            echo "<script>alert('User email already exists');</script>";
        } else {
            echo "<script>alert('Phone number already exists');</script>";
        }

        header('refresh:0;url=signup.html');

    } else {

        //Preparar query
        $sql = "
            INSERT INTO users (
                firstname, lastname, mobile_phone, email, password
            )
            VALUES (
                '$f_name', '$l_name', '$m_phone', '$e_mail', '$p_assword'
            )
        ";

        $supa_res = pg_query($supa_conn, $sql);

        if ($supa_res) {
            echo "<script>alert('Successful registration');</script>";
            header('refresh:0;url=signin.html');
        } else {
            echo "<script>alert('Error registering user');</script>";
            header('refresh:0;url=signup.html');
        }
    }
?>
>>>>>>> Stashed changes
