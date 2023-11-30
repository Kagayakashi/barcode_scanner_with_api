<?php
$title = 'Сброс пароля';
?>

<!DOCTYPE html>
<html lang="ru">
<!-- HTML:HEADER -->

<head>
    <?= h_html_header($title); ?>
    <!-- STYLES -->
</head>

<body>
<!-- HTML:BODY -->

<div class="container">

<!-- BODY:HEADER-->
<header>
<?= h_html_nav_block(); ?>
<?= h_html_logo(); ?>
<?= h_html_body_title($title); ?>
</header>

<!-- BODY:CONTENT -->
<main>

<div class="password_match">
    <span id="message"></span>
</div>

<?= h_html_form_begin('post'); ?>

<?= h_html_form_field_label('email', 'E-Mail:'); ?>
<?= h_html_form_field_input('email', 'text', 'required'); ?>

<?= h_html_form_button('password_reset', 'Сбросить'); ?>

<?= h_html_form_end(); ?>

</main>

<!-- BODY:FOOTER -->
<footer>
<?= h_html_footer(); ?>
</footer>

</div>

<!-- SCRIPTS -->
<script type="text/javascript" src="js/password_change.js"></script>
<!-- -->

</body>
</html>
