<?php ob_clean(); for($i=0;$i<$imax;$i++) :?>
<div class="inventory-row">
    <?php for($j=0;$j<$jmax;$j++) :?>
    <div class="inventory-cell" data-slot-position-x="<?=$j?>" data-slot-position-y="<?=$i?>"></div>
    <?php endfor?>
</div>
<?php endfor?>
<?php exit(); ?>