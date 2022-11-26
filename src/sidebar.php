<?php 
function sidebar($isAdmin){
    $element1 = "<div class=\"utama\">
    <nav class=\"nav show-sidebar\">
        <ul class=\"sidebar\">";
    $element2 = " <li class=\"nav__item\">
    <svg class=\"icon\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"white\" viewBox=\"0 0 24 24\" strokeWidth={1.5} stroke=\"currentColor\" className=\"w-6 h-6\">
      <path strokeLinecap=\"round\" strokeLinejoin=\"round\" d=\"M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z\" />
    </svg>
      <a href=\"/addsong\">Tambah Lagu</a>
    </li>
    <li class=\"nav__item\">
    <svg class=\"icon iconwhite\" version=\"1.1\" id=\"Capa_1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" viewBox=\"0 0 489.8 489.8\" style=\"enable-background:new 0 0 489.8 489.8;\" xml:space=\"preserve\">
      <g>
        <g>
        <path d=\"M438.2,0H51.6C23.1,0,0,23.2,0,51.6v386.6c0,28.5,23.2,51.6,51.6,51.6h386.6c28.5,0,51.6-23.2,51.6-51.6V51.6
          C489.8,23.2,466.6,0,438.2,0z M465.3,438.2c0,14.9-12.2,27.1-27.1,27.1H51.6c-14.9,0-27.1-12.2-27.1-27.1V51.6
          c0-14.9,12.2-27.1,27.1-27.1h386.6c14.9,0,27.1,12.2,27.1,27.1V438.2z\"/>
        <path d=\"M337.4,232.7h-80.3v-80.3c0-6.8-5.5-12.3-12.3-12.3s-12.3,5.5-12.3,12.3v80.3h-80.3c-6.8,0-12.3,5.5-12.3,12.2
          c0,6.8,5.5,12.3,12.3,12.3h80.3v80.3c0,6.8,5.5,12.3,12.3,12.3s12.3-5.5,12.3-12.3v-80.3h80.3c6.8,0,12.3-5.5,12.3-12.3
          C349.7,238.1,344.2,232.7,337.4,232.7z\"/>
        </g>
      </g>
      </svg>
      <a href=\"/addalbum\">Tambah Album</a>
    </li>
    <li class=\"nav__item\">
    <svg class=\"icon\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"white\" viewBox=\"0 0 24 24\" strokeWidth={1.5} stroke=\"currentColor\" className=\"w-6 h-6\">
      <path strokeLinecap=\"round\" strokeLinejoin=\"round\" d=\"M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z\" />
    </svg>
    <a href=\"/users\">Daftar User</a>
    </li>";
    $element3 = "<li class=\"nav__item\">
    <svg class=\"icon\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"white\" viewBox=\"0 0 24 24\" strokeWidth={1.5} stroke=\"currentColor\" className=\"w-6 h-6\">
      <path strokeLinecap=\"round\" strokeLinejoin=\"round\" d=\"M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z\" />
    </svg>
    <a href=\"/listalbum\">Daftar Album</a></li>
    <li class=\"nav__item\">
    <li class=\"nav__item\">
    <svg class=\"icon\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"white\" viewBox=\"0 0 24 24\" strokeWidth={1.5} stroke=\"currentColor\" className=\"w-6 h-6\">
      <path strokeLinecap=\"round\" strokeLinejoin=\"round\" d=\"M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z\" />
    </svg>
    <a href=\"/listpenyanyi\">Daftar Penyanyi Premium</a></li>
    <li class=\"nav__item\">
    <svg class=\"icon\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"white\" viewBox=\"0 0 24 24\" strokeWidth={1.5} stroke=\"currentColor\" className=\"w-6 h-6\">
      <path strokeLinecap=\"round\" strokeLinejoin=\"round\" d=\"M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9\" />
    </svg>
    <a href=\"/logout\">Logout</a></li>
  </ul>
</nav>
</div>";
    $element4 = "<li class=\"nav__item\">
    <a href=\"/listalbum\">Daftar Album</a></li>
    <li class=\"nav__item\"><a href=\"/login\">Login</a></li>
  </ul>
</nav>
</div>";
    $element = "
  <div class=\"utama\">
      <nav class=\"nav show-sidebar\">
          <ul class=\"sidebar\">
            <?php if ($isAdmin == true) {?>
              <li class=\"nav__item\">
                <svg class=\"icon\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"white\" viewBox=\"0 0 24 24\" strokeWidth={1.5} stroke=\"currentColor\" className=\"w-6 h-6\">
                  <path strokeLinecap=\"round\" strokeLinejoin=\"round\" d=\"M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z\" />
                </svg>
                <a href=\"/addsong\">Tambah Lagu</a>
              </li>
              <li class=\"nav__item\">
              <svg class=\"icon iconwhite\" version=\"1.1\" id=\"Capa_1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" viewBox=\"0 0 489.8 489.8\" style=\"enable-background:new 0 0 489.8 489.8;\" xml:space=\"preserve\">
              <g>
                <g>
                <path d=\"M438.2,0H51.6C23.1,0,0,23.2,0,51.6v386.6c0,28.5,23.2,51.6,51.6,51.6h386.6c28.5,0,51.6-23.2,51.6-51.6V51.6
                  C489.8,23.2,466.6,0,438.2,0z M465.3,438.2c0,14.9-12.2,27.1-27.1,27.1H51.6c-14.9,0-27.1-12.2-27.1-27.1V51.6
                  c0-14.9,12.2-27.1,27.1-27.1h386.6c14.9,0,27.1,12.2,27.1,27.1V438.2z\"/>
                <path d=\"M337.4,232.7h-80.3v-80.3c0-6.8-5.5-12.3-12.3-12.3s-12.3,5.5-12.3,12.3v80.3h-80.3c-6.8,0-12.3,5.5-12.3,12.2
                  c0,6.8,5.5,12.3,12.3,12.3h80.3v80.3c0,6.8,5.5,12.3,12.3,12.3s12.3-5.5,12.3-12.3v-80.3h80.3c6.8,0,12.3-5.5,12.3-12.3
                  C349.7,238.1,344.2,232.7,337.4,232.7z\"/>
                </g>
              </g>
              </svg>
                <a href=\"/addalbum\">Tambah Album</a>
              </li>
              <li class=\"nav__item\">
                <svg class=\"icon\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"white\" viewBox=\"0 0 24 24\" strokeWidth={1.5} stroke=\"currentColor\" className=\"w-6 h-6\">
                  <path strokeLinecap=\"round\" strokeLinejoin=\"round\" d=\"M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z\" />
                </svg>
                <a href=\"/users\">Daftar User</a>
              </li>
            <?php };?>
            <li class=\"nav__item\">
            <svg class=\"icon\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"white\" viewBox=\"0 0 24 24\" strokeWidth={1.5} stroke=\"currentColor\" className=\"w-6 h-6\">
            <path strokeLinecap=\"round\" strokeLinejoin=\"round\" d=\"M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z\" />
          </svg>
            <a href='listalbum.php'>Daftar Album</a></li>
            <li class=\"nav__item\">
            <li class=\"nav__item\">
    <svg class=\"icon\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"white\" viewBox=\"0 0 24 24\" strokeWidth={1.5} stroke=\"currentColor\" className=\"w-6 h-6\">
      <path strokeLinecap=\"round\" strokeLinejoin=\"round\" d=\"M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z\" />
    </svg>
    <a href=\"/listpenyanyi\">Daftar Penyanyi Premium</a></li>
    <li class=\"nav__item\">
            <svg class=\"icon\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"white\" viewBox=\"0 0 24 24\" strokeWidth={1.5} stroke=\"currentColor\" className=\"w-6 h-6\">
            <path strokeLinecap=\"round\" strokeLinejoin=\"round\" d=\"M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9\" />
          </svg>
            <a href=\"/logout\">Keluar</a>
            </li>
          </ul>
      </nav>
  </div>
    ";
    if (isset($_SESSION["user_id"])) {
      if ($isAdmin == true) {
        echo $element1.$element2.$element3;
      } else {
        echo $element1.$element3;
      }
    } else {
      echo $element1.$element4;
    }
    
}

?>