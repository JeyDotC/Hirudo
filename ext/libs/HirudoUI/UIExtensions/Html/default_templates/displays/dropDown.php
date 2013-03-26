<div class="field field-type-text">
    <div class="field-label">
        <?php echo $propertyData->getDisplayName() ?>:&nbsp;
    </div>
    <div class="field-items">
        <?php if ($uiHint->allowMultiple): ?>
            <ul>
                <?php foreach ($uiHint->values() as $value => $text): ?>
                    <li>
                        <?php echo $text ?>
                    </li>
                <?php endforeach ?>
            </ul>
        <?php else: ?>
            <div class="field-item odd">
                <?php echo $uiHint[$propertyData->getValue()] ?>
            </div>
        <?php endif ?>
    </div>
</div>