<?php defined('BASEPATH') OR exit('No direct access to script allowed'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        <link rel="stylesheet" href="./layout/assets/css/detail.css" />
        <title>Binotify</title>
    </head>

    <body>      
        <div id="main">
            <div class="container">
                <p class="title">Album Detail</p>
                <p id="error"></p>
                <div class="content">
                    <div class="content-left">
                        <img src="" alt="cover" id="cover" class="cover">
                    </div>
                    <div class="content-right">
                        <a class="judul" id="judul">Title: </a><br>
                        <a class="penyanyi" id="penyanyi">Artist: </a><br>
                        <a class="total_duration" id="total_duration">Total Duration: </a><br>
                    </div>
                </div<>
                <!-- TODO: DAFTAR LAGU -->
                <div class="content">
                    <div class="admin_content_album" id="admin_content">
                        <!-- form for editing field, upload image and audio file -->
                        <form class="form_edit" id="form_edit" method="PUT" enctype="multipart/form-data">
                            <input type="text" name="judul" id="judul_edit" placeholder="Title">
                            <input type="text" name="penyanyi" id="penyanyi_edit" placeholder="Artist">
                            <input type="file" name="cover_file" id="cover_file_edit" accept="image/jpg, image/jpeg, image/png">
                        </form>
                        <button type="submit" id="button_submit" class="button" onclick={update(event)}>
                            Submit
                        </button>
                        <button type="button" id="button_delete" class="button" onclick={delete(event)}>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
    </body>

    <script>
        const xmlhttp = new XMLHttpRequest();
        const urlParams = new URLSearchParams(window.location.search);
        const myParam = urlParams.get('id');
        xmlhttp.open("GET", "/App/Controller/DetailAlbum.php?id=" + myParam);
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
            document.getElementById('total_duration').innerHTML = data.total_duration;
            const songs[] = data.songs;
            // TODO: DAFTAR LAGU
        }
        xmlhttp.send();

        const update = (e) => {
            e.preventDefault();
            const judul = document.getElementById('judul_edit').value;
            const penyanyi = document.getElementById('penyanyi_edit').value;
            const tanggal_terbit = document.getElementById('tanggal_terbit_edit').value;
            const genre = document.getElementById('genre_edit').value;
            const cover_file = document.getElementById('cover_file_edit').files[0]

            // const payload = {
            //     judul,
            //     penyanyi,
            //     tanggal_terbit,
            //     genre,
            //     cover_file,
            //     duration,
            // }
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.open("PUT", "/App/Controller/UpdateAlbum.php?id=" + myParam);
            xmlhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.send(JSON.stringify(payload));
        }

        const delete = (e) => {
            e.preventDefault();
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.open("DELETE", "/App/Controller/DeleteAlbum.php?id=" + myParam);
            xmlhttp.send();

            window.location.href = "/index.php";
        }
    </script>
</html>