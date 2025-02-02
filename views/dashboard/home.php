<?php ob_start(); ?>
<?php include __DIR__ . '/partials/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include __DIR__ . '/partials/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Static Dashboard</h1>
                </div>

                <div class="row">
                    <!-- Widget 1 -->
                    <div class="col-md-6">
                        <div class="card dashboard-card p-3 border-0 shadow-sm">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Total Events</h6>
                                    <h4 class="fw-bold"><?= $totalEvents ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Widget 2 -->
                    <div class="col-md-6">
                        <div class="card dashboard-card p-3 border-0 shadow-sm">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-shopping-cart fa-2x text-success"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Total Attendees</h6>
                                    <h4 class="fw-bold"><?= $totalAttendees ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../layouts/app.php'; ?>