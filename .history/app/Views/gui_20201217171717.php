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