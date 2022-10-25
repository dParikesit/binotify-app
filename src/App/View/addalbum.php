<?php defined('BASEPATH') OR exit('No direct access to script allowed'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        <link rel="stylesheet" href="./layout/assets/css/add.css" />
        <title>Binotify</title>
    </head>

    <body>      
        <div id="main">
            <div class="container">
                <p class="title">Add Album</p>
                <p id="error"></p>
                <div class="content">
                    <div class="content-left">
                        <!-- form for editing field, upload image and audio file -->
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
                            <label >
                                Cover Album : 
                                <input class="button" type="file" name="cover_file" id="cover_file" accept="image/jpg, image/jpeg, image/png" required>
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
                        </form>
                        <button type="submit" id="button_submit" class="button" onclick={add(event)}>
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script>
        const add = (e) => {
            e.preventDefault();
            const judul = document.getElementById('judul_edit').value;
            const penyanyi = document.getElementById('penyanyi_edit').value;
            const tanggal_terbit = document.getElementById('tanggal_terbit_edit').value;
            const genre = document.getElementById('genre_edit').value;
            const cover_file = document.getElementById('cover_file_edit').files[0]
            
            const payload = {
                judul,
                penyanyi,
                tanggal_terbit,
                genre,
                cover_file,
            }
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "/addalbum");
            xmlhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.send(JSON.stringify(payload));
        }
    </script>
</html>