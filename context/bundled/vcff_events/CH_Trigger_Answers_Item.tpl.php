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
                    <select name="event_action[triggers][ch_answers][answer_status]" class="select-trigger form-control">
                        <option value="all" <?php if ($this->_Get_Answer_Status() == 'all'): ?>selected="selected"<?php endif; ?>>When ALL required answers have been provided</option>
                        <option value="some" <?php if ($this->_Get_Answer_Status() == 'some'): ?>selected="selected"<?php endif; ?>>When SOME required answers have been provided</option>
                    </select>
                    <?php if ($this->Is_Update() && isset($validation_errors['answer_status'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <div class="alert-text"><?php echo __('Please select a answer status', VCFF_NS); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>