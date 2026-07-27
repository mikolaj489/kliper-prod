<?php
if (!defined('ABSPATH')) exit;
$footer_posts = get_posts([
    'post_type'      => 'stopka',
    'posts_per_page' => 1,
    'fields'         => 'ids',
]);
$footer_id = $footer_posts[0] ?? null;
if (!$footer_id) return;

$contact   = get_field('footer_contact', $footer_id);
$more      = get_field('footer_more', $footer_id);
$links     = get_field('footer_links', $footer_id);
$social_fb = get_field('footer_facebook_url', $footer_id);
?>

<footer class="global-footer container" data-footer-id="<?= esc_attr($footer_id) ?>">
  <div class="footer__container">
      <div class="footer__wrapper">
        <div class="footer__col footer__col--contact">
          <h4 class="footer__title">Kontakt:</h4>
            <?php if ($contact) : ?>
                <?= wp_kses_post($contact) ?>
            <?php endif; ?>
        </div>

        <div class="footer__col footer__col--more">
          <h4 class="footer__title">Więcej:</h4>
            <?php if ($more) : ?>
                <?= wp_kses_post($more) ?>
            <?php endif; ?>
                      <?php if ($social_fb) : ?>
          <div class="footer__socials">
              <span>Znajdziesz nas na &#10150;</span>
              <a href="<?= esc_url($social_fb) ?>" target="_blank" rel="noopener noreferrer">
                  <img class="footer__socials-img" src="<?= esc_url(get_template_directory_uri() . '/assets/images/icons/facebook.svg') ?>" alt="Facebook">
              </a>
          </div>
          <?php endif; ?>
        </div>

        <div class="footer__col footer__col--links">
          <h4 class="footer__title">Miejsca godne odwiedzenia:</h4>
            <?php if ($links) : ?>
                <?= wp_kses_post($links) ?>
            <?php endif; ?>
        </div>
      </div>
      <div class="footer__bottom">
        <div class="footer__bottom-dev">
          <p>Projekt i realizacja strony: Mikołaj Leszczyński</p>
        </div>
        <div class="footer__copyright">
            <p>Copyright &copy; <?= date('Y') ?> <?= get_bloginfo('name')?> Wszelkie prawa zastrzeżone.</p>
        </div>
        <img class="footer__wheel" src="<?= esc_url(get_template_directory_uri() . '/assets/images/icons/wheel.svg') ?>">
      </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>