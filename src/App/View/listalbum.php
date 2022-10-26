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
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/listalbum.css">
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/home.css">
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/nav.css">
        <title>Binotify</title>
    </head>

    <body>
        <?php
            navbar($_SESSION["isAdmin"], $_SESSION["username"]);
        ?>
        <div class="flex">
            <?php
                sidebar($_SESSION["isAdmin"]);
            ?>
            <div class="flex-container">
                <?php
                    $albums = new App\Service\AlbumService();
                    $count_data = count($albums->readAll());
                    for($i = 0; $i < $count_data; $i++) {
                        $data = $albums->readAll()[$i];
                        echo "<div class='flex-item' onClick={testButton('" . $data["album_id"] .  "')}>";
                        echo "<div class='card'>";
                        echo "<img src='"."/images?name=". $data["image_path"] . "' width='225' />";
                        echo "<div class='title'>";
                        echo $data["judul"];
                        echo "</div>";
                        echo "<div class='content'>";
                        echo substr($data["tanggal_terbit"], 0, 4) . " . " . $data["penyanyi"] . " . " . $data["genre"];
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
    </body>
    <script>
        const testButton = (id) => {
            console.log("Keklik")
            console.log(id)
        }
    </script>
</html>