<?php ob_clean(); foreach($equipFTemplate as $key => $tab): ?>

<div class="tradingGood outline d-flex align-items-center <?=$in?>">
    <div class="flex-shrink-0 outline">
        <img src="<?= base_url('../assets/img/inventory/Inventory_L[72x72]/'.$tab['IMG_CLASS'].'.png') ?>"/>
    </div>
    <div class="flex-grow-1 px-2 list-group-item-text outline"><b><?= $tab['ID'].'. '.$tab['NAME'] ?></b><br><?= mb_substr($tab['DESCRIPTION'], 0, 24, 'UTF-8') ?>...</div>
    <?= $controller->mGoldPanel('Imperium','Goods', $controller->mGoldCalc($tab['PRIZE'],null)) ?>
    <input class="idTemp" type="hidden" value="<?=$tab['ID']?>"/>
</div>
<?php endforeach; ?>