<?php 
/*Template Name: Kontakt*/ 
?>
<?php
    if (!defined('ABSPATH')) exit;
    $team_email = get_field('team_email');
    $phone_number = get_field('phone_number');
    $phone_contact_person = get_field('phone_contact_person'); 
    $messenger_note = get_field('messenger_note');
    $footer_contact_note = get_field('footer_contact_note');
?>
<?php get_header(); ?>

<main class="content-area">
    <div class="page-welcome container">
        <h1 class="page-welcome__title"><?= esc_html( get_the_title() ); ?></h1>
        <?php $welcome_text = get_field('section_subtext'); if ($welcome_text) : ?>
        <div class="page-welcome__text">
            <?php echo wp_kses_post($welcome_text); ?>
        </div>
        <?php endif; ?>
    </div>
    <section class="contact container">
        <div class="contact__container">
            <div class="contact__content">
                <div class="contact__col styled-button">
                    <h3 class="contact__title">E-mail zespołu</h3>
                    <?php if ($team_email) : ?>
                        <p class="contact__email"><?php echo esc_html($team_email); ?></p>
                    <?php endif; ?>
                </div>
                <div class="contact__col styled-button">
                    <h3 class="contact__title">Kontakt telefoniczny</h3>
                    <?php if ($phone_number) : ?>
                        <p class="contact__phone">tel. kom.: <?php echo esc_html($phone_number); ?></p>
                    <?php endif; ?>
                    <?php if ($phone_contact_person) : ?>
                        <span class="contact__phone-person"><?php echo esc_html($phone_contact_person); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($messenger_note) : ?>
                <p class="contact__messenger-note"><?php echo esc_html($messenger_note); ?></p>
            <?php endif; ?>
        </div>
        <div class="contact__footer-note">
            <?php if ($footer_contact_note) : ?>
                <?php the_field('footer_contact_note'); ?>
            <?php endif; ?>
        </div>
    </section>
    <?php get_template_part('template-parts/components/go_top'); ?>
</main>

<?php get_footer(); ?>