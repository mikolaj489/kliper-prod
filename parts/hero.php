<style>
    .hero {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        gap: clamp(1rem, 8vw, 12rem);
        min-height: 100vh;
        width: 100%;
        overflow: hidden;
        padding-block-end: var(--sand-effect-height);
        box-sizing: border-box;
        position: relative;
        z-index: 1;
    }
    .hero__content {
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: auto auto auto;
        width: fit-content;
        flex: 0 1000px;
        max-width: 800px;
        align-self: center;
        gap: clamp(0.5rem, 2vw, 1.5rem);
        margin-block-start: 5rem;
    }
    .hero__logo {
        min-width: 100%;
        height: auto;
    }
    .hero__subtext {
        font-family: var(--font-secondary);
        font-style: italic;
        letter-spacing: 0.1em;
        font-size: 2rem;
        text-align: center;
        display: flex;
        align-items: center;
        gap: 1rem;
        &::before,
        &::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: var(--c-text-primary);
        }
        &::before { margin-inline-start: 4rem; }
        &::after  { margin-inline-end: 4rem; }
    }
    .hero__text {
        text-align: center;
        letter-spacing: 0.05em;
        line-height: 1.25;
        color: var(--c-text-muted);
        max-width: 715px;
        font-size: 1.25rem;
        margin: 0 auto;
    }
    .hero__animation-container {
        flex: 0 500px;
        position: relative;
    }
    @media (max-width: 1024px) {
        .hero__animation-container {
            display: none;
        }
    }
    .hero__animation-content {
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0; left: 0;
    }
    .blob {
        display: flex;
        position: absolute;
        align-items: center;
        justify-content: center;
        border-radius: var(--blob-radius);
        box-shadow: var(--blob-shadow);
        & img {
            width: 60%;
            height: 60%;
            object-fit: contain;
            transition: opacity var(--transition-fade);
            transform: rotate(calc(var(--blob-rotation) * -1));
        }
    }
    .blob--main {
        --blob-w: 400px;
        --blob-h: 580px;
        position: relative;
        width: var(--blob-w);
        height: var(--blob-h);
        background-color: var(--c-primary);
        top: 50%; left: 20%;
        animation: blob-shake 8s ease-in-out infinite;
        transform-origin: center center;
    }
    @keyframes blob-shake {
        0%   { transform: var(--blob-translate) rotate(var(--blob-rotation)) translateY(0); }
        10%  { transform: var(--blob-translate) rotate(var(--blob-rotation)) translateY(-8px); }
        22%  { transform: var(--blob-translate) rotate(var(--blob-rotation)) translateY(10px); }
        36%  { transform: var(--blob-translate) rotate(var(--blob-rotation)) translateY(-6px); }
        50%  { transform: var(--blob-translate) rotate(var(--blob-rotation)) translateY(2px); }
        62%  { transform: var(--blob-translate) rotate(var(--blob-rotation)) translateY(-5px); }
        74%  { transform: var(--blob-translate) rotate(var(--blob-rotation)) translateY(2px); }
        80%  { transform: var(--blob-translate) rotate(var(--blob-rotation)) translateY(-8px); }
        90%  { transform: var(--blob-translate) rotate(var(--blob-rotation)) translateY(28px); }
        95%  { transform: var(--blob-translate) rotate(var(--blob-rotation)) translateY(-8px); }
        100% { transform: var(--blob-translate) rotate(var(--blob-rotation)) translateY(0); }
    }
    .blob--1 {
        width: calc(var(--blob-w) * 0.29);
        height: calc(var(--blob-h) * 0.29);
        top: 20%;
        left: calc(var(--blob-w) * -0.35);
    }
    .blob--2 {
        width: calc(var(--blob-w) * 0.29);
        height: calc(var(--blob-h) * 0.29);
        top: -27%;
        left: 0;
    }
    .blob--3 {
        width: calc(var(--blob-w) * 0.225);
        height: calc(var(--blob-h) * 0.215);
        top: -28%;
        left: 60%;
    }
    .blob--4 {
        width: calc(var(--blob-w) * 0.5);
        height: calc(var(--blob-h) * 0.517);
        top: -35%;
        left: 90%;
    }
    .blob--5 {
        width: calc(var(--blob-w) * 0.15);
        height: calc(var(--blob-h) * 0.155);
        top: 45%;
        left: 105%;
    }
    .blob--6 {
        width: calc(var(--blob-w) * 0.36);
        height: calc(var(--blob-h) * 0.37);
        top: 40%;
        left: 135%;
    }
    .blob--7 {
        width: calc(var(--blob-w) * 0.29);
        height: calc(var(--blob-h) * 0.29);
        top: 70%;
        left: 105%;
    }
    .blob--1, .blob--2, .blob--5, .blob--7 {
        background-color: var(--c-secondary);
    }
    .blob--3, .blob--4, .blob--6 {
        background-color: var(--c-primary-lt);
    }
    .blob__slogan {
        margin: 0;
        color: var(--c-text-secondary);
        transform: rotate(calc(var(--blob-rotation) * -1));
        font-size: var(--fs-lg);
        letter-spacing: 0.05em;
        line-height: 1.3;
        text-align: center;
        max-width: 15rem;
        transition: opacity var(--slogan-transition-fade);
    }
    @media (max-width: 1300px) {
        .blob--main {
            --blob-w: 300px;
            --blob-h: 480px;
        }      
        .blob__slogan {
            font-size: 3rem;
        }
    }
