<?php
$title = 'Регистрация изделия';
$names = $_SESSION['dict_list']['items'];
$parts = $_SESSION['dict_list']['parts'];
$bases = $_SESSION['dict_list']['bases'];

$how_to_camera = 'Сосканируйте штрих-код.';
$how_to_ean13 = 'Либо укажите номер штрих-кода вручную.';
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

<?= h_html_text_paragraph('how_to_camera', $how_to_camera); ?>

<div id="scan_camera">
    <video id="video"></video>
</div>
</header>

<!-- BODY:CONTENT -->
<main>
    <div class="table_result">
        
        <?= h_html_form_begin('post', 'create_form'); ?>
        
        <?= h_html_text_paragraph('how_to_ean13', $how_to_ean13); ?>
    
        <div class="field_data">
        <?= h_html_form_field_label('item_ean13', 'EAN13'); ?>
        <?= h_html_form_field_input('item_ean13', 'text', 'required', 13); ?>
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
        
        <?= h_html_form_button('create', 'Регистрировать'); ?>
        
        <?= h_html_form_end(); ?>
        
    </div>
</main>

<!-- BODY:FOOTER -->
<footer>
<?= h_html_footer(); ?>
</footer>

</div>

<!-- SCRIPTS -->
<script type="text/javascript" src="js/ion.sound.min.js"></script>
<script type="text/javascript" src="js/zxing.min.js"></script>
<script type="text/javascript" src="js/create.js"></script>

<!-- -->

</body>
</html>
