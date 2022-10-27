<?php defined('BASEPATH') OR exit('No direct access to script allowed'); 
    if (!isset($_SESSION["user_id"])) {
        header("Location: "."/login");
    }

    if (!isset($_SESSION["isAdmin"]) || !$_SESSION["isAdmin"] == true) {
        header("Location: "."/");
    }
?>

<?php include 'navbar.php';?>
<?php include 'sidebar.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/listuser.css" />
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/nav.css" />
        <link rel="icon" type="image/x-icon" href="<?php echo URL; ?>/layout/assets/img/favicon.png">
        <title>Binotify</title>
</head>
<body>
    <?php
        navbar($_SESSION["isAdmin"], $_SESSION["username"]);
    ?>
    <div class="users-list">
        <?php
            sidebar($_SESSION["isAdmin"]);
        ?>
        <div class="container">
            <h1 class="list-of-users">List of Users</h1>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>E-mail</th>
                </tr>
                <?php
                    $user = new App\Service\UserService();
                    $result = $user->readAll();
                    $count_data = count($result);
                    for($i = 0; $i < $count_data; $i++) {
                        $data = $result[$i];
                        echo "<tr class='subcard'>";
                        echo "<td class='username'>" . $data[1] . "</td>";
                        echo "<td class='username'>" . $data[4] . "</td>";
                        echo "<td class='email'>" . $data[2] . "</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
    </div>
    <table>
</body>
</html>