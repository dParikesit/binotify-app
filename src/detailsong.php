<?php defined('BASEPATH') OR exit('No direct access to script allowed'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        <link rel="stylesheet" href="./app/style/style.css" />
        <title>Binotify</title>
    </head>

    <body>

        <h3>Song</h3>
        
        <div id="main">
            <div id="container">
                <h2 id="title">Detail Lagu</h2>
                <p id="error"></p>
                <div id="content">
                    <div id="content-left">
                        <img src="" alt="cover" id="cover">
                    </div>
                    <div id="content-right">
                        <h4 id="judul">Title: </h4>
                        <a id="penyanyi">Artist: </a>
                        <a id="tanggal_terbit">Release: </a>
                        <a id="genre">Genre: </a>
                        <a id="duration">Duration: </a>
                        <!-- Audio -->
                        <audio controls>
                            <source src="" type="" id="audio">
                        </audio>
                        <!-- Button to see Album -->
                        <button type="button" id="button_album">
                            See Album
                        </button>
                    </div>
                </div<>
                <div id="admin-content">
                    <!-- form for editing field, upload image and audio file -->
                    <form id="form_edit" method="POST" enctype="multipart/form-data">
                        <input type="text" name="judul" id="judul_edit" placeholder="Title">
                        <input type="text" name="penyanyi" id="penyanyi_edit" placeholder="Artist">
                        <input type="text" name="tanggal_terbit" id="tanggal_terbit_edit" placeholder="Release">
                        <input type="text" name="genre" id="genre_edit" placeholder="Genre">
                        <input type="file" name="cover_file" id="cover_file_edit" accept="image/jpg, image/jpeg, image/png">
                        <input type="file" name="audio_file" id="audio_file_edit" accept="audio/mp3, audio/wav, audio/ogg">
                    <button type="submit" id="button_submit" onclick={update(event)}>
                        Submit
                    </button>
                    <button type="button" id="button_delete">
                        Delete
                    </button>
                </div>
            </div>
        </div>
        
    </body>

    <script>
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "/App/Controller/DetailSong.php");
        xmlhttp.onreadystatechange = () => {
            if (xmlhttp.status != 200){
                const error = JSON.parse(xmlhttp.responseText);
                document.getElementById('error').innerHTML = error.error;
                return;
            }
            const result = JSON.parse(xmlhttp.responseText);
            const data = result.data;
            const image = document.getElementById('cover');
            image.setAttribute('src', data.image_path);
            document.getElementById('judul').innerHTML = data.judul;
            document.getElementById('penyanyit').innerHTML = data.penyanyi;
            document.getElementById('tanggal_terbit').innerHTML = data.tanggal_terbit;
            document.getElementById('genre').innerHTML = data.genre;
            document.getElementById('duration').innerHTML = data.duration;
            const audio = document.getElementById('audio');
            audio.setAttribute('src', data.audio_path);
            const ext = data.audio_path.split('.').pop();
            audio.setAttribute('type', `audio/${ext}`);

            const button = document.getElementById('button_album');
            button.onclick = () => {
                window.location.href = `/detailalbum.php?id=${data.album_id}`;
            }
        }
        xmlhttp.send();

        const update = (e) => {
            e.preventDefault();
            const judul = document.getElementById('judul_edit').value;
            const penyanyi = document.getElementById('penyanyi_edit').value;
            const tanggal_terbit = document.getElementById('tanggal_terbit_edit').value;
            const genre = document.getElementById('genre_edit').value;
            const cover_file = document.getElementById('cover_file_edit').files[0];
            const audio_file = document.getElementById('audio_file_edit').files[0];
            const duration = parseInt(audio_file.duration);

            const payload = {
                judul,
                penyanyi,
                tanggal_terbit,
                genre,
                cover_file,
                duration,
                audio_file
            }
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.open("PUT", "/App/Controller/UpdateSong.php");
            xmlhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.send(JSON.stringify(payload));
        }
    </script>
</html>