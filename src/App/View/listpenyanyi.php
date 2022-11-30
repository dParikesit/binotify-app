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
            <tbody id="listtable"></tbody>
        </table>
        </div>
    </body>
    <script>
        let data = ''
        const xmlhttp = new XMLHttpRequest();

        xmlhttp.open("GET", `http://localhost:3002/api/listpenyanyi`);
        xmlhttp.send();
        let status = "ACCEPTED" // TODO: Intgrate
        xmlhttp.onload = () => {
            const result = JSON.parse(xmlhttp.responseText);
            console.log(result)
            for(let i = 0; i < result.data.length; i++) {
                data = data.concat("<tr class='subcard'><td class='index'>");
                let index = i + 1
                data = data.concat(index.toString(2));
                data = data.concat("</td><td><div class='title'>");
                data = data.concat(result.data[i].name);
                data = data.concat("</div></td><td>");
                if(status == "ACCEPTED") {
                    data = data.concat("<div class='button' onClick={navigateTo('");
                    data = data.concat(result.data[i].id);
                    data = data.concat("')}>See Songs</div>");
                } else if (status == "REJECTED") {
                    data = data.concat("<div class='button_notclick'>REJECTED</div>")
                } else if (status == "PENDING") {
                    data = data.concat("<div class='button_notclick'>PENDING</div>")
                } else {
                    data = data.concat("<div class='button'>Subscribe</div>")
                }
                data = data.concat("</td></tr>")
            }
            document.getElementById('listtable').innerHTML = data;
        }
        
        const navigateTo = (song_id) => {
            console.log(song_id);
            window.location.href = `/listsong?song_id=${song_id}`; // TODO
        }
    </script>
</html>