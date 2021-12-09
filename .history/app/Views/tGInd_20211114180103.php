<?php ob_clean(); foreach($tGoods as $key => $tab): ?>

<div class="tradingGood outline d-flex align-items-center">
    <div class="flex-shrink-0 outline">
        <img src="<?= base_url('../assets/img/inventory/Inventory_L[72x72]/'.$tab['IMG_CLASS'].'.png') ?>"/>
    </div>
    <div class="flex-grow-1 px-2 list-group-item-text outline"><b><?= $tab['NAME'] ?></b><br><?= mb_substr($tab['DESCRIPTION'], 0, 24, 'UTF-8') ?>...</div>
    <?= $controller->mGoldPanel('Imperium','Goods', $controller->mGoldCalc($tab['PRIZE'],null)) ?>
</div>
<?php endforeach; ?>