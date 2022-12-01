<?php
    defined('BASEPATH') OR exit('No direct access to script allowed');
    if (!isset($_SESSION["user_id"])) {
        header("Location: "."/login");
    }

    if (!isset($_SESSION["isAdmin"]) || !$_SESSION["isAdmin"] == false) {
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
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/listsong.css">
        <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/nav.css">
        <link rel="icon" type="image/x-icon" href="<?php echo URL; ?>/layout/assets/img/favicon.png">
        <title>Binotify</title>
    </head>

    <body>
        <?php
            $isAdmin = isset($_SESSION["isAdmin"]) ? $_SESSION["isAdmin"] : false;
            $username = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
            navbar($isAdmin, $username);
        ?>
        <div class="flex">
            <?php
                $isAdmin = isset($_SESSION["isAdmin"]) ? $_SESSION["isAdmin"] : false;
                sidebar($isAdmin);
            ?>
            <table class="card">
            <tr>
                <th class="first-index">#</th>
                <th>Judul</th>
                <th class="play">Play</th>
            </tr>
            <tbody id="listtable"></tbody>
        </table>
        </div>
        <div class="footer audio-bg"></div>
            <div class="audio-player">
                <div class="timeline">
                    <div class="progress"></div>
                </div>
                <div class="controls">
                    <div class="play-container">
                    <div class="toggle-play play">
                    </div>
                    </div>
                <div class="time">
                    <div class="current">0:00</div>
                    <div class="divider">/</div>
                    <div class="length"></div>
                </div>
                    <div class="name" id="judul">Music Song</div>
                    <div class="volume-container">
                    <div class="volume-button">
                        <div class="volume icono-volumeMedium"></div>
                    </div>
                    <div class="volume-slider">
                        <div class="volume-percentage"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>

        const xhr = new XMLHttpRequest();
        xhr.open("GET", "/getsubscribed");
        xhr.send();
        xhr.onload = () => {
            console.log(xhr.responseText)
            const result = JSON.parse(xhr.responseText);
            let list_creatorid = result.data;
            var xmlhttp = [];
            let row = "";
            for (let i = 0; i < list_creatorid.length; i++) {
                if (list_creatorid[i]) {
                    xmlhttp[i] = new XMLHttpRequest();
                    xmlhttp[i].open("GET", `http://localhost:3002/api/songs/penyanyi/${list_creatorid[i].creator_id}`);
                    xmlhttp[i].send();
                    xmlhttp[i].onload = () => {
                        let res = JSON.parse(xmlhttp[i].responseText);
                        console.log(res)
                        var temp = "";
                        for (let j = 0; j < res.length; j++) {
                            if (res[j].judul) {
                                temp += '<tr>';
                                temp += '<td class="first-index">' + (j + 1) + '</td>';
                                temp += '<td class="judul">'+res[j].judul+'</td>';
                                let song_uri = res[j].audio_path;
                                let judul = ""
                                res[j].audio_path = "BOP";
                                console.log(typeof res[j].judul)
                                judul += res[j].judul
                                // temp += "<td><audio class='audio_source' id='audio' controls><source src="+song_uri+" id='audio_source'></audio></td>";
                                temp += '<td><div class="button-play" onclick={playSong("' + res[j].audio_path + '","' + judul + '")}></div></td>'
                                // temp += "<td><button onclick={playSong('nama','1')}>Play</button></td>"
                                temp += '</tr>';
                            }
                        }
                        document.getElementById("listtable").innerHTML += temp;
                    }
                }
            }
        }

            let audio = ""
            const playSong = (path, title) => {
                console.log(title)
                path = "https://ia800905.us.archive.org/19/items/FREE_background_music_dhalius/backsound.mp3"
                audio = new Audio(path);
                document.getElementById('judul').innerHTML = title;

                const audioPlayer = document.querySelector(".audio-player");

            console.dir(audio);

            audio.addEventListener(
            "loadeddata",
            () => {
                audioPlayer.querySelector(".time .length").textContent = getTimeCodeFromNum(
                audio.duration
                );
                audio.volume = .75;
            },
            false
            );

            //click on timeline to skip around
            const timeline = audioPlayer.querySelector(".timeline");
            timeline.addEventListener("click", e => {
            const timelineWidth = window.getComputedStyle(timeline).width;
            const timeToSeek = e.offsetX / parseInt(timelineWidth) * audio.duration;
            audio.currentTime = timeToSeek;
            }, false);

            //click volume slider to change volume
            const volumeSlider = audioPlayer.querySelector(".controls .volume-slider");
            volumeSlider.addEventListener('click', e => {
            const sliderWidth = window.getComputedStyle(volumeSlider).width;
            const newVolume = e.offsetX / parseInt(sliderWidth);
            audio.volume = newVolume;
            audioPlayer.querySelector(".controls .volume-percentage").style.width = newVolume * 100 + '%';
            }, false)

            //check audio percentage and update time accordingly
            setInterval(() => {
            const progressBar = audioPlayer.querySelector(".progress");
            progressBar.style.width = audio.currentTime / audio.duration * 100 + "%";
            audioPlayer.querySelector(".time .current").textContent = getTimeCodeFromNum(
                audio.currentTime
            );
            }, 500);

            //toggle between playing and pausing on button click
            const playBtn = audioPlayer.querySelector(".controls .toggle-play");
            playBtn.addEventListener(
            "click",
            () => {
                if (audio.paused) {
                playBtn.classList.remove("play");
                playBtn.classList.add("pause");
                audio.play();
                } else {
                playBtn.classList.remove("pause");
                playBtn.classList.add("play");
                audio.pause();
                }
            },
            false
            );

            audioPlayer.querySelector(".volume-button").addEventListener("click", () => {
            const volumeEl = audioPlayer.querySelector(".volume-container .volume");
            audio.muted = !audio.muted;
            if (audio.muted) {
                volumeEl.classList.remove("icono-volumeMedium");
                volumeEl.classList.add("icono-volumeMute");
            } else {
                volumeEl.classList.add("icono-volumeMedium");
                volumeEl.classList.remove("icono-volumeMute");
            }
            });

            //turn 128 seconds into 2:08
            function getTimeCodeFromNum(num) {
            let seconds = parseInt(num);
            let minutes = parseInt(seconds / 60);
            seconds -= minutes * 60;
            const hours = parseInt(minutes / 60);
            minutes -= hours * 60;

            if (hours === 0) return `${minutes}:${String(seconds % 60).padStart(2, 0)}`;
            return `${String(hours).padStart(2, 0)}:${minutes}:${String(
                seconds % 60
            ).padStart(2, 0)}`;
            }
            }
    </script>
</html>