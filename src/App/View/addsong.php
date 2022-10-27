<?php defined('BASEPATH') OR exit('No direct access to script allowed'); 
    if (!isset($_SESSION["user_id"])) {
        header("Location: "."/login");
    }

    if (!isset($_SESSION["isAdmin"]) || !$_SESSION["isAdmin"] == true) {
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
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/addpage.css" />
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
            <div class="content">
                <h1 class="title" id="title">Add Song</h1>
                <form class="form_edit" id="form_edit" method="PUT" enctype="multipart/form-data">
                    <label>
                        Title : 
                        <input class="input" type="text" name="judul" id="judul" placeholder="Title" required>
                    </label>
                    <br>
                    <label>
                        Artist :
                        <input class="input" type="text" name="penyanyi" id="penyanyi" placeholder="Artist" required>
                    </label>
                    <br>
                    <label>
                        Cover Album : 
                        <input class="button" type="file" name="cover_file" id="cover_file" accept="image/jpg, image/jpeg, image/png" required>
                    </label>
                    <br>
                    <label >
                        Audio Source :
                        <input class="button" type="file" name="audio_file" id="audio_file" accept="audio/wav, audio/mp3, audio/ogg" required>
                    </label>
                    <br>
                    <label>
                        Genre :
                        <input class="input" type="text" name="genre" id="genre" placeholder="Genre" required>
                    </label>
                    <br>
                    <label>
                        Tanggal Terbit :
                        <input type="date" id="tanggal_terbit" name="tanggal_terbit" value="2022-10-28"  min="1960-01-01" required>
                    </label>
                    <select class="selection" name="album_id" id="album_id">
                        <option value="">Select Album</option>
                        <?php
                            $songs = new App\Service\AlbumService();
                            $result = $songs->readAll();
                            $count_data = count($result);
                            for($i = 0; $i < $count_data; $i++) {
                                $data = $result[$i];        
                                echo "<option value='$data[0]'>$data[1] - $data[2]</option>";
                            }
                        ?>
                    </select>
                </form>
                <button type="submit" id="button_submit" class="button" onclick={addSong(event)}>
                    Submit
                </button>
            </div>
        </div>
    </body>

    <script>
        async function getDuration(file) {
            const url = URL.createObjectURL(file);

            return new Promise((resolve) => {
                const audio = document.createElement("audio");
                audio.muted = true;
                const source = document.createElement("source");
                source.src = url; //--> blob URL
                audio.preload= "metadata";
                audio.appendChild(source);
                audio.onloadedmetadata = function(){
                    resolve(parseInt(audio.duration))
                };
            });
        }
        const addSong = async(e) => {
            e.preventDefault();
            const judul = document.getElementById('judul').value;
            const penyanyi = document.getElementById('penyanyi').value;
            const tanggal_terbit = document.getElementById('tanggal_terbit').value;
            const genre = document.getElementById('genre').value;
            const cover_file = document.getElementById('cover_file').files[0];
            const audio_file = document.getElementById('audio_file').files[0];
            const duration = await getDuration(audio_file);
            const album_id = document.getElementById('album_id').value;

            let formData = new FormData();
            formData.append("judul", judul);
            formData.append("penyanyi", penyanyi);
            formData.append("tanggal_terbit", tanggal_terbit);
            formData.append("genre", genre);
            formData.append("cover_file", cover_file);
            formData.append("audio_file", audio_file);
            formData.append("duration", duration);
            formData.append("album_id", album_id);

            console.log(formData);
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "/addsong");
            await xmlhttp.send(formData);
            xmlhttp.onload = () => {
                if (xmlhttp.status==201){
                    alert("Song added successfully");
                    window.location.reload();
                } else{
                    let res = JSON.parse(xmlhttp.responseText);
                    alert(res.error)
                }
            }
        }
    </script>
</html>