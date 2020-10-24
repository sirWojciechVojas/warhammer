<?php ob_clean(); if($type=='A' || $type=='B') :?>
    <?php foreach ($slots[$type] as $index => $value) : ?>
    <?php
        if(preg_match('#_#',$value)) {$valueN = explode('_',$value)[0].'s'; $value=preg_replace('#_#','',$value);}
        else $valueN=$value;
    ?>
    <div class="inventory-row severalSlots ABSlots" data-item-filter-whitelist="<?=$valueN?>">
        <?php if($index==2) :?>
            <div class="inventory-cell <?=$value?>1"></div>
            <div class="inventory-cell <?=$value?>2"></div>
        <?php else :?>
            <div class="inventory-cell <?=$value?>"></div>
        <?php endif ?>
    </div>
    <?php endforeach ?>
    <?php elseif($type=='handy') :?>
        <div class="inventory-row severalSlots handySlots d-flex" data-item-filter-whitelist="handy">
        <?php foreach ($slots[$type] as $index => $value) :
            $newClass = ($index>=2) ? ' quick' : ' quiver';
            $marginAuto = ($index==1) ? ' mr-auto' : null;?>
            <div class="inventory-cell <?=$value.$newClass.$marginAuto?>"></div>
        <?php endforeach ?>
        </div>
    <?php else: for($i=0;$i<$imax;$i++) :?>
        <div class="inventory-row">
            <?php for($j=0;$j<$jmax;$j++) :?>
            <div class="inventory-cell" data-slot-position-x="<?=$j?>" data-slot-position-y="<?=$i?>"></div>
            <?php endfor?>
        </div>
        <?php endfor ?>
    <?php endif ?>
<input id="invBG" type="hidden" value="<?=$invBG?>"/>
<?php exit(); ?>