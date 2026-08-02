<nav class="main-nav">
  <div class="menu__wrapper">
    <?php
      wp_nav_menu([
        'theme_location' => 'main-menu',
        'container'      => false,
        'menu_class'     => 'menu',
        'items_class' => 'menu-link styled-button',
        'items_wrap' => '
        <ul id="%1$s" class="%2$s">
        <li class="menu-logo">
        <a href="' . esc_url(home_url ('/')) . '">
          <img class="menu-logo-item" src="' . esc_url (get_template_directory_uri() . '/assets/images/icons/logo.svg') . '" alt="Logo">
        </a>
          <span class="hamburger-toggle styled-button menu-link"><img class="hamburger-toggle-img" src="' . esc_url (get_template_directory_uri() . '/assets/images/icons/hamburger.svg') . '"></span>
        </li>
        %3$s
        </ul>',
      ]);
    ?>
  </div>
</nav>

