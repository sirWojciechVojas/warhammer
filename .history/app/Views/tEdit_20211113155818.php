<?php ob_clean(); ?>
<form id="add_edit" class="row col-md-12" name="data" method="post">
<?php foreach($equipFieldNames as $key => $val):
    if ($val == 'ID' || $val == 'NAME'):?>
    <div class="form-floating col-md-<?=(1+$key)?>">
        <label for="<?=$val?>"><?=$val?></label>
    </div>
    <div class="form-row col-md-<?=(2+5*$key)?> pm-0">
        <input type="text" class="form-control-sm w-100" id="<?=$val?>" name="<?=$val?>" value="<?=$invTemp->{$val}?>">
    </div>
    <?php elseif ($val == 'DESCRIPTION' || $val == 'DETAILS'):?>
    <div class="form-flating col-md-12">
        <label for="NAME"><?=$val?></label>
        <textarea type="text" class="form-control w-100 noR" id="<?=$val?>" name="<?=$val?>" rows="<?=(8-$key)?>"><?=$invTemp->{$val}?></textarea>
    </div>
    <?php elseif ($val == 'ITEM_CLASS' || $val == 'IMG_CLASS'):?>
    <div class="col-md-3">
        <label for="NAME"><?=$val?></label>
    </div>
    <div class="form-row align-items-center col-md-3 pm-0">
        <input type="text" class="form-control-sm col-md-10" id="<?=$val?>" name="<?=$val?>" value="<?=$invTemp->{$val}?>">
        <input type="button" class="btn btn-outline-info btn-sm col-md-2" id="btn<?=$val?>" name="fav_language" value=">">
    </div>
    <?php elseif ($val == 'ITEM_ID'):?>
    <?php $in = ($invTemp->ITEM_CLASS!=="WEAPON") ? ' invisible': null; ?>
    <div class="col-md-3<?=$in?>">
        <label for="NAME"><?=$val?></label>
    </div>
    <div class="form-row align-items-center col-md-3 pm-0<?=$in?>">
        <input type="text" class="form-control-sm col-md-10" id="<?=$val?>" name="<?=$val?>" value="<?=$invTemp->{$val}?>">
        <input type="button" class="btn btn-outline-info btn-sm col-md-2" id="btn<?=$val?>" name="fav_language" value=">" >
    </div>
    <?php else: ?>
    <div class="col-md-3">
        <label for="NAME"><?=$val?></label>
    </div>
    <div class="form-row align-items-center col-md-3 pm-0">
        <input type="text" class="form-control-sm w-100" id="<?=$val?>" name="<?=$val?>" value="<?=$invTemp->{$val}?>">
    </div>
<?php endif; ?>
<?php endforeach; ?>
</form>