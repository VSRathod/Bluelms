<div class="accordion">
    <?php foreach ($controller->getFilters() as $filterID => $filter) : ?>
    <div class="accordion-item">
        <button type="button" data-toggle="collapse" data-target="#<?= $filterID ?>Filter"
            class="accordion-btn btn btn-link <?= $filter['isOpen'] ? '' : 'collapsed' ?>">
            <span><?= $filter['title'] ?></span>
            <i class="fa fa-chevron-up"></i>
        </button>
        <div id="<?= $filterID ?>Filter" class="collapse <?= $filter['isOpen'] ? 'show' : '' ?>">
            <div class="accordion-content">
                <?php foreach ($filter['options'] as $optionIndex => $option) : ?>
                <div class="custom-control custom-<?= $filter['type'] ?>">
                    <input type="<?= $filter['type'] ?>" id="<?= $filterID . '-' . $optionIndex ?>"
                        name="<?= $filter['name'] . ($filter['type'] == 'checkbox' ? '[]' : '') ?>"
                        class="custom-control-input input-catalogue-filter" value="<?= $option['value'] ?>"
                        <?= $option['isSelected'] ? 'checked' : '' ?>>
                    <label for="<?= $filterID . '-' . $optionIndex ?>" class="custom-control-label">
                        <?= $option['label'] ?>
                    </label>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>