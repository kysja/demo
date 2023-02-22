<?php 
if (isset($viewGlobal['flash'])) : ?>
    <div class="container">
        <?php foreach ($viewGlobal['flash'] as $flash ) : ?>

            <div class="text-center alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
                <?= $flash['value'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.classList.add('d-none');
            }, 5000);
        });
    </script>
<?php endif; ?>
