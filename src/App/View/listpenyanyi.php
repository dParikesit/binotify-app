<?php
    defined('BASEPATH') OR exit('No direct access to script allowed');
?>
<?php include 'navbar.php';?>
<?php include 'sidebar.php';?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/listpenyanyi.css">
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/nav.css">
        <link rel="icon" type="image/x-icon" href="<?php echo URL; ?>/layout/assets/img/favicon.png">
        <title>Binotify</title>
    </head>

    <body>
        <?php
            $isAdmin = isset($_SESSION["isAdmin"]) ? $_SESSION["isAdmin"] : false;
            $username = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
            navbar($isAdmin, $username);
        ?>
        <div class="flex">
            <?php
                $isAdmin = isset($_SESSION["isAdmin"]) ? $_SESSION["isAdmin"] : false;
                sidebar($isAdmin);
            ?>
            <table class="card">
            <tr>
                <th class="first-index">#</th>
                <th>Nama Penyanyi</th>
                <th></th>
            </tr>
            <?php
                $songs = new App\Service\SongService();
                $count_data = count($songs->getSong());
                for($i = 0; $i < $count_data; $i++) {
                    $data = $songs->getSong()[$i];
                    echo "<tr class='subcard'>";
                    echo "<td class='index'>";
                    echo $i + 1;
                    echo "</td>";
                    echo "<td>";
                    echo "<div class='title'>" . $data[1] .  "</div>";
                    echo "</td>";
                    echo "<td>";
                    if(true) { // IF subscribe then see song
                        echo "<div class='button'>See Songs</div>";
                    } else {
                        echo "<div class='button'>Subscribe</div>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            ?>
        </table>
        </div>
    </body>
    <script>
        const navigateTo = (song_id) => {
            console.log(song_id);
            window.location.href = `/detailsong?id=${song_id}`;
        }
    </script>
</html>