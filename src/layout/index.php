<?php 
$isNavVisible = false;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URL; ?>/layout/assets/css/navbar.css">
  </head>
  <body>
    <!-- Header Start -->
    <header class="site-header">
      <div class="wrapper site-header__wrapper">
        <div class="site-header__start">
          <nav class="nav show-button-navbar">
             <button class="nav__toggle" aria-expanded="false" type="button">
              menu
            </button>
            <ul class="nav__wrapper">
              <li class="nav__item"><a href="#">Home</a></li>
              <li class="nav__item"><a href="#">About</a></li>
              <li class="nav__item"><a href="#">Services</a></li>
              <li class="nav__item"><a href="#">Hire us</a></li>
              <li class="nav__item"><a href="#">Contact</a></li>
            </ul>
          </nav>
          <a href="#" class="brand">Spotipe</a>
          <div class="search">
            <button class="search__toggle" aria-label="Open search">
              Search
            </button>
            <form class="search__form" action="/search" method="post">
              <label class="sr-only" for="search">Search</label>
              <input
                type="search"
                name="search"
                id="search"
                placeholder="What's on your mind?"
              />
            </form>
          </div>
        </div>
        <div class="site-header__end">
          <h1>USERNAME</h1>
        </div>
      </div>
    </header>
    <!-- Header End -->
    <div class="utama">
        <nav class="nav show-sidebar">
            <ul class="sidebar">
                <li class="nav__item"><a href="#">Home</a></li>
                <li class="nav__item"><a href="#">About</a></li>
                <li class="nav__item"><a href="#">Services</a></li>
                <li class="nav__item"><a href="#">Hire us</a></li>
                <li class="nav__item"><a href="#">Contact</a></li>
            </ul>
        </nav>
        <main class="main_page">
            <?php require_once "App/Router/Pages.php" ?>
        </main>
    </div>
    <script src="js/header-13.js"></script>
  </body>
    <script> 
let navToggle = document.querySelector(".nav__toggle");
let navWrapper = document.querySelector(".nav__wrapper");

navToggle.addEventListener("click", function () {
  if (navWrapper.classList.contains("active")) {
    this.setAttribute("aria-expanded", "false");
    this.setAttribute("aria-label", "menu");
    navWrapper.classList.remove("active");
  } else {
    navWrapper.classList.add("active");
    this.setAttribute("aria-label", "close menu");
    this.setAttribute("aria-expanded", "true");
    searchForm.classList.remove("active");
    searchToggle.classList.remove("active");
  }
});

let searchToggle = document.querySelector(".search__toggle");
let searchForm = document.querySelector(".search__form");

searchToggle.addEventListener("click", showSearch);

function showSearch() {
  searchForm.classList.toggle("active");
  searchToggle.classList.toggle("active");

  navToggle.setAttribute("aria-expanded", "false");
  navToggle.setAttribute("aria-label", "menu");
  navWrapper.classList.remove("active");

  if (searchToggle.classList.contains("active")) {
    searchToggle.setAttribute("aria-label", "Close search");
  } else {
    searchToggle.setAttribute("aria-label", "Open search");
  }
}

    </script>
</html>