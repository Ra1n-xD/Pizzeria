<?php
require_once '../include/db.php';
require_once '../include/header.php';
require_once  '../include/slider.php';
?>

<?php
$selectProduct = "SELECT * from product";
$allProduct = $db->query($selectProduct);
$product = $allProduct->FetchAll(PDO::FETCH_NUM);
// session_destroy();
?>
<section class=" container col-10 mt-5">
    <pre><?= print_r($_SESSION, 1) ?></pre>
</section>


<section class="menu container col-9 mt-5" id="pizza">
    <h3 class="text-left">Пицца </h3>
    <div id="itemWrapper">

        <div class="row pt-3">
            <? foreach ($product as $ID => $item) : ?>
                <? if ($item[1] == 1) : ?>
                    <div class="col-3 pb-3">
                        <div class="card border-3">
                            <div class="card-body border-3">
                                <img class="card-img-top" src="../img/<?= $item[6] ?>" alt="Card image cap">

                                <h5 class="card-title pizza-name"><?= $item[2] ?></h5>
                                <div class="card-text pb-2">Цена: <?= $item[3] ?> руб</div>
                                <div class="card-text pb-2">Вес: <?= $item[4] ?> гр</div>
                                <div class="card-text pb-2">
                                    <? if ($item[5]) : ?>
                                        <?= "В наличии" ?>
                                    <? else : ?>
                                        <?= "Отсутствует" ?>
                                    <? endif ?>
                                </div>
                                <? if ($item[5]) : ?>
                                    <button type="button" class="w-100 btn btn-outline-danger add-to-cart" data-id="<?= $item[0] ?>" data-toggle="modal" data-target=".bd-example-modal-lg<?= $ID ?>">
                                        Выбрать
                                    </button>
                                <? else : ?>
                                    <a class="w-100 btn btn-outline-secondary">
                                        Выбрать
                                    </a>
                                <? endif ?>
                            </div>
                        </div>
                    </div>
                <? endif ?>
                <div class="modal fade bd-example-modal-lg<?= $ID ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg<?= $ID ?>">
                        <div class="modal-content">
                            <div class="h4 text-center m-2">Добавить к <?= $item[2]  ?></div>

                            <div class="addition-modal">
                                <div class="text-center">---------------------------------------------------------</div>
                                <? $selectAddition = "SELECT * from addition";
                                $allAddition = $db->query($selectAddition);
                                $addition = $allAddition->FetchAll(PDO::FETCH_NUM);
                                foreach ($addition as $ID => $add) : ?>
                                    <div class="add-item m-1">
                                        <div class="text-center h5">
                                            <?= $add[1] ?>
                                        </div>
                                        <div class="text-center pb-2">
                                            Цена: <?= $add[2] ?> рублей
                                        </div>


                                        <button type="button" class="w-50 adition-btn btn btn-outline-danger add-add" data-add="<?= $add[0] ?>">
                                            Добавить
                                        </button>

                                        <!-- < if (!$_SESSION['cart'][$item[0]]['id_addition']) : ?>
                                            <button type="button" class="w-45 btn btn-outline-danger adition-btn add-add id-add-<= $add[0] ?>" data-add="<= $add[0] ?>">
                                                Добавить
                                            </button>
                                        < else : ?>
                                            < foreach ($_SESSION['cart'][$item[0]]['id_addition'] as $ID => $cheak) : ?>
                                                < if ($add[0] != $cheak) : ?>
                                                    <button type="button" class="w-45 btn btn-outline-danger adition-btn add-add id-add-<= $add[0] ?>" data-add="<= $add[0] ?>">
                                                        Добавить
                                                    </button>
                                                < else : ?>
                                                    <button type="button" class="w-45 adition-btn btn btn-outline-info">
                                                        В корзине
                                                    </button>
                                                < endif ?>
                                            <endforeach ?>
                                        <endif ?> -->


                                        <div class="add-info"></div>
                                    </div>
                                    <div class="text-center">---------------------------------------------------------</div>
                                <? endforeach ?>
                            </div>

                        </div>
                    </div>
                </div>
            <? endforeach ?>
        </div>
    </div>
</section>

<section class=" menu container col-9 mt-5" id="snacks">
    <h3 class="text-left">Закуски</h3>
    <div class="row pt-3">
        <? foreach ($product as $ID => $item) : ?>
            <? if ($item[1] == 2) : ?>
                <div class="col-3 pb-3">
                    <div class="card border-3">
                        <div class="card-body  border-3">
                            <img class="card-img-top" src="../img/<?= $item[6] ?>" alt="Card image cap">

                            <h5 class="card-title pizza-name"><?= $item[2] ?></h5>
                            <div class="card-text pb-2">Цена: <?= $item[3] ?> руб</div>
                            <div class="card-text pb-2">Вес: <?= $item[4] ?> гр</div>
                            <div class="card-text pb-2">
                                <? if ($item[5]) : ?>
                                    <?= "В наличии" ?>
                                <? else : ?>
                                    <?= "Отсутствует" ?>
                                <? endif ?>
                            </div>
                            <? if ($item[5]) : ?>
                                <a class="w-100 btn btn-outline-danger add-to-cart" data-id="<?= $item[0] ?>">
                                    Выбрать
                                </a>
                            <? else : ?>
                                <a class="w-100 btn btn-outline-secondary">
                                    Выбрать
                                </a>
                            <? endif ?>
                        </div>
                    </div>
                </div>
            <? endif ?>
        <? endforeach ?>
    </div>
</section>

<section class="menu container col-9 mt-5" id="drinks">
    <h3 class="text-left">Напитки</h3>
    <div class="row pt-3">
        <? foreach ($product as $ID => $item) : ?>
            <? if ($item[1] == 3) : ?>
                <div class="col-3 pb-3">
                    <div class="card border-3">
                        <div class="card-body  border-3">
                            <img class="card-img-top" src="../img/<?= $item[6] ?>" alt="Card image cap">

                            <h5 class="card-title pizza-name"><?= $item[2] ?></h5>
                            <div class="card-text pb-2">Цена: <?= $item[3] ?> руб</div>
                            <div class="card-text pb-2">Вес: <?= $item[4] ?> гр</div>
                            <div class="card-text pb-2">
                                <? if ($item[5]) : ?>
                                    <?= "В наличии" ?>
                                <? else : ?>
                                    <?= "Отсутствует" ?>
                                <? endif ?>
                            </div>
                            <? if ($item[5]) : ?>
                                <a class="w-100 btn btn-outline-danger add-to-cart" data-id="<?= $item[0] ?>">
                                    Выбрать
                                </a>
                            <? else : ?>
                                <a class="w-100 btn btn-outline-secondary">
                                    Выбрать
                                </a>
                            <? endif ?>
                        </div>
                    </div>
                </div>
            <? endif ?>
        <? endforeach ?>
    </div>
</section>

<!-- cart -->
<div class="modal fade cart-modal" id="cart-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Корзина</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-cart-content">

            </div>

        </div>
    </div>
</div>


<?php
require_once '../include/footer.php';
?>