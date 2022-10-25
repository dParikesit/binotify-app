<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        <link rel="stylesheet" href="./layout/assets/css/users.css" />
        <title>Binotify</title>
</head>
<body>
    <h1 class="list-of-users">List of Users</h1>
    <div class="users-list">
        <table>
            <tr>
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
                    echo "<td class='username'>" . $data[3] . "</td>";
                    echo "<td class='email'>" . $data[1] . "</td>";
                    echo "</tr>";
                }
            ?>
        </table>
            
    </div></div>
    <table>
</body>
</html>