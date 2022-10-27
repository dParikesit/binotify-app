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
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/search.css">
        <link rel="icon" type="image/x-icon" href="<?php echo URL; ?>/layout/assets/img/favicon.png">
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
            <div class="main-content">
                <div class="flex filter-bar">
                    <form class="filter" method="get" action="/search">
                        <label class="hide" for="search">Search</label>
                        <input
                        class="hide"
                        type="search"
                        name="search"
                        id="search"
                        placeholder="What's on your mind?"
                        value="<?php echo $_GET["search"]; ?>"
                        />
                        <input
                        class="hide"
                        name="page"
                        id="page"
                        value="<?php 
                        echo 0
                        ?>"
                        />
                        <input
                        class="genre"
                        type="genre"
                        name="genre"
                        id="genre"
                        placeholder="Mau genre apa?"
                        />
                        <label class="label-order" for="order">Order by:</label>
                        <select id="order" name="order" class="order">
                            <option value="Judul">Judul</option>
                            <option value="Tanggal_terbit">Tahun</option>
                        </select>
                        <label class="label-sort" for="sort">Sort:</label>
                        <select id="sort" name="sort" class="sort">
                            <option value="true">ASC</option>
                            <option value="false">DESC</option>
                        </select>
                        <input type="submit" class="submit">
                    </form>
                </div>
                <table class="card">
                    <tr>
                        <th class="first-index">#</th>
                        <th>Judul</th>
                        <th>Genre</th>
                        <th>Tahun</th>
                    </tr>
                    <?php
                        $maxdata = 2;
                        $page = isset($_GET["page"]) && $_GET["page"] != '' ? $_GET["page"] * $maxdata : 0;
                        $param = $_GET["search"];
                        $tahun;
                        if(ctype_digit($param)) {
                            $tahun = $param;
                        } else {
                            $tahun = 0;
                        }
                        $order = isset($_GET["order"]) && $_GET["order"] != '' ? $_GET["order"] : null;
                        $sort = isset($_GET["sort"]) && $_GET["sort"] != '' ? $_GET["sort"] : null;
                        $genre = isset($_GET["genre"]) && $_GET["genre"] != '' ? $_GET["genre"] : null;
                        $songs = new App\Service\SongService();
                        $result = $songs->getSongByParam($param, $tahun, $genre, $order, $sort, $page, $maxdata);
                        $count_data = count($songs->getSongByParam($param, $tahun, $genre, $order, $sort, $page, $maxdata));
                        echo $count_data;
                        for($i = 0; $i < $count_data; $i++) {
                            $data = $songs->getSongByParam($param, $tahun, $genre, $order, $sort, $page, $maxdata)[$i];
                            echo "<tr class='subcard' onClick={testButton(" . $data[0] .  ")}>";
                            echo "<td class='index'>";
                            echo $i + 1 + $page;
                            echo "</td>";
                            echo "<td>";
                            echo "<div class='flex wrapping-content'>";
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
                <div class="flex floatright">
                <form class="leftbutton" method="get" action="/search">
                        <label class="hide" for="page">Search</label>
                        <input
                            class="hide" name="page"
                            value="<?php 
                            if (isset($_GET["page"]) && $_GET["page"] > 0) {
                                echo $_GET["page"] - 1;
                            } else {
                                echo 0;
                            }
                            ?>"
                        />
                        <input
                        class="hide"
                        name="search"
                        value="<?php echo $_GET["search"]; ?>"
                        />
                        <input
                        class="hide"
                        name="genre"
                        value="<?php
                        if (isset($_GET["genre"])) {
                            echo $_GET["genre"];
                        } else {
                            echo "";
                        } 
                        ?>"
                        />
                        <input
                        class="hide"
                        name="sort"
                        value="<?php 
                        if (isset($_GET["sort"])) {
                            echo $_GET["sort"];
                        } else {
                            echo "true";
                        }
                        ?>"
                        />
                        <input
                        class="hide"
                        name="order"
                        value="<?php 
                        if (isset($_GET["order"])) {
                            echo $_GET["order"];
                        } else {
                            echo "Judul";
                        }
                        ?>"
                        />
                        <input type="submit" value="<" class="before">
                    </form>
                    <form class="rightbutton" method="get" action="/search">
                        <label class="hide" for="page">Search</label>
                        <input
                            class="hide" name="page"
                            value="<?php 
                            if(isset($_GET["page"]) && $_GET["page"] != '' && $count_data == $maxdata) {
                                echo $_GET["page"] + 1;
                            } else if (isset($_GET["page"]) && $_GET["page"] != '' && $count_data < $maxdata) {
                                echo $_GET["page"];
                            } else {
                                echo 0;
                            }
                            ?>"
                        />
                        <input
                        class="hide" name="search"
                        value="<?php echo $_GET["search"]; ?>"
                        />
                        <input
                        class="hide" name="genre"
                        value="<?php
                        if (isset($_GET["genre"])) {
                            echo $_GET["genre"];
                        } else {
                            echo "";
                        } 
                        ?>"
                        />
                        <input
                        class="hide" name="sort"
                        value="<?php 
                        if (isset($_GET["sort"])) {
                            echo $_GET["sort"];
                        } else {
                            echo "true";
                        }
                        ?>"
                        />
                        <input
                        class="hide" name="order"
                        value="<?php 
                        if (isset($_GET["order"])) {
                            echo $_GET["order"];
                        } else {
                            echo "Judul";
                        }
                        ?>"
                        />
                        <input type="submit" value=">" class="after">
                    </form>
                </div>
            </div>
        </div>
    </body>

    <script>
    </script>
</html>