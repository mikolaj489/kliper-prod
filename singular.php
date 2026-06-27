<?php
get_header();
?>
<main class="content-area">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            the_title('<h1>', '</h1>');
            the_content();
        endwhile;
    else :
        echo '<p>Brak treści do wyświetlenia.</p>';
    endif;
    ?>
</main>
<?php
get_footer();
