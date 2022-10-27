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
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/detail.css" />
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/nav.css">
        <link rel="icon" type="image/x-icon" href="<?php echo URL; ?>/layout/assets/img/favicon.png">
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
            <div class="container">
                <h1 class="title">Album Detail</h1>
                <div class="content">
                    <div class="user_content">
                        <img src="" alt="cover" id="cover" class="cover">
                        <div class="content-left">
                            <a class="judul" id="judul">Title: </a><br>
                            <div class="desc">
                                <a class="penyanyi" id="penyanyi">Artist: </a>
                                <a class="total_duration" id="total_duration">Total Duration: </a><br>
                            </div>
                        </div>
                    </div>

                    <div class="admin_content">
                        <form class="form_edit" id="form_edit" method="PUT" enctype="multipart/form-data">
                        <section>
                            <label> Title: </label>
                            <input type="text" name="judul" id="judul_edit" placeholder="Title"><br>
                        </section>
                        <section>
                            <label> Tanggal Terbit: </label>
                            <input type="date" name="tanggal_terbit" id="tanggal_terbit_edit" value="2022-10-28"  min="1960-01-01"><br>
                        </section>
                        <section>
                            <label> Genre: </label>
                            <input type="text" name="genre" id="genre_edit" placeholder="Genre"><br>
                        </section>
                            <label> Cover Image: </label>
                            <input type="file" name="cover_file" id="cover_file_edit" accept="image/jpg, image/jpeg, image/png"><br>
                        </form>
                        <button type="submit" id="button_submit" class="button" onclick={updateAlbum(event)}>
                            Submit
                        </button>
                        <button type="button" id="button_delete" class="button" onclick={deleteAlbum(event)}>
                            Delete
                        </button>
                    </div>
                </div>
                <table class="card">
                    <tr>
                        <th class="first-index">#</th>
                        <th>Judul</th>
                        <th>Genre</th>
                        <th>Duration</th>
                        <th>Tahun</th>
                        <th class="admin_content">Delete</th>
                    </tr>
                    <?php
                        $songs = new App\Service\SongService();
                        $query = $_GET['id'];
                        $result = $songs->getSongByAlbumId($query);
                        $count_data = count($result);
                        for($i = 0; $i < $count_data; $i++) {
                            $inc = $result[$i];
                            echo "<tr class='subcard' onClick={navigateTo('" . $inc[0] .  "')}>";
                            echo "<td class='index'>";
                            echo $i + 1;
                            echo "</td>";
                            echo "<td>";
                            echo "<div class='flex'>";
                            echo "<div class='main-content'>";
                            echo "<div>" . $inc["judul"] .  "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</td>";
                            echo "<td>";
                            echo "<div class='genre'>" . $inc["genre"] .  "</div>";
                            echo "</td>";
                            echo "<td>";
                            echo "<div class='duration'>" . floor($inc["duration"]/60)."m ". ($inc["duration"]%60). "s" .  "</div>";
                            echo "</td>";
                            echo "<td>";
                            echo "<div class='year'>" . substr($inc["tanggal_terbit"], 0, 4) . "</div>";
                            echo "</td>";
                            echo "<td class='admin_content'>";
                            echo "<button type='button' class='button admin_content' onclick={deleteSong('" . $inc[0] .  "')} > Delete </button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                </table>

                <div id="admin_content">
                        <form class="form_edit" id="form_edit" method="PUT" enctype="multipart/form-data">
                            <select class="selection" name="song_id" id="song_id">
                                <option value="">Select Song To Add</option>
                                <?php
                                    $songs = new App\Service\SongService();
                                    $result = $songs->readAll();
                                    $count_data = count($result);
                                    for($i = 0; $i < $count_data; $i++) {
                                        $data = $result[$i];
                                        if($data["album_id"] == "") {
                                            echo "<option value='$data[0]'>$data[1] - $data[2]</option>";
                                        }
                                        
                                    }
                                ?>
                            </select>
                        </form>
                        <button type="submit" id="button_submit" class="button" onclick={updateSongToAlbum(event)}>
                            Submit
                        </button>
                </div>
                <?php 
                    if (!$_SESSION["isAdmin"]) { ?>
                        <script>
                            document.getElementById("admin_content").style.display = "none";
                            var length = document.getElementsByClassName("admin_content").length;
                            for (var i = 0; i <= length; i++) {
                                document.getElementsByClassName("admin_content")[i].style.display = "none";
                            }
                        </script>
                <?php } ?>
            </div>
        </div>
        
    </body>

    <script>
        const xmlhttp = new XMLHttpRequest();
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const id = urlParams.get('id');

        xmlhttp.open("GET", `/getalbum?id=${id}`);
        xmlhttp.send();
        xmlhttp.onload = () => {
            const result = JSON.parse(xmlhttp.responseText);
            const album = result.data.album;
            const image = document.getElementById('cover');
            image.setAttribute('src', `/images?name=${album.image_path}`);
            document.getElementById('judul').innerHTML = `${album.judul}`;
            document.getElementById('penyanyi').innerHTML = `${album.penyanyi},`;
            // document.getElementById('tanggal_terbit').innerHTML = `Release date: ${album.tanggal_terbit}`;
            // document.getElementById('genre').innerHTML = `Genre: ${album.genre}`;
            document.getElementById('total_duration').innerHTML = `${Math.floor(album.total_duration/60)}m ${album.total_duration%60}s`;
        }
        
        const updateAlbum = (e) => {
            e.preventDefault();
            const judul = document.getElementById('judul_edit').value;
            const tanggal_terbit = document.getElementById('tanggal_terbit_edit').value;
            const genre = document.getElementById('genre_edit').value;
            const cover_file = document.getElementById('cover_file_edit').files[0];

            const formData = new FormData();
            formData.append('id', id);
            formData.append('judul', judul);
            formData.append('tanggal_terbit', tanggal_terbit);
            formData.append('genre', genre);
            formData.append('cover_file', cover_file);

            const xmlhttp = new XMLHttpRequest();
            xmlhttp.open("PUT", "updatealbum");
            xmlhttp.send(formData);
        }

        const deleteAlbum = (e) => {
            e.preventDefault();
            const xhr = new XMLHttpRequest();
            
            xhr.onload = () => {
                if (xhr.status==200){
                    window.location.href="/listalbum";
                } else{
                    let res = JSON.parse(xhr.responseText);
                    alert(res.error)
                }
            }

            xhr.open("DELETE", "deletealbum?id=" + id);
            xhr.send();
        }

        const updateSongToAlbum = (e) => {
            e.preventDefault();
            const song_id = document.getElementById('song_id').value;

            const payload={
                album_id: id,
                song_id: song_id
            }
            
            const xmlhttp = new XMLHttpRequest();

            xmlhttp.onload = () => {
                if (xmlhttp.status==200){
                    window.location.reload();
                } else{
                    let res = JSON.parse(xmlhttp.responseText);
                    alert(res.error)
                }
            }

            xmlhttp.open("PATCH", "updatesongtoalbum");
            xmlhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.send(JSON.stringify(payload));
        }

        const deleteSong = (song_id) => {
            const payload={
                song_id: song_id
            }

            const xmlhttp = new XMLHttpRequest();

            xmlhttp.onload = () => {
                if (xmlhttp.status==200){
                    window.location.reload();
                } else{
                    let res = JSON.parse(xmlhttp.responseText);
                    alert(res.error)
                }
            }

            xmlhttp.open("PATCH", "deletesongfromalbum");
            xmlhttp.send(JSON.stringify(payload));

            window.location.reload();
        }
        
        const navigateTo = (song_id) => {
            window.location.href = `/detailsong?id=${song_id}`;
        }
    </script>
</html>