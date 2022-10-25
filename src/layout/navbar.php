<?php 
function component($isAdmin){
    $element = "
    <header class=\"site-header\">
    <div class=\"wrapper site-header__wrapper\">
      <div class=\"site-header__start\">
        <nav class=\"nav show-button-navbar\">
          <button class=\"nav__toggle\" aria-expanded=\"false\" type=\"button\">
            menu
          </button>
          <ul class=\"nav__wrapper\">
            <?php if ($isAdmin == true) {?>
              <li class=\"nav__item\"><a href=\"/\">Tambah Lagu</a></li>
              <li class=\"nav__item\"><a href=\"/\">Tambah Album</a></li>
            <?php };?>
            <li class=\"nav__item\"><a href=\"/\">Daftar Album</a></li>
            <li class=\"nav__item\"><a href=\"/\">Keluar</a></li>
          </ul>
        </nav>
        <a href=\"#\" class=\"brand\">Binotify</a>
        <?php if ($isAdmin == false) {?>
          <div class=\"search\">
            <button class=\"search__toggle\" aria-label=\"Open search\">
              Search
            </button>
            <form class=\"search__form\" action=\"/search\" method=\"post\">
              <label class=\"sr-only\" for=\"search\">Search</label>
              <input
                type=\"search\"
                name=\"search\"
                id=\"search\"
                placeholder=\"What's on your mind?\"
              />
            </form>
          </div>
        <?php };?>
      </div>
      <div class=\"site-header__end\">
        <h1><?php echo $username ?></h1>
      </div>
    </div>
  </header>

  <div class=\"utama\">
      <nav class=\"nav show-sidebar\">
          <ul class=\"sidebar\">
            <?php if ($isAdmin == true) {?>
              <li class=\"nav__item\"><a href=\"/\">Tambah Lagu</a></li>
              <li class=\"nav__item\"><a href=\"/\">Tambah Album</a></li>
            <?php };?>
            <li class=\"nav__item\"><a href=\"/\">Daftar Album</a></li>
            <li class=\"nav__item\"><a href=\"/\">Keluar</a></li>
          </ul>
      </nav>
  </div>
</body>
<script> 
  let navToggle = document.querySelector(\".nav__toggle\");
  let navWrapper = document.querySelector(\".nav__wrapper\");

  navToggle.addEventListener(\"click\", function () {
    if (navWrapper.classList.contains(\"active\")) {
      this.setAttribute(\"aria-expanded\", \"false\");
      this.setAttribute(\"aria-label\", \"menu\");
      navWrapper.classList.remove(\"active\");
    } else {
      navWrapper.classList.add(\"active\");
      this.setAttribute(\"aria-label\", \"close menu\");
      this.setAttribute(\"aria-expanded\", \"true\");
      searchForm.classList.remove(\"active\");
      searchToggle.classList.remove(\"active\");
    }
  });

  let searchToggle = document.querySelector(\".search__toggle\");
  let searchForm = document.querySelector(\".search__form\");

  searchToggle.addEventListener(\"click\", showSearch);

  function showSearch() {
    searchForm.classList.toggle(\"active\");
    searchToggle.classList.toggle(\"active\");

    navToggle.setAttribute(\"aria-expanded\", \"false\");
    navToggle.setAttribute(\"aria-label\", \"menu\");
    navWrapper.classList.remove(\"active\");

    if (searchToggle.classList.contains(\"active\")) {
      searchToggle.setAttribute(\"aria-label\", \"Close search\");
    } else {
      searchToggle.setAttribute(\"aria-label\", \"Open search\");
    }
  }
</script>

    ";

    echo $element;
}

?>