<div class="form-item">
    <label>
        <?php echo $propertyData->getDisplayName() ?>:
    </label>
    <?php $propertyValue = $propertyData->getValue() ?>
    <?php if ($uiHint->widget == "select"): ?>
        <select name="<?php echo $propertyData->getName() . ($uiHint->allowMultiple ? "[]" : "") ?>"
        <?php if ($uiHint->allowMultiple): ?>
                    multiple="multiple"
                <?php endif; ?>>
                    <?php foreach ($uiHint->values() as $value => $text): ?>
                <option value="<?php echo $value ?>"
                <?php
                if ($value == $propertyValue ||
                        (is_array($propertyValue) && in_array($value, $propertyValue))):
                    ?>
                            selected="selected"
                        <?php endif ?>>
                            <?php echo $text; ?>
                </option>
            <?php endforeach; ?>
        </select>
    <?php elseif ($uiHint->allowMultiple): ?>
        <?php foreach ($uiHint->values() as $value => $text): ?>
            <label value="<?php echo $value ?>">
                <input type="checkbox" 
                       name="<?php echo $propertyData->getName() ?>[]" 
                       value="<?php echo $value ?>"
                       <?php if (in_array($value, $propertyValue)): ?>
                           checked="checked"
                       <?php endif ?>
                       />
                       <?php echo $text; ?>
            </label>
        <?php endforeach; ?>
    <?php else: ?>
        <?php foreach ($uiHint->values() as $value => $text): ?>
            <label value="<?php echo $value ?>">
                <input type="radio" 
                       name="<?php echo $propertyData->getName() ?>" 
                       value="<?php echo $value ?>"
                       <?php if ($value == $propertyValue): ?>
                           checked="checked"
                       <?php endif ?>
                       />
                       <?php echo $text; ?>
            </label>
        <?php endforeach; ?>
    <?php endif; ?>
</div>