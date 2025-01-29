<?php ob_start(); ?>
<div class="d-flex justify-content-center align-items-center vh-100">
    <main class="form-signin w-100 m-auto">
        <form>
            <div class="text-center">
                <img class="mb-4" src="/assets/images/logo.png" height="57">
                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
            </div>

            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
        </form>
    </main>
</div>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../layouts/app.php'; ?>
