<?php ob_clean(); ?>
<form class="row col-md-12 align-items-stretch" name="invBG" method="post">
<?php foreach($indFieldNames as $key => $val):
    if ($val == 'ID' || $val == 'INV_ID'):?>
    <div class="form-floating col-md-<?=(1+$key)?>">
        <label for="<?=$val?>"><?=$val?></label>
    </div>
    <div class="form-row col-md-<?=(2+5*$key)?> pm-0">
        <input type="text" class="form-control-sm w-100" id="<?=$val?>" name="<?=$val?>" value="<?=$idInd->{$val}?>">
    </div>
    <?php elseif ($val == 'PERSONAL_DESC'):?>
    <div class="form-flating col-md-12">
        <label for="NAME"><?=$val?></label>
        <textarea type="text" class="form-control w-100 noR" id="<?=$val?>" name="<?=$val?>" rows="6"><?=$idInd->{$val}?></textarea>
    </div>
    <?php elseif ($val == 'OWNER_OPT' || $val == 'SLOT'):?>
    <div class="col-md-3">
        <label for="NAME"><?=$val?></label>
    </div>
    <div class="form-row align-items-center col-md-9 pm-0">
        <input type="text" class="form-control-sm col-md-10" id="<?=$val?>" name="<?=$val?>" value="<?=$idInd->{$val}?>">
        <input type="button" class="btn btn-outline-info btn-sm col-md-2" id="btn<?=$val?>" name="fav_language" value=">">
    </div>
    <?php else: ?>
    <div class="col-md-3">
        <label for="NAME"><?=$val?></label>
    </div>
    <div class="form-row align-items-center col-md-9 pm-0">
        <input type="text" class="form-control-sm w-100" id="<?=$val?>" name="<?=$val?>" value="<?=$idInd->{$val}?>">
    </div>
<?php endif; ?>
<?php endforeach; ?>
</form>