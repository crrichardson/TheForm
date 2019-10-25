<?php
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];  

    if (!empty($firstname) || !empty($lastname) || !empty($username) || !empty($email) || !empty($password) || !empty($gender)) {
        $host = 'localhost';
        $dbUsername = 'root';
        $dbPassword = '';
        $dbname = 'theform';

        //create connection
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

        if (mysqli_connect_error()) {
            die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());   
        }
        else {
            $SELECT = 'SELECT email From register Where email = ? Limit 1';
            $INSERT = 'INSERT Into register (firstname, lastname, username, email, password, gender) values (?, ?, ?, ?, ?, ?)';
        
            //Prepare statement
            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param('s', $email); 
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->store_result();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param('ssssss', $firstname, $lastname, $username, $email, $password, $gender);
                $stmt->execute();
                echo 'New record inserted successfully'; 
            }
            else {
                echo 'Email already used';
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo 'Answer all fields!';
        die();
    }
?>