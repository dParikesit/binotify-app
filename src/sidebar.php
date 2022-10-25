<?php 
function sidebar($isAdmin){
    $element1 = "<div class=\"utama\">
    <nav class=\"nav show-sidebar\">
        <ul class=\"sidebar\">";
    $element2 = " <li class=\"nav__item\"><a href=\"/addsong\">Tambah Lagu</a></li>
    <li class=\"nav__item\"><a href=\"/addalbum\">Tambah Album</a></li>";
    $element3 = "<li class=\"nav__item\"><a href=\"/listalbum\">Daftar Album</a></li>
    <li class=\"nav__item\"><a href=\"/logout\">Keluar</a></li>
  </ul>
</nav>
</div>";
    $element = "
  <div class=\"utama\">
      <nav class=\"nav show-sidebar\">
          <ul class=\"sidebar\">
            <?php if ($isAdmin == true) {?>
              <li class=\"nav__item\"><a href=\"/addsong\">Tambah Lagu</a></li>
              <li class=\"nav__item\"><a href=\"/addalbum\">Tambah Album</a></li>
            <?php };?>
            <li class=\"nav__item\"><a href='listalbum.php'>Daftar Album</a></li>
            <li class=\"nav__item\"><a href=\"/logout\">Keluar</a></li>
          </ul>
      </nav>
  </div>
    ";

    if ($isAdmin == true) {
        echo $element1.$element2.$element3;
    } else {
        echo $element1.$element3;
    }
}

?>