<?php ob_start(); ?>
<div class="d-flex justify-content-center align-items-center vh-100">
    <main class="form-signin w-100 m-auto">
        <form method="POST" action="/login">
            <div class="text-center">
                <img class="mb-4" src="/assets/images/logo.png" height="57">
                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
            </div>

            <?php $errors = \App\Requests\Request::errors() ?>
            <div class="form-floating mb-1">
                <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                <label for="email">Email address</label>
                <span class="text-danger"><?= $errors['email'] ?? null ?></span>
            </div>
            <div class="form-floating mb-1">
                <input type="password" name="password" class="form-control mb-0" id="password" placeholder="Password">
                <label for="password">Password</label>
                <span class="text-danger"><?= $errors['password'] ?? null ?></span>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
        </form>
    </main>
</div>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../layouts/app.php'; ?>
