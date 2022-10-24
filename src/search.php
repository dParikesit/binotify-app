<?php defined('BASEPATH') OR exit('No direct access to script allowed');?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        <link rel="stylesheet" href="./app/style/style.css" />
        <title>Notes App</title>
    </head>

    <body>

        <h3>Search Songs</h3>
        
        <div>
            <form method="POST">
                <label for="fname">Judul</label>
                <input type="text" id="judul" name="judul" placeholder="Judul...">

                <label for="lname">Penulis</label>
                <input type="text" id="penulis" name="penulis" placeholder="penulis...">

                <label for="lname">Tahun</label>
                <input type="text" id="tahun" name="tahun" placeholder="tahun...">

            </form>
            <button type="button" onclick={register(event)} >Submit</button>
        </div>
        
    </body>

    <script>
        const register = (e) => {
            e.preventDefault();
            const judul = document.getElementById('judul').value;
            const penyanyi = document.getElementById('penulis').value;
            const tahun = document.getElementById('tahun').value;
            const maxdata = 1;
            const ordering = 'ASC'
            // const genre = ''
            const page = 2;
            const payload = {
                judul,
                penyanyi,
                tahun,
                // genre,
                ordering,
                page,
                maxdata
            }
            console.log(payload)

            const xmlhttp = new XMLHttpRequest();
            // xmlhttp.onload = () => {
            //     if (xmlhttp.status != 200){
            //     return;      
            //     }
            //     window.location.href = '/';
            // }
            // xmlhttp.onreadystatechange = function() {
            //     console.log(this.responseText)
            // };

            xmlhttp.open("POST", "/App/Controller/SearchSong.php");
            xmlhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.send(JSON.stringify(payload));

        }
    </script>
</html>