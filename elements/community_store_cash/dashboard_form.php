<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
extract($vars);
?>

<div class="form-group">
    <label><?= t("Minimum Order Value")?></label>
    <input type="text" name="cashMinimum" value="<?= $cashMinimum?>" class="form-control">
</div>

<div class="form-group">
    <label><?= t("Maximum Order Value")?></label>
    <input type="text" name="cashMaximum" value="<?= $cashMaximum?>" class="form-control">
</div>

<div class="form-group">
    <label><?= t("Payment Instructions")?></label>
    <?php $editor = \Core::make('editor');
    echo $editor->outputStandardEditor('cashPaymentInstructions', $cashPaymentInstructions);?>
</div>


