<?php
    defined('BASEPATH') OR exit('No direct access to script allowed');
    if (!isset($_SESSION["user_id"])) {
        header("Location: "."/login");
    }

    if (!isset($_SESSION["isAdmin"]) || !$_SESSION["isAdmin"] == false) {
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
                <th>Judul</th>
                <th>Play</th>
            </tr>
            <tbody id="listtable"></tbody>
        </table>
        </div>
    </body>
    <script>
        let list_creatorid;
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "/getsubscribed");
        xhr.send();
        xhr.onload = () => {
            const result = JSON.parse(xhr.responseText);
            list_creatorid = result.data;
        }
        
        let data = '';
        const xmlhttp = new XMLHttpRequest();

        for (let i = 0; i < list_creatorid.length; i++) {
            xmlhttp.open("GET", `http://localhost:3002/api/songs/penyanyi/${list_creatorid[i]}`);
            xmlhttp.send();
            xmlhttp.onload = () => {
                const result = JSON.parse(xmlhttp.responseText);
                for (let j = 0; j < result.data.length; j++) {
                    data = data.concat('<tr>');
                    data = data.concat('<td>'+result.data[j].title+'</td>');
                    data = data.concat('<td><audio class="audio_source" id="audio" controls><source src='+result.data[j].audio_path+' id="audio_source"></audio></td>');
                    data = data.concat('</tr>');
                }
            }
        }
        xmlhttp.onload = () => {
            document.getElementById("listtable").innerHTML = data;
        }
    </script>
</html>