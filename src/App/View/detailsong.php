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
                <h1 class="title" id="title">Song Detail</h1>
                <div class="content">
                    <div class="user_content">
                        <img src="" alt="cover" id="cover" class="cover">
                        <div class="content-left">
                            <a class="judul" id="judul">Title: </a>
                            <div class="desc">
                            <a class="penyanyi" id="penyanyi">Artist: </a>
                            <a class="tanggal_terbit" id="tanggal_terbit">Release: </a><br>
                            </div>
                            <div class="desc">
                            <a class="genre" id="genre">Genre: </a>
                            <a class="duration" id="duration">Duration: </a><br>
                            </div>
                            <!-- Audio -->
                            <audio class="audio_source" id="audio" controls>
                                <source src="" type="" id="audio_source">
                            </audio>
                            <!-- Button to see Album -->
                            <button type="button" id="button_album" class="button">
                                See Album
                            </button>
                        </div>
                    </div>
                    <div class="admin_content" id="admin_content">
                        <form class="form_edit" id="form_edit" method="PUT" enctype="multipart/form-data">
                        <section>
                            <label> Title: </label>
                            <input type="text" name="judul" id="judul_edit" placeholder="Title"><br>
                        </section>
                        <section>
                            <label> Tanggal Terbit: </label>
                            <input type="date" name="tanggal_terbit" id="tanggal_terbit_edit"  value="2022-10-28"  min="1960-01-01"><br>
                        </section>
                        <section>
                            <label> Genre: </label>
                            <input type="text" name="genre" id="genre_edit" placeholder="Genre"><br>
                        </section>
                            <label> Audio File: </label>
                            <input type="file" name="audio_file" id="audio_file_edit" accept="audio/mp3, audio/wav, audio/ogg"><br>
                            <label> Cover Image: </label>
                            <input type="file" name="cover_file" id="cover_file_edit" accept="image/jpg, image/jpeg, image/png"><br>
                        </form>
                        <button type="button" id="button_submit" class="button" onclick={updateSong(event)}>
                            Submit
                        </button>
                        <button type="button" id="button_delete" class="button" onclick={deleteSong(event)}>
                            Delete
                        </button>    
                    </div>
                    <?php 
                    if (!$_SESSION["isAdmin"]) { ?>
                        <script>
                            document.getElementById("admin_content").style.display = "none";
                        </script>
                    <?php } ?>
                </div>
            </div>
        </div>
        
    </body>

    <script>
        const xhr = new XMLHttpRequest();
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const id = urlParams.get('id');
        
        xhr.open("GET", `/getsong?id=${id}`);
        xhr.send();
        xhr.onload = () => {
            const result = JSON.parse(xhr.responseText);
            const data = result.data;

            const image = document.getElementById('cover');
            image.setAttribute('src', `/images?name=${data.image_path}`);

            document.getElementById('judul').innerHTML = `${data.judul}`;
            document.getElementById('penyanyi').innerHTML = `${data.penyanyi},`;
            document.getElementById('tanggal_terbit').innerHTML = `${data.tanggal_terbit}`;
            document.getElementById('genre').innerHTML = `${data.genre},`;
            document.getElementById('duration').innerHTML = `${Math.floor(data.duration/60)}m ${data.duration%60}s`;
            document.getElementById('judul_edit').value = data.judul;
            document.getElementById('tanggal_terbit_edit').value = data.tanggal_terbit;
            document.getElementById('genre_edit').value = data.genre;

            const audio_source = document.getElementById('audio_source');
            audio_source.setAttribute('src', `/audios?name=${data.audio_path}`);
            const ext = data.audio_path.split('.').pop();
            audio_source.setAttribute('type', `audio/${ext}`);

            const audio = document.getElementById('audio');
            audio.load()

            const button = document.getElementById('button_album');
            button.onclick = () => {
                window.location.href = `/detailalbum?id=${data.album_id}`;
            }
        }

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

        const updateSong = async(e) => {
            e.preventDefault();
            const judul = document.getElementById('judul_edit').value;
            const tanggal_terbit = document.getElementById('tanggal_terbit_edit').value;
            const genre = document.getElementById('genre_edit').value;
            const cover_file = document.getElementById('cover_file_edit').files[0];
            const audio_file = document.getElementById('audio_file_edit').files[0];
            const duration = audio_file ? (await getDuration(audio_file)) : "";

            let formData = new FormData();
            judul !== "" ? formData.append("judul", judul) : "";
            tanggal_terbit !== "" ? formData.append("tanggal_terbit", tanggal_terbit) : "";
            genre !== "" ? formData.append("genre", genre) : "";
            cover_file !== undefined ? formData.append("cover_file", cover_file) : "";
            audio_file !== undefined ? formData.append("audio_file", audio_file) : "";
            duration !== "" ? formData.append("duration", duration) : 0;

            const xhr = new XMLHttpRequest();
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const id = urlParams.get('id');
            formData.append("id", id);
            xhr.open("POST", `/updatesong`);
            xhr.send(formData);

            xhr.onload = () => {
                if (xhr.status==200){
                    window.location.reload();
                } else{
                    let res = JSON.parse(xhr.responseText);
                    alert(res.error)
                }
            }
        }

        const deleteSong = (e) => {
            e.preventDefault();
            const xhr = new XMLHttpRequest();
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const id = urlParams.get('id');
            xhr.open("DELETE", `deletesong?id=${id}`);
            xhr.send();

            xhr.onload = () => {
                if (xhr.status==200){
                    window.location.href="/listalbum";
                } else{
                    let res = JSON.parse(xhr.responseText);
                    alert(res.error)
                }
            }
        }
    </script>
</html>