</style>

<?php
    $img = get_field('obrazek_glowny');

    $slogans = [];
    for ($i = 1; $i <= 7; $i++) {
        $slogans[] = get_field('slogan_' . $i);
    }

    $icons = [
        get_template_directory_uri() . '/assets/images/icons/helm.png',
        get_template_directory_uri() . '/assets/images/icons/microphone.png',
        get_template_directory_uri() . '/assets/images/icons/note.png',
        get_template_directory_uri() . '/assets/images/icons/pirate.png',
        get_template_directory_uri() . '/assets/images/icons/gituar.png',
        get_template_directory_uri() . '/assets/images/icons/ship.png',
        get_template_directory_uri() . '/assets/images/icons/wave.png',
    ];

    $shuffled_icons = $icons;
    shuffle($shuffled_icons);
?>

<section class="hero">
    <div class="hero__content container">
        <?php if($img): ?>
            <img class="hero__logo" src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" width="350" height="auto">
        <?php endif; ?>
        <span class="hero__subtext"><?php the_field('sub_tekst'); ?></span>
        <p class="hero__text"><?php the_field('tekst_powitalny'); ?></p>
    </div>

    <div class="hero__animation-container">
        <div class="hero__animation-content">
            <div class="blob blob--main">
                <p class="blob__slogan"><?= esc_html($slogans[0]) ?></p>
                <?php for ($i = 1; $i <= 7; $i++): ?>
                <div class="blob blob--<?= $i ?>">
                    <img src="<?= esc_url($shuffled_icons[$i - 1]) ?>" alt="">
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>

<script>
    const slogans = <?= json_encode(array_values(array_filter($slogans))) ?>;
    const icons = <?= json_encode($icons) ?>;
    let currentSlogan = 0;

    function shuffleArray(arr) {
        const a = [...arr];
        for (let i = a.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [a[i], a[j]] = [a[j], a[i]];
        }
        return a;
    }

    const ANIM_DURATION = 8000;
    const CHANGE_AT = ANIM_DURATION * 0.90;
    const FADE_DURATION = 150;

    const blobMain = document.querySelector('.blob--main');
    const slogan = document.querySelector('.blob__slogan');
    const blobImgs = document.querySelectorAll('.blob--1 img, .blob--2 img, .blob--3 img, .blob--4 img, .blob--5 img, .blob--6 img, .blob--7 img');

    let changeTimer = null;

    function scheduleChange() {
        clearTimeout(changeTimer);

        changeTimer = setTimeout(() => {
            slogan.style.opacity = '0';
            blobImgs.forEach(img => img.style.opacity = '0');

            setTimeout(() => {
                currentSlogan = (currentSlogan + 1) % slogans.length;
                slogan.textContent = slogans[currentSlogan];

                const newIcons = shuffleArray(icons);
                blobImgs.forEach((img, i) => img.src = newIcons[i]);

                slogan.style.opacity = '1';
                blobImgs.forEach(img => img.style.opacity = '1');
            }, FADE_DURATION);

        }, CHANGE_AT);
    }

    blobMain.addEventListener('animationiteration', () => {
        scheduleChange();
    });

    scheduleChange();
</script>