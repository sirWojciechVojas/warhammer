<?php ob_clean(); foreach($co as $key => $val): ?>
    <input class="btn btn-primary mb-1" type="button" name="fav_language" data-key="<?=++$key?>" value="<?=$val?>">
<?php endforeach; ?>