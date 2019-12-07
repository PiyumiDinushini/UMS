<?php   session_start(); ?>
<?php
    require_once("inc/connection.php");
?>
<?php
    //checking if user logged in
    if(!isset($_SESSION['user_id'])){
        header('Location:index.php');
    }

    $user_list='';

    //getting the list of users

    $query="SELECT * FROM user WHERE is_deleted=0 ORDER BY first_name";

    $users=mysqli_query($connection,$query);

    if($users){
        while($user=mysqli_fetch_assoc($users)){
            $user_list .="<tr>";
            $user_list .="<td>{$user['first_name']}</td>";
            $user_list .="<td>{$user['last_name']}</td>";
            $user_list .="<td>{$user['last_login']}</td>";
            $user_list .="<td><a href=\"modify-user.php?user_id={$user['id']}\">Edit</a></td>";
            $user_list .="<td><a href=\"delete-user.php?user_id={$user['id']}\">Delete</a></td>";

        }
    }
    else{
        echo "Database query faild";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <title>Users</title>
</head>
<body>

    <header>
        <div class="appname">User Management System</div>
        <div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?> ! <a href="logout.php">Log Out</a></div>
    </header>

    <main>
    <h2>Users <span><a href="add-user.php">Add New</a></span></h2>
    
    <table class="masterlist">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Last Login</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>

        <?php  echo $user_list; ?>


    </table>
    </main>
</body>
</html>