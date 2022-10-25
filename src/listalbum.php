<?php defined('BASEPATH') OR exit('No direct access to script allowed'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/listalbum.css">
        <title>Binotify</title>
    </head>

    <body>
  <!--       <?php
            $albums = new App\Service\AlbumService();
            $count_data = count($albums->readAll()["Data"]);
        ?> -->
<!--         <div class="flex-container">
            <div class="card">
                <img src="https://i.scdn.co/image/ab67616d0000b2739abdf14e6058bd3903686148" width="225" />
                <div class="title">
                    1989
                </div>
                <div class="content">
                    2014 . Taylor Swift . Pop
                </div>
            </div>
            <div class="card">
                <img src="https://i.scdn.co/image/ab67616d0000b2739abdf14e6058bd3903686148" width="225" />
                <div class="title">
                    1989
                </div>
                <div class="content">
                    2014 . Taylor Swift . Pop
                </div>
            </div>
            <div class="card">
                <img src="https://i.scdn.co/image/ab67616d0000b2739abdf14e6058bd3903686148" width="225" />
                <div class="title">
                    1989
                </div>
                <div class="content">
                    2014 . Taylor Swift . Pop
                </div>
            </div>
            <div class="card">
                <img src="https://i.scdn.co/image/ab67616d0000b2739abdf14e6058bd3903686148" width="225" />
                <div class="title">
                    1989
                </div>
                <div class="content">
                    2014 . Taylor Swift . Pop
                </div>
            </div>
            <div class="card">
                <img src="https://i.scdn.co/image/ab67616d0000b2739abdf14e6058bd3903686148" width="225" />
                <div class="title">
                    1989
                </div>
                <div class="content">
                    2014 . Taylor Swift . Pop
                </div>
            </div>
            <div class="card">
                <img src="https://i.scdn.co/image/ab67616d0000b2739abdf14e6058bd3903686148" width="225" />
                <div class="title">
                    1989
                </div>
                <div class="content">
                    2014 . Taylor Swift . Pop
                </div>
            </div>
            <div class="card">
                <img src="https://i.scdn.co/image/ab67616d0000b2739abdf14e6058bd3903686148" width="225" />
                <div class="title">
                    1989
                </div>
                <div class="content">
                    2014 . Taylor Swift . Pop
                </div>
            </div>
        </div> -->
        <div class="flex-container">
            <?php
                $albums = new App\Service\AlbumService();
                $count_data = count($albums->readAll()["Data"]);
                for($i = 0; $i < $count_data; $i++) {
                    $data = $albums->readAll()["Data"][$i];
                    echo "<div class='flex-item' onClick={testButton(" . $data[0] .  ")}>";
                    echo "<div class='card'>";
                    // echo "<img src='" . $data["Image_path"] . "' width='225' />";
                    echo "<img src='https://i.scdn.co/image/ab67616d0000b2739abdf14e6058bd3903686148' width='225' />";
                    echo "<div class='title'>";
                    echo $data[1];
                    echo "</div>";
                    echo "<div class='content'>";
                    echo substr($data[5], 0, 4) . " . " . $data[2] . " . " . $data[6];
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            ?>
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