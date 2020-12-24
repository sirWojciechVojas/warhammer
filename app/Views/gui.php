<?php if($what=='UmZd') : ?>
<div class="col-md-5 offset-md-1 skills-talents d-flex flex-column">
    <?php foreach ($allMySkills as $k => $val) : ?>
    <?php if ((int) $val['STATUS'] !== 0) : ?>
        <div class="skill-talent" data-toggle="tooltip" data-placement="left" data-original-title="<?= htmlspecialchars('<h3><b>' . $val['NAME'] . '</b></h3><h4>' . $val['DESCRIPTION'] . '</h4>') ?>">
            <input type="text" readonly="true" class="L-<?= $val['STATUS'] ?>" /><?= $val['NAME'] ?>
        </div>
    <?php endif ?>
    <?php endforeach ?>
</div>
<div class="col-md-5 skills-talents d-flex flex-column">
    <?php foreach ($allMyTalents as $k => $val) : ?>
    <?php if ((int) $val['STATUS'] !== 0) : ?>
        <div class="skill-talent" data-toggle="tooltip" data-placement="right" data-original-title="<?= htmlspecialchars('<h3><b>' . $val['NAME'] . '</b></h3><h4>' . $val['DESCRIPTION'] . '</h4>') ?>">
            <input type="text" readonly="true" class="R-<?= $val['STATUS'] ?>" /><?= $val['NAME'] ?>
        </div>
    <?php endif ?>
    <?php endforeach ?>
</div>
<?php elseif($what=='PDBar') : ?>
<div class="col-md-12 PDBar d-flex" data-toggle="tooltip" data-placement="top"
    title="<?= htmlspecialchars('<h6><b>Punkty Doświadczenia</b></h6><h6><u>Pasek kompleksowy</u></h6><h6>' . $PD[1] . '/' . $PD[3] . ' PD<br>(niewykorzytane: ' . $PD[5] . ' PD)</h6>') ?>">
    <div class="PD-1 myPointer" style="width:<?= $PD[6] ?>%;"></div>
    <div class="PD-5 myPointer" style="width:<?= $PD[9] ?>%;"></div>
    <input type="hidden" id="curexp" value="<?= $PD[5] ?>" />
    <input type="hidden" id="minexp" value="<?= $PD[2] ?>" />
    <input type="hidden" id="nowexp" value="<?= $PD[4] ?>" />
</div>
<div class="col-md-12 PDBar d-flex" data-toggle="tooltip" data-placement="top"
    data-original-title="<?= htmlspecialchars('<h6><b>Punkty Doświadczenia</b></h6><h6><u>Pasek minimalny</u></h6><h6>' . $PD[4] . '/' . $PD[2] . ' PD<br>(niewykorzytane: ' . $PD[5] . ' PD)</h6>'); ?>">
    <div class="PD-4 myPointer" style="width:<?= $PD[8] ?>%;"></div>
    <div class="PD-5 myPointer" style="width:<?= $PD[9] ?>%;"></div>
</div>
<?php endif ?>