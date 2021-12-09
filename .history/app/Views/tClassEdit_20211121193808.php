<?php ob_clean(); ?>
<?php if($what=='IMG_CLASS'): ?>
<div class="col-md-12 d-flex justify-content-space-around pm-0">
    <div class="row d-flex w-100 pm-0 overflow-auto">
    <div class="row col-md-6 d-flex pt-1 pb-1 pm-0 w-100 h-auto">
            <div class="col-md-12 d-flex pt-1 pb-1 pm-0 w-100 h-auto bg-secondary justify-content-around">
            <?php foreach($invItem as $key => $ival): ?>
            <?php if($key%20 == 0 && $key!==0 && $key%round(count($invItem)/2)!== 0): ?>
            </div><div class="col-md-12 d-flex pt-1 pb-1 pm-0 w-100 h-auto bg-secondary justify-content-around">
            <?php elseif($key%round(count($invItem)/2) == 0 && $key!==0 ): ?>
            </div>
        </div><div class="row col-md-6 d-flex pt-1 pb-1 pm-0 w-100 h-auto">
            <div class="col-md-12 d-flex pt-1 pb-1 pm-0 w-100 h-auto bg-secondary justify-content-around">
            <?php endif; ?>
                <div title="<?=$ival?>" class="p-2 bg-dark imgClass inventory-item <?=$ival?> text-light mask rgba-red-strong"></div>
                <!-- <div class="outline col-md-3 text-light">GM</div>
                <div class="outline col-md-3 text-light">Wycena Kupca</div>
                <div class="outline col-md-3 text-light">Koszt</div>
                <div class="outline col-md-3 text-light">Targowanie</div> -->
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<?php foreach($iClass as $key => $val): ?>
    <input class="btn btn-primary mb-1" type="button" name="fav_language" data-key="<?=++$key?>" value="<?=$val?>">
<?php endforeach; ?>
<?php endif; ?>
<input id="what" type="hidden" value="<?=$what?>"/>
<input id="content" type="hidden" value="<?=htmlspecialchars($content)?>"/>