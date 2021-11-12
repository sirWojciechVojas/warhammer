<?php ob_clean(); foreach($iClass as $key => $val): ?>
    <div class="col-md-12">
        <input class="btn btn-primary" type="button" name="fav_language" value="<?=$val?>">
    </div>
<?php endforeach; ?>