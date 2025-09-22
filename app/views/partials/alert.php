<?php if (!empty($message)): ?>
    <div class="alert alert-<?= $this->escape($type ?? 'info') ?>">
        <?= $this->escape($message) ?>
    </div>
<?php endif; ?>
