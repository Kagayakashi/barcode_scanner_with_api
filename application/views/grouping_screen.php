<?php
$title = 'Комплектование изделия на этапе сборки';
$item_list = '';
$base = '';
$buttons = '';
$set = '';

if($_SESSION['adding']['item_amount'] > 0) {
    $i = 1;
    while($i <= $_SESSION['adding']['item_amount']) {
        $item_list .= '<div class="field_data" id="item_list_'.$i.'">'.
        h_html_form_field_label('item_name', 'Изделие '.$i.'').
        h_html_form_field_readonly('item_name_'.$i, $_SESSION['adding'][$i]['item_name']).'
        </div>';
        $i++;
    }
    
    $base .= '<div class="field_data">'.
        h_html_form_field_label('item_base', 'Цех').
        h_html_form_field_readonly('item_base', $_SESSION['base']).
        '</div>';

    $set .= '<div class="field_data">'.
        h_html_form_field_label('item_set', 'Комплектация').
        h_html_form_field_readonly('item_set', $_SESSION['adding']['number']).'
        </div>';
    
    $buttons .= h_html_form_button('setup_group', 'Завершить комплектацию', 'button_blue button_large').
                h_html_form_end().
                
                h_html_form_begin('get').
                h_html_form_button('cancel_group', 'Отменить комплектацию', 'button_red button_large').
                h_html_form_end();
}
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
        
        <?= h_html_form_begin('get'); ?>
        <?= h_html_form_button('add_to_group', 'Добавить изделие', 'button_green button_large'); ?>
        <?= h_html_form_end(); ?>
        
        <?= h_html_form_begin('post'); ?>
        
        <div class="field_data">
        <?= h_html_form_field_label('item_date', 'Дата создания'); ?>
        <?= h_html_form_field_readonly('item_date', date('Y').'-'.date('m').'-'.date('d')); ?>
        </div>
        
        <?= $item_list; ?>
        
        <?= $base; ?>
        
        <?= $set; ?>
        
        <?= $buttons; ?>
        
    </div>
</main>

<!-- BODY:FOOTER -->
<footer>
<?= h_html_footer(); ?>
</footer>

</div>
<!-- SCRIPTS -->

<script type="text/javascript" src="js/grouping.js"></script>

<!-- -->

</body>
</html>
