<nav class="main-nav">
  <div class="menu__wrapper">
    <?php
      wp_nav_menu([
        'theme_location' => 'main-menu',
        'container'      => false,
        'menu_class'     => 'menu',
        'items_wrap' => '<ul id="%1$s" class="%2$s"><li     class="menu-item menu-logo"><a href="' . esc_url  (home_url ('/')) . '"><img src="' . esc_url   (get_template_directory_uri() . '/assets/images/icons/logo.svg') . '" alt="Logo"></a></li>%3$s</ul>',
      ]);
    ?>
  </div>
</nav>

