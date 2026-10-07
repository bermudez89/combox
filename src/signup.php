<?php
    //Get data base connection
    require('../config/database.php');

    //Get data from html form obtener datos del cliente 
    $f_name =   $_POST['fname'];
    $l_name =   $_POST['lname'];
    $m_phone =  $_POST['mphone'];
    $e_mail =  $_POST['email'];
    $p_assword = $_POST['pswd'];

    //Preparar query
    $sql = "
        INSERT INTO users (
            firstname, lastname, mobile_phone, email, password
        )
        VALUES (
            '$f_name', '$l_name', '$m_phone', '$e_mail', '$p_assword'
        )
    ";
    $local_res = pg_query($local_conn, $sql);
    $local_res = pg_query($supa_conn, $sql);

    if ($local_res){
        echo "User has been created seccessfully into local database !!!";
    } else {
        echo "User hasn't been created into local database !!!";
    }
    if ($supa_res){
        echo "User has been created seccessfully into supa database !!!";
    } else {
        echo "User hasn't been created into supa database !!!";
    }
    /*//mostrar los datos 
    echo"<br>Fisrt name is: ". $f_name;
    echo"<br>Lastname is: ". $l_name;
    echo"<br>Mobile phone is: ". $m_phone;
    echo"<br>E-mail is: ". $e_email;
    echo"<br>password is: ". $p_assword;
    */
?>