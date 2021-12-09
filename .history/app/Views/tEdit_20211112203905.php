<?php ob_clean(); foreach($equipFieldNames as $key => $val):
    if ($val == 'DESCRIPTION' || $val == 'DETAILS'):?>
        <div class="col-md-3">
            <label for="NAME"><?=$val?></label>
        </div>
        <div class="col-md-9">
            <textarea type="text" id="<?=$val?>" name="fav_language"><?=$invTemp->{$val}?></textarea>
        </div>
    <?php elseif ($val == 'ITEM_CLASS' || $val == 'IMG_CLASS'):?>
        <div class="col-md-3">
            <label for="NAME"><?=$val?></label>
        </div>
        <div class="outline col-md-9 pm-0">
            <input type="text" id="<?=$val?>" name="fav_language" value="<?=$invTemp->{$val}?>">
            <input type="button" id="btn<?=$val?>" name="fav_language" value=">">
        </div>
        <?php elseif ($val == 'ITEM_ID'):?>
            <?php $in = ($invTemp->ITEM_CLASS!=="WEAPON") ? ' invisible': null; ?>
        <div class="col-md-3<?=$in?>">
            <label for="NAME"><?=$val?></label>
        </div>
        <div class="col-md-9<?=$in?>">
            <input type="text" id="<?=$val?>" name="fav_language" value="<?=$invTemp->{$val}?>">
            <input type="button" id="btn<?=$val?>" name="fav_language" value=">" >
        </div>
    <?php else: ?>
    <div class="col-md-3">
        <label for="NAME"><?=$val?></label>
    </div>
    <div class="col-md-9">
        <input type="text" id="<?=$val?>" name="fav_language" value="<?=$invTemp->{$val}?>">
    </div>

<?php endif; ?>
<?php endforeach; ?>