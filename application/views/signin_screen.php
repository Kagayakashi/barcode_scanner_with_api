<?php
$title = 'Авторизация';
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
<?= h_html_form_begin('post'); ?>

<?= h_html_form_field_label('username', 'Пользователь:'); ?>
<?= h_html_form_field_input('username', 'text', 'required'); ?>

<?= h_html_form_field_label('password', 'Пароль:'); ?>
<?= h_html_form_field_input('password', 'password', 'required'); ?>

<?= h_html_form_button('signing', 'Войти'); ?>

<?= h_html_form_end(); ?>

<?= h_html_form_begin('get'); ?>
<?= h_html_form_button('password_reset', 'Сброс пароля'); ?>
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
