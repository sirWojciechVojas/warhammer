<?php ob_clean(); foreach($equipFieldNames as $key => $val):
    if ($val == 'ID' || $val == 'NAME'):?>
        <div class="form-floating col-md-<?=(1+$key)?> outline">
            <label for="<?=$val?>"><?=$val?></label>
        </div>
        <div class="form-row outline col-md-<?=(2+3*$key)?> pm-0">
            <input type="text" class="form-control-sm w-100" id="<?=$val?>" name="fav_language" value="<?=$invTemp->{$val}?>">
        </div>
    <?php elseif ($val == 'DESCRIPTION' || $val == 'DETAILS'):?>
        <div class="col-md-2">
            <label for="NAME"><?=$val?></label>
        </div>
        <div class="form-row align-items-center outline col-md-10 pm-0">
            <textarea type="text" class="form-control w-100 noR" id="<?=$val?>" name="fav_language" rows="6"><?=$invTemp->{$val}?></textarea>
        </div>
    <?php elseif ($val == 'ITEM_CLASS' || $val == 'IMG_CLASS'):?>
        <div class="col-md-2">
            <label for="NAME"><?=$val?></label>
        </div>
        <div class="form-row align-items-center outline col-md-4 pm-0">
            <input type="text" class="form-control-sm col-md-11 pm-0" id="<?=$val?>" name="fav_language" value="<?=$invTemp->{$val}?>">
            <input type="button" class="btn btn-secondary col-md-1 pm-0" id="btn<?=$val?>" name="fav_language" value=">">
        </div>
        <?php elseif ($val == 'ITEM_ID'):?>
            <?php $in = ($invTemp->ITEM_CLASS!=="WEAPON") ? ' invisible': null; ?>
        <div class="col-md-2<?=$in?>">
            <label for="NAME"><?=$val?></label>
        </div>
        <div class="form-row align-items-center outline col-md-4 pm-0<?=$in?>">
            <input type="text" class="form-control-sm col-md-11 pm-0" id="<?=$val?>" name="fav_language" value="<?=$invTemp->{$val}?>">
            <input type="button" class="btn btn-secondary col-md-1 pm-0" id="btn<?=$val?>" name="fav_language" value=">" >
        </div>
    <?php else: ?>
    <div class="col-md-2">
        <label for="NAME"><?=$val?></label>
    </div>
    <div class="form-row align-items-center outline col-md-4 pm-0">
        <input type="text" class="form-control-sm w-100" id="<?=$val?>" name="fav_language" value="<?=$invTemp->{$val}?>">
    </div>

<?php endif; ?>
<?php endforeach; ?>