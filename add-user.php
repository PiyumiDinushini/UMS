<?php   session_start(); ?>
<?php
    require_once("inc/connection.php");
?>
<?php
    $errors=array();

    $first_name='';
    $last_name='';
    $email='';
    $password='';

    if(isset($_POST['submit'])){

        $first_name=$_POST['first_name'];
        $last_name=$_POST['last_name'];
        $email=$_POST['email'];
        $password=$_POST['password'];

        /*checking required fields
        if(empty(trim($_POST['first_name']))){
            $errors[]="First Name is required";
        }
        if(empty(trim($_POST['last_name']))){
            $errors[]="Last Name is required";
        }
        if(empty(trim($_POST['email']))){
            $errors[]="Email Address is required";
        }
        if(empty(trim($_POST['password']))){
            $errors[]="Password is required";
        }
        */

        //checking required fields
        $req_fields=array('first_name','last_name','email','password');

        foreach($req_fields  as $field){
            if(empty(trim($_POST[$field]))){
                $errors[]=$field ." is required";
            }
        }

        //checking max length
        $max_len_fields=array('first_name'=>50,'last_name'=>100,'email'=>100,'password'=>40);

        foreach($max_len_fields  as $field=>$max_len){
            if(strlen(trim($_POST[$field])) >$max_len){
                $errors[]=$field ." must be less than ".$max_len ." characters";
            }
        }

        //checking email address

        //checking if email address already exist here
        $email=mysqli_real_escape_string($connection,$_POST['email']);
        $query="SELECT * FROM user WHERE email='{$email}' LIMIT 1";
        
        $result_set=mysqli_query($connection,$query);

        if($result_set){
            if(mysqli_num_rows($result_set)==1){
                $errors[]="Email Address already exist";
            }
        }

        if(empty($errors)){
            //no errors found ... adding new record

            $first_name=mysqli_real_escape_string($connection,$_POST['first_name']);
            $last_name=mysqli_real_escape_string($connection,$_POST['last_name']);
            $password=mysqli_real_escape_string($connection,$_POST['password']);
      
            $hashed_password=sha1($password);

            $query="INSERT INTO user (first_name,last_name,email,password,is_deleted)
                    VALUES('{$first_name}','{$last_name}','{$email}','{$hashed_password}',0)";

            $result=mysqli_query($connection,$query);

            if($result){
                header('Location:users.php?user_added=true');
            }
            else{
                $errors="Fail to add new user";
            }


        }


    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <title>Add New User</title>
</head>
<body>

    <header>
        <div class="appname">User Management System</div>
        <div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?> ! <a href="logout.php">Log Out</a></div>
    </header>

    <main>
    <h2>Add New User <span><a href="users.php"> < Back to Users</a></span></h2>
    
    <?php

    if(!empty($errors)){
        echo "<div class='errmsg'>";
        echo "<b>There were errors on your form</b><br>";
        foreach($errors as $error){
            echo $error ."<br>";
        }
        echo "</div>";
    }

    ?>

    <form  action="add-user.php" method="POST" class="userform">
    <p>
    <label>First Name:</label>
    <input type="text" name="first_name" <?php echo 'value="' .$first_name .'"'; ?>>
    </p>
    <p>
    <label>Last Name:</label>
    <input type="text" name="last_name" <?php echo 'value="' .$last_name .'"'; ?>>
    </p>
    <p>
    <label>Email Address:</label>
    <input type="email" name="email" <?php echo 'value="' .$email .'"'; ?>>
    </p>
    <p>
    <p>
    <label>Password:</label>
    <input type="password" name="password" >
    </p>
    <p>
    <label>&nbsp;</label>
    <button type="submit" name="submit">Save</button>
    </p>
    </form>
    </main>
</body>
</html>