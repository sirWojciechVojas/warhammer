<?php ob_clean(); foreach($iClass as $key => $val): ?>
    <input class="btn btn-primary mb-1" type="button" name="fav_language" data-key="<?=++$key?>" value="<?=$val?>">
<?php endforeach; ?>
    <input id="what" type="hidden" value="<?=$what?>"/>
    <input id="content" type="hidden" value="<?=htmlspecialchars($content)?>"/>