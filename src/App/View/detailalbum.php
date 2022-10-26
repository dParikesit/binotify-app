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
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/detailpage.css" />
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
            <div class="container">
                <h1 class="title">Album Detail</h1>
                <div class="content">
                    <div class="user_content">
                        <img src="" alt="cover" id="cover" class="cover">
                        <div class="content-left">
                            <a class="judul" id="judul">Title: </a><br>
                            <a class="penyanyi" id="penyanyi">Artist: </a><br>
                            <a class="total_duration" id="total_duration">Total Duration: </a><br>
                        </div>
                    </div>
                    <div class="admin_content">
                        <form class="form_edit" id="form_edit" method="PUT" enctype="multipart/form-data">
                        <section>
                            <label> Title: </label>
                            <input type="text" name="judul" id="judul_edit" placeholder="Title"><br>
                        </section>
                        <section>
                            <label> Artist: </label>
                            <input type="text" name="penyanyi" id="penyanyi_edit" placeholder="Artist"><br>
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
                            <input type="file" name="audio_file" id="audio_file_edit" accept="audio/mp3, audio/wav, audio/ogg"><br>
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
                    </tr>
                    <?php
                        $songs = new App\Service\SongService();
                        $query = $_GET['id'];
                        $result = $songs->getSongByAlbumId($query);
                        $count_data = count($result);
                        for($i = 0; $i < $count_data; $i++) {
                            $inc = $result[$i];
                            echo "<tr class='subcard' onClick={deleteSong(" . $inc[0] .  ")}>";
                            echo "<td class='index'>";
                            echo $i + 1;
                            echo "</td>";
                            echo "<td>";
                            echo "<div class='flex'>";
                            echo "<div class='main-content'>";
                            echo "<div class='title'>" . $inc["judul"] .  "</div>";
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
                            echo "</tr>";
                        }
                    ?>
                </table>
                <div>
                        <form class="form_edit" id="form_edit" method="PUT" enctype="multipart/form-data">
                            <select class="selection" name="song_id" id="song_id">
                                <option value="">Select Song To Add</option>
                                <?php
                                    $songs = new App\Service\SongService();
                                    $result = $songs->readAll();
                                    $count_data = count($result);
                                    for($i = 0; $i < $count_data; $i++) {
                                        $data = $result[$i];
                                        if($data["album_id"] != $_GET['id']) {
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
            console.log(xmlhttp.responseText);
            const result = JSON.parse(xmlhttp.responseText);
            const album = result.data.album;
            console.log(album)
            const image = document.getElementById('cover');
            image.setAttribute('src', `/images?name=${album.image_path}`);
            document.getElementById('judul').innerHTML = `Title: ${album.judul}`;
            document.getElementById('penyanyi').innerHTML = `Singer: ${album.penyanyi}`;
            // document.getElementById('tanggal_terbit').innerHTML = `Release date: ${album.tanggal_terbit}`;
            // document.getElementById('genre').innerHTML = `Genre: ${album.genre}`;
            document.getElementById('total_duration').innerHTML = `Duration: ${Math.floor(album.total_duration/60)}m ${album.total_duration%60}s`;
        }
        /*
        const updateAlbum = (e) => {
            e.preventDefault();
            const judul = document.getElementById('judul_edit').value;
            const penyanyi = document.getElementById('penyanyi_edit').value;
            const tanggal_terbit = document.getElementById('tanggal_terbit_edit').value;
            const genre = document.getElementById('genre_edit').value;
            const cover_file = document.getElementById('cover_file_edit').files[0]
            // need to handle get total duration from all song
            // const payload = {
            //     judul,
            //     penyanyi,
            //     tanggal_terbit,
            //     genre,
            //     cover_file,
            //     duration,
            // }
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.open("PUT", "updatealbum?id=" + myParam);
            xmlhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.send(JSON.stringify(payload));
        }

        const deleteAlbum = (e) => {
            e.preventDefault();
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.open("DELETE", "deletealbum?id=" + myParam);
            xmlhttp.send();

            window.location.href = "/index.php";
        }

        const updateSongToAlbum = (e) => {
            e.preventDefault();
            const song_id = document.getElementById('song_id').value;
            // need to get duration from song and album
            // const payload = {
            //     song_id,
            //     album_id,
            //     total_duration
            // }
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.open("PUT", "updatesongtoalbum?id=" + myParam);
            xmlhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.send(JSON.stringify(payload));
        }

        const deleteSong = (id) => {
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.open("PUT", "deletesongfromalbum?id=" + id);
            xmlhttp.send();

            window.location.reload();
        } */
    </script>
</html>