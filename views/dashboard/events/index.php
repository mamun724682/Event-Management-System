<?php ob_start(); ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include __DIR__ . '/../partials/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Events</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                        </div>
                        <a href="/events/create" type="button"
                                class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                            <svg class="bi">
                                <use xlink:href="#plus-circle"/>
                            </svg>
                            Create
                        </a>
                    </div>
                </div>

                <?php include __DIR__ . '/../../layouts/partials/flashMessage.php'; ?>

                <div class="table-responsive small">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Location</th>
                            <th scope="col">Capacity</th>
                            <th scope="col">Date</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($events as $event): ?>
                            <tr>
                                <td><?= $event['id'] ?></td>
                                <td><?= htmlspecialchars($event['name']) ?></td>
                                <td><?= htmlspecialchars($event['location']) ?></td>
                                <td><?= $event['capacity'] ?></td>
                                <td><?= $event['date'] ?></td>
                                <td><?= $event['created_at'] ?></td>
                                <td>
                                    <a href="/events/<?= $event['id'] ?>/edit">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../../layouts/app.php'; ?>