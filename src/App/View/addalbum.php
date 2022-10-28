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
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/addpage1.css" />
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
                <h1 class="title">Add Album</h1>
                <form class="form_edit" id="form_edit" method="PUT" enctype="multipart/form-data">
                    <label>
                        Title : 
                    </label>
                    <input class="input" type="text" name="judul" id="judul" placeholder="Title" required>
                    <br>
                    <label>
                        Artist :
                    </label>
                    <input class="input" type="text" name="penyanyi" id="penyanyi" placeholder="Artist" required>
                    <br>
                    <label >
                        Cover Album : 
                    </label>
                    <input class="button" type="file" name="cover_file" id="cover_file" accept="image/jpg, image/jpeg, image/png" required>
                    <br>
                    <label>
                        Genre :
                    </label>
                    <input class="input" type="text" name="genre" id="genre" placeholder="Genre" required>
                    <br>
                    <label>
                        Tanggal Terbit :
                    </label>
                    <input class="input" type="date" id="tanggal_terbit" name="tanggal_terbit" value="2022-10-28"  min="1960-01-01" required>
                </form>
                <br>
                <button type="submit" id="button_submit" class="button_submit" onclick={add(event)}>
                    Submit
                </button>
            </div>
        </div>
    </body>

    <script>
        const add = (e) => {
            e.preventDefault();
            const judul = document.getElementById('judul').value;
            const penyanyi = document.getElementById('penyanyi').value;
            const tanggal_terbit = document.getElementById('tanggal_terbit').value;
            const genre = document.getElementById('genre').value;
            const cover_file = document.getElementById('cover_file').files[0]
            
            const payload = {
                judul,
                penyanyi,
                tanggal_terbit,
                genre,
                cover_file,
            }

            let formData = new FormData();
            formData.append("judul", judul);
            formData.append("penyanyi", penyanyi);
            formData.append("tanggal_terbit", tanggal_terbit);
            formData.append("genre", genre);
            formData.append("cover_file", cover_file);

            const xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "/addalbum");
            // xmlhttp.setRequestHeader("Content-type","multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2));
            // xmlhttp.send(JSON.stringify(payload));
            xmlhttp.send(formData);
            xmlhttp.onload = () => {
                if (xmlhttp.status==201){
                    alert("Album added successfully");
                    window.location.reload();
                } else{
                    let res = JSON.parse(xmlhttp.responseText);
                    alert(res.error)
                }
            }
        }
    </script>
</html>