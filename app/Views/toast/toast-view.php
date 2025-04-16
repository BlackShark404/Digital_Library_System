<?php

use Core\Session;

$flashIcons = [
    'success' => 'fa-check-circle',
    'error'   => 'fa-xmark-circle',
    'warning' => 'fa-triangle-exclamation',
    'info'    => 'fa-circle-info'
];
?>

<!-- Create a single fixed container for all toasts -->
<div class="position-fixed bottom-0 end-0 p-3 toast-container d-flex flex-column-reverse" style="z-index: 1080">
    <?php foreach (['success', 'error', 'warning', 'info'] as $type): ?>
        <?php foreach (Session::flash($type) ?? [] as $message): ?>
            <div class="toast align-items-center text-bg-<?= $type ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <i class="fa-solid <?= $flashIcons[$type] ?>"></i>
                        <?= htmlspecialchars($message) ?>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>