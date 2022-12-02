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
        const navigateTo = (creator_id) => {
            window.location.href = `/listsong?creator_id=${creator_id}`;
        }
        const subscribe = (creator_id) => {
            console.log(creator_id)
            const xhr4 = new XMLHttpRequest();
            xhr4.open("POST", `/addSubsReq`);
            xhr4.setRequestHeader("Content-type", "application/json");
            xhr4.send(JSON.stringify({creator_id}));
            xhr4.onload = function() {
                if (xhr4.status==200){
                    alert("Subscribed")
                }
            }
        }
        function merge(singer, subsList) {
            for (let i = 0; i < singer.length; i++) {
                for (let j = 0; j < subsList.length; j++) {
                    if (singer[i].creator_id === subsList[j].creator_id) {
                        singer[i].status = subsList[j].status;
                        break;
                    }
                }
            }
        }
        function render(result){
            let data = ""
            for(let i = 0; i < result.data.length; i++) {
                data = data.concat("<tr class='subcard'><td class='index'>");
                data = data.concat(i+1);
                data = data.concat("</td><td><div class='title'>");
                data = data.concat(result.data[i].name);
                data = data.concat("</div></td><td>");
                let status = result.data[i].status
                if(status == "ACCEPTED") {
                    data = data.concat("<div class='button' onClick={navigateTo('");
                    data = data.concat(result.data[i].creator_id);
                    data = data.concat("')}>See Songs</div>");
                } else if (status == "REJECTED") {
                    data = data.concat("<div class='button_notclick rejected'>REJECTED</div>")
                } else if (status == "PENDING") {
                    data = data.concat("<div class='button_notclick'>PENDING</div>")
                } else {
                    data = data.concat("<div class='button' onClick={subscribe('");
                    data = data.concat(result.data[i].creator_id);
                    data = data.concat("')}>Subscribe</div>");
                }
                data = data.concat("</td></tr>")
            }
            document.getElementById('listtable').innerHTML = data
        }

        let result = ""
        let old = ""

        const xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", `/singerPrem`);
        xmlhttp.send();
        xmlhttp.onload = () => {
            result = JSON.parse(xmlhttp.responseText);

            const xhr2 = new XMLHttpRequest();
            xhr2.open("GET", `/subStatusPHP`);
            xhr2.send();
            xhr2.onload = () => {
                old = JSON.parse(xhr2.responseText)
                merge(result.data, old.data)
                render(result);
            }

        }
        
        setInterval(() => {
            const xhr3 = new XMLHttpRequest();
            xhr3.open("GET", `/subStatusSOAP`);
            xhr3.send();
            xhr3.onload = () => {
                const result3 = JSON.parse(xhr3.responseText)
                merge(result.data, result3.data)
                render(result)

                result3.data.forEach(item => {
                    console.log(old.data.filter(x => x.creator_id === item.creator_id).length)
                    if (old.data.filter(x => x.creator_id === item.creator_id).length === 0) {
                        const xhr4 = new XMLHttpRequest();
                        xhr4.open("POST", `/addSubsSoap`);
                        xhr4.setRequestHeader("Content-type", "application/json");
                        xhr4.send(JSON.stringify({creator_id: item.creator_id}));
                        xhr4.onload = function() {
                            if (xhr4.status==200){
                                console.log("DB item added")
                            }
                        }
                    } else {
                        if (item.status !== old.data.find(x => x.creator_id === item.creator_id).status) {
                            const xhr4 = new XMLHttpRequest();
                            xhr4.open("POST", `/chStatus`);
                            xhr4.setRequestHeader("Content-type", "application/json");
                            xhr4.send(JSON.stringify(item));
                            xhr4.onload = function() {
                                if (xhr4.status==200){
                                    console.log("DB item updated")
                                }
                            }
                        }
                    }                    
                });
            }
        }, 3000);
        
    </script>
</html>