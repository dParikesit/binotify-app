<?php defined('BASEPATH') OR exit('No direct access to script allowed'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/home.css">
        <title>Binotify</title>
    </head>

    <body>
        <h1><?php echo $_POST["search"]; ?></h1>
        <table class="card">
            <tr>
                <th class="first-index">#</th>
                <th>Judul</th>
                <th>Genre</th>
                <th>Tahun</th>
            </tr>
            <?php
                $songs = new App\Service\SongService();
                $result = $songs->getSong();
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
    </body>

    <script>
        const nameOf = (f) => (f).toString();
        param = nameOf(() => <?php echo $_POST["search"]; ?>);
        const maxdata = 1;
        // const genre = ''
        const page = 0;
        const payload = {
            param,
            // genre,
            page,
            maxdata
        }
        console.log(payload)

        const xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST", "/App/Controller/SearchSong.php");
        xmlhttp.setRequestHeader("Content-type", "application/json");
        xmlhttp.send(JSON.stringify(payload));
    </script>
</html>