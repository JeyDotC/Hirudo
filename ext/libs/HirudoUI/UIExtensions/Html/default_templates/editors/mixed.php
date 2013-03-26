<div class="form-item">
    <label>
        <?php echo $propertyData->getDisplayName() ?>:
    </label>
    <input type="text" 
           name="<?php echo $propertyData->getName() ?>" 
           value="<?php echo $propertyData->getValue() ?>" 
           class="form-text"/>
</div>