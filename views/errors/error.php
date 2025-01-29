<?php ob_start(); ?>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="text-center">
                <h1 class="display-1 text-danger fw-bold"><?= $code ?></h1>
                <h2 class="mb-3"><?= $message ?></h2>
                <pre class="text-muted">
                    <?= $trace ?>
                </pre>
                <a href="/" class="btn btn-primary mt-3">Go Back Home</a>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../layouts/app.php'; ?>
