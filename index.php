<?php
include 'bootstrap.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $layout = Layout::getInstance();?>
    <?php echo $layout->connectCSS() ?>
    <meta charset="UTF-8">
    <title>Мой сайт</title>
</head>
<body>
<div class="container">
    <div class="goods">
        <div class="goods__cart"><img src="https://chelyabinsk.foodtaxi.ru/upload/resize_cache/iblock/736/520_400_2/Margarita_700x700.jpg?1588315811192755" class="goods__img">
            <span class="goods__name">Пицца Маргарита</span>
        </div>
        <div class="goods__cart">
            <img src="https://chelyabinsk.foodtaxi.ru/upload/resize_cache/iblock/4f7/520_400_2/Peperoni_700x700.jpg?1588165006193364" class="goods__img">
            <span class="goods__name">Пицца Пепперони</span>
        </div>
        <div class="goods__cart"><img src="https://chelyabinsk.foodtaxi.ru/upload/resize_cache/iblock/1e3/520_400_2/Karri_700x700.jpg?1588265900185077" class="goods__img">
            <span class="goods__name">Пицца Карри</span>
        </div>
        <div class="goods__cart">
            <img src="https://chelyabinsk.foodtaxi.ru/upload/resize_cache/iblock/06d/520_400_2/Sirnaya_700x700.jpg?1588174744182003" class="goods__img">
            <span class="goods__name">Пицца Сырная</span>
        </div>
    </div>
</div>
</body>
</html>
