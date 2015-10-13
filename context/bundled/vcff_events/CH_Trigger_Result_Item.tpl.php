<div data-trigger-code="<?php echo $this->type; ?>" class="trigger-item action-field-group">
    <div class="action-group-header">
        <h4><strong><?php echo __('What Conditions Settings?', VCFF_NS); ?></strong></h4><a href="" target="vcff_hint" class="help-lnk"><span class="dashicons dashicons-editor-help"></span> Help</a>
    </div>
    <div class="action-group-contents">
        <div class="row">
            <div class="col-sm-4">
                <p>Instructions</p>
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <select name="event_action[triggers][ch_result][marked_result]" class="select-trigger form-control">
                        <option value="all_correct" <?php if ($this->_Get_Marked_Result() == 'all_correct'): ?>selected="selected"<?php endif; ?>>When all questions are marked correct</option>
                        <option value="all_positive" <?php if ($this->_Get_Marked_Result() == 'all_positive'): ?>selected="selected"<?php endif; ?>>When all questions are marked correct and/or pending marks</option>
                        <option value="some_unsuccessful" <?php if ($this->_Get_Marked_Result() == 'some_unsuccessful'): ?>selected="selected"<?php endif; ?>>When some questions are marked incorrect</option>
                    </select>
                    <?php if ($this->Is_Update() && isset($validation_errors['marked_result'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <div class="alert-text"><?php echo __('Please select a form marked status', VCFF_NS); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>