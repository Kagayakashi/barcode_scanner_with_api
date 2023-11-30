<?php
$title = 'Главная';
?>

<!DOCTYPE html>
<html lang="ru">
<!-- HTML:HEADER -->

<head>
    <?= h_html_header($title); ?>
    <!-- STYLES -->
</head>

<body>

<div class="container">

<!-- BODY:HEADER -->
<header>
<?= h_html_nav_block(); ?>
<?= h_html_logo(); ?>
<?= h_html_body_title($title); ?>
</header>

<!-- BODY:CONTENT -->
<main>
<?= h_html_form_begin('get'); ?>
<?= h_html_form_button('scanning', 'Сканирование'); ?>
<?= h_html_form_end(); ?>

<?= h_html_form_begin('get'); ?>
<?= h_html_form_button('signin', 'Вход'); ?>
<?= h_html_form_end(); ?>

</main>

<!-- BODY:FOOTER -->
<footer>
<?= h_html_footer(); ?>
</footer>

</div>
<!-- SCRIPTS -->

<!-- -->

</body>
</html>
