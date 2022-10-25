<?php
    defined('BASEPATH') OR exit('No direct access to script allowed');
    if (!isset($_SESSION["user_id"])) {
        header("Location: "."/login");
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
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/home.css">
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/navbar.css">
        <title>Binotify</title>
    </head>

    <body>
        <?php
            navbar(true, "USERNAME");
        ?>
        <div class="flex">
            <?php
                sidebar(true, "USERNAME");
            ?>
            <table class="card">
            <tr>
                <th class="first-index">#</th>
                <th>Judul</th>
                <th>Genre</th>
                <th>Tahun</th>
            </tr>
            <?php
                $songs = new App\Service\SongService();
                $count_data = count($songs->getSong()["Data"]);
                for($i = 0; $i < $count_data; $i++) {
                    $data = $songs->getSong()["Data"][$i];
                    echo "<tr class='subcard' onClick={testButton(" . $data[0] .  ")}>";
                    echo "<td class='index'>";
                    echo $i + 1;
                    echo "</td>";
                    echo "<td>";
                    echo "<div class='flex'>";
                    // echo "<img src='" . $data[7] .  "' width='50' alt='song' />";
                    echo "<img src='https://i.scdn.co/image/ab67616d0000b2739abdf14e6058bd3903686148' width='50' alt='song' />";
                    echo "<div class='main-content'>";
                    echo "<div class='title'>" . $data[1] .  "</div>";
                    echo "<div class='writer'>" . $data[2] . "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</td>";
                    echo "<td>";
                    echo "<div class='genre'>" . $data[4] .  "</div>";
                    echo "</td>";
                    echo "<td>";
                    echo "<div class='year'>" . substr($data[3], 0, 4) . "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
            ?>
        </table>
        </div>
    </body>
    <script>
        // TODO: Integrate function to go to detail song page using id
        const testButton = (id) => {
            console.log("Keklik")
            console.log(id)
        }
    </script>
</html>