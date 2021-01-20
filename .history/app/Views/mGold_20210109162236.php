<?php ob_clean(); ?>
<?php if ($prefix == 'Imperium'): ?>
<div class="col-md-12 d-flex justify-content-center" style="padding:0;">
    <div class="crown"></div>
    <div><input type="text" readonly="true" value="<?= $mGold->mCrown ?> zk"></div>
    <div class="shilling"></div>
    <div><input type="text" readonly="true" value="<?= $mGold->mShilling ?> s"></div>
    <div class="brass"></div>
    <div><input type="text" readonly="true" value="<?= $mGold->mPenny ?> p"></div>
    <input type="hidden" id="hBrass" value="<?= $mGold->hBrass ?>" />
</div>
<?php elseif ($prefix == 'Bretonia'): ?>
<div class="col-md-12 d-flex justify-content-center" style="padding:0;">
    <div class="crown"></div>
    <div><input type="text" readonly="true" value="<?= $mGold->mCrown ?> zk"></div>
    <div class="shilling"></div>
    <div><input type="text" readonly="true" value="<?= $mGold->mShilling ?> s"></div>
    <input type="hidden" id="hBrass" value="<?= $mGold->hBrass ?>" />
</div>
<?php endif; ?>
<?php exit(); ?>