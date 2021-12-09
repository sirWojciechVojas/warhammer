<?php ob_clean(); foreach($co as $key => $val): ?>
    <input class="btn btn-info mb-1" type="button" name="fav_language" value="<?=$val?>">
    <?php foreach($val as $k => $v): ?>
        <div class="btn-secondary"><?=$v['name']?></div>
        <div class="btn-secondary"><?=$v['value']?></div>
    <?php endforeach; ?>
<?php endforeach; ?>