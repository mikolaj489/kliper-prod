<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- <header class="site-header">
  <div class="header__container">

    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
      Kliper
    </a>
    <?php

    wp_nav_menu([
      'theme_location' => 'main-menu',
      'container' => 'nav',
      'container_class' => 'main-nav',
      'menu_class' => 'menu',
    ]);
    ?>

  </div>
</header> -->