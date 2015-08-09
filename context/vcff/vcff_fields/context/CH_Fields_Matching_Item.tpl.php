<div data-vcff-field-name="<?php echo $machine_code; ?>" class="vcff-field ch-field ch-matching <?php echo $extra_class; ?> <?php echo $css_class; ?>" <?php if ($this->Is_Hidden()): ?>style="display:none;"<?php endif; ?>>
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
    <div>
        <?php echo $_input['left']; ?>
        <select name="<?php echo $machine_code; ?>[<?php echo $_input['i']; ?>]" class="<?php echo $extra_class; ?>">
            <option value="">_________</option>
        <?php foreach ($_input['right'] as $_k => $_answer): ?>
            <option value="<?php echo $_answer; ?>" <?php if (is_array($posted_value) && isset($posted_value[$_input['i']]) && $posted_value[$_input['i']] == $_answer): ?> selected="selected"<?php endif; ?>><?php echo $_answer; ?></option>
        <?php endforeach; ?>
        </select>
    </div>
    <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>


