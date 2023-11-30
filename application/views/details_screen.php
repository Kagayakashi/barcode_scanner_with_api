<?php
$title = 'Информация об изделии';
?>

<!DOCTYPE html>
<html lang="ru">
<!-- HTML:HEADER -->

<head>
    <?= h_html_header($title); ?>
    <!-- STYLES -->
    <link rel="stylesheet" href="css/details.css"> 
</head>

<body>

<div class="container">

<!-- BODY:HEADER -->
<header>
<?= h_html_nav_block(); ?>
<?= h_html_body_title($title); ?>
</header>

<!-- BODY:CONTENT -->
<main>
    <div class="table_result">
        <div class="field_data">
            <?= h_html_form_field_label('item_img', 'Изображение'); ?>
            <img id="item_img" class="field_image">
        </div>
        
        <div class="field_data">
        <?= h_html_form_field_label('item_ean13', 'EAN13'); ?>
        <?= h_html_form_field_readonly('item_ean13'); ?>
        </div>
        
        <div class="field_data">
        <?= h_html_form_field_label('item_name', 'Наименование'); ?>
        <?= h_html_form_field_readonly('item_name', '', 'item_name_id'); ?>
        </div>
        
        <div class="field_data">
        <?= h_html_form_field_label('item_part', 'Партия'); ?>
        <?= h_html_form_field_readonly('item_part', '', 'item_part_id'); ?>
        </div>
        
        <div class="field_data">
        <?= h_html_form_field_label('item_base', 'Цех'); ?>
        <?= h_html_form_field_readonly('item_base', '', 'item_base_id'); ?>
        </div>
        
        <div class="field_data">
        <?= h_html_form_field_label('item_date', 'Дата создания'); ?>
        <?= h_html_form_field_readonly('item_date'); ?>
        </div>
        
        <div class="field_data">
        <?= h_html_form_field_label('item_details', 'Описание'); ?>
        <textarea name="item_details" id="item_details" class="readonly" cols="22" readonly></textarea>
        </div>
    </div>
    
    <?php
    if($_SESSION['logged_in']) {
        echo h_html_form_begin('get');
        echo h_html_form_button('editing', 'Изменить');
        echo h_html_form_end();
        
        echo h_html_form_begin('get');
        echo h_html_form_button('create', 'Регистрация');
        echo h_html_form_end();
    }
    ?>
    
    <?= h_html_form_begin('get'); ?>
    <?= h_html_form_button('scanning', 'Сканирование'); ?>
    <?= h_html_form_end(); ?>
    
</main>

<!-- BODY:FOOTER -->
<footer>
<?= h_html_footer(); ?>
</footer>

</div>
<!-- SCRIPTS -->

<script type="text/javascript" src="js/details.js"></script>

<!-- -->

</body>
</html>
