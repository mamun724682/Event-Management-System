<?php ob_start(); ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include __DIR__ . '/../partials/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Event Create</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="/events" type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1">
                            Back to List
                        </a>
                    </div>
                </div>

                <form action="/events/store" method="POST">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <span class="text-danger"><?= $validationErrors['name'] ?? null ?></span>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                            <span class="text-danger"><?= $validationErrors['location'] ?? null ?></span>
                        </div>
                        <div class="col-md-6">
                            <label for="capacity" class="form-label">Capacity</label>
                            <input type="number" class="form-control" id="capacity" name="capacity" min="1" required>
                            <span class="text-danger"><?= $validationErrors['capacity'] ?? null ?></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                        <span class="text-danger"><?= $validationErrors['date'] ?? null ?></span>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        <span class="text-danger"><?= $validationErrors['description'] ?? null ?></span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </main>
        </div>
    </div>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../../layouts/app.php'; ?>