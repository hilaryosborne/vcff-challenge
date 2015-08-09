<div data-vcff-field-name="<?php echo $machine_code; ?>" class="vcff-field ch-field ch-multi-choice-field <?php echo $extra_class; ?> <?php echo $css_class; ?>" <?php if ($this->Is_Hidden()): ?>style="display:none;"<?php endif; ?>>
    <?php do_action('vcff_field_pre_label',$this); ?>
    <label class="field-label"><?php echo $field_label; ?><?php if ($this->Is_Required()): ?> <span class="required">*</span><?php endif; ?></label>
    <?php do_action('vcff_field_post_label',$this); ?>
	<div class="field-alerts" style="<?php if (!$this->Get_Alerts()): ?>display:none;<?php endif; ?>">
        <?php echo $this->Get_Alerts_HTML(); ?>
    </div>
    <div class="question-text">
        <?php echo $content; ?>
    </div>
    <?php if ($this->inputs && is_array($this->inputs)): ?>
    <div class="question-options">
    <?php foreach ($this->inputs as $k => $_input): ?>
    <div class="radio">
        <label>
            <input type="checkbox" name="<?php echo $machine_code; ?>[]" value="<?php echo $_input['i']; ?>" <?php if ($this->Is_Locked()): ?>disabled="disabled"<?php endif; ?> <?php if (is_array($this->posted_value) && in_array($_input['i'],$this->posted_value)): ?>checked="checked"<?php endif; ?> <?php echo $attributes; ?> <?php if ($is_disabled == 'yes'): ?> disabled="disabled"<?php endif; ?> class="<?php if ($this->Has_Dependents()): ?>check-change<?php endif; ?> <?php echo $field_extra_class; ?>">
            <?php echo $_input['text']; ?>
        </label>
    </div>
    <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

