<?php ob_clean(); ?>
<div class="abbList firstOfList"><?=$skillName?></div>
<!-- <pre>
</pre> -->
<?php foreach($skillsDetails as $k => $skill): ?>
<div class="abbList details" data-toggle="tooltip" data-placement="auto right" data-button="Wykup" title="<?=htmlspecialchars('<h3><b>'.$skillName.' ('.$skill['NAME'].')</b></h3><h4>'.$skill['DESCRIPTION'].'</h4>')?>"><?=$skill['NAME']?></div>
<?php endforeach ?>

<?php exit(); ?>