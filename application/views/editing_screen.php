<?php
$title = 'Изменение данных изделия';
$names = $_SESSION['dict_list']['items'];
$parts = $_SESSION['dict_list']['parts'];
$bases = $_SESSION['dict_list']['bases'];
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
<?= h_html_body_title($title); ?>
</header>

<!-- BODY:CONTENT -->
<main>
    <div class="table_result">
    
        <div class="field_data">
            <?= h_html_form_field_label('item_img', 'Изображение'); ?>
            <img id="item_img" class="field_image">
        </div>
        
        <?= h_html_form_begin('post'); ?>
        
        <div class="field_data">
        <?= h_html_form_field_label('item_ean13', 'EAN13'); ?>
        <?= h_html_form_field_readonly('item_ean13'); ?>
        </div>
        
        <div class="field_data">
        <?= h_html_form_field_label('item_name', 'Наименование'); ?>
        <?= h_html_form_field_datalist('item_name', 'text', $names, 'requried', '', 'item_name_id'); ?>
        </div>
        
        <div class="field_data">
        <?= h_html_form_field_label('item_part', 'Партия'); ?>
        <?= h_html_form_field_datalist('item_part', 'text', $parts, 'requried', '', 'item_part_id'); ?>
        </div>
        
        <div class="field_data">
        <?= h_html_form_field_label('item_base', 'Цех'); ?>
        <?= h_html_form_field_readonly('item_base', $_SESSION['base'], 'item_base_id', $_SESSION['base_id']); ?>
        </div>
        
        <div class="field_data">
        <?= h_html_form_field_label('item_date', 'Дата создания'); ?>
        <?= h_html_form_field_readonly('item_date', date('Y').'-'.date('m').'-'.date('d')); ?>
        </div>
        
        <?= h_html_form_button('editing', 'Сохранить', 'button_green'); ?>
        
        <?= h_html_form_end(); ?>
        
    </div>
</main>

<!-- BODY:FOOTER -->
<footer>
<?= h_html_footer(); ?>
</footer>

</div>
<!-- SCRIPTS -->

<script type="text/javascript" src="js/editing.js"></script>

<!-- -->

</body>
</html>
