<div class="form-item">
    <label>
        <?php echo $propertyData->getDisplayName() ?>:
    </label>
    <textarea type="text" 
           name="<?php echo $propertyData->getName() ?>" 
           class="form-text"><?php echo $propertyData->getValue() ?></textarea>
</div>