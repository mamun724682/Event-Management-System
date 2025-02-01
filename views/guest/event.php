<?php ob_start(); ?>
    <main class="container">
        <?php
        $capacityRemain = $event['capacity'] - $event['total_attendees'];
        $isExpired = strtotime($event['date']) < time();
        ?>
        <div class="d-flex align-items-center p-3 my-3 text-white <?= ($capacityRemain and !$isExpired) ? 'bg-black' : 'bg-danger' ?> rounded shadow-sm">
            <img class="me-3" src="/assets/images/logo.png" height="38">
            <div>
                <h1 class="h6 mb-0 text-white lh-1"><?= $event['name'] ?></h1>
                <small>
                    Date: <?= $event['date'] ?> <?= $isExpired ? '(Expired)' : '' ?>
                    | Location: <?= $event['location'] ?>
                    | Capacity: <?= $capacityRemain ? "$capacityRemain left" : 'Unavailable' ?>
                </small>
            </div>
        </div>

        <?php if ($capacityRemain and !$isExpired): ?>
            <div class="my-3 p-3 bg-body rounded shadow-sm" x-data="eventForm()">
                <form @submit.prevent="submitForm">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" x-model="name">
                        <span class="text-danger" x-text="errors.name"></span>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" x-model="email">
                            <span class="text-danger" x-text="errors.email"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" x-model="phone">
                            <span class="text-danger" x-text="errors.phone"></span>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary" :disabled="loading">
                            <span x-show="loading" class="spinner-border spinner-border-sm"></span>
                            <span x-text="loading ? 'Submitting...' : 'Submit'"></span>
                        </button>
                    </div>
                </form>

                <div x-show="successMessage" class="alert alert-success mt-3" x-text="successMessage"></div>
            </div>
        <?php endif; ?>

        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <?= $event['description'] ?>
        </div>
    </main>

    <script>
        function eventForm() {
            return {
                name: '',
                email: '',
                phone: '',
                errors: {},
                loading: false,
                successMessage: '',

                validateForm() {
                    this.errors = {};

                    if (!this.name.trim()) {
                        this.errors.name = "Name is required";
                    }
                    if (!this.email.match(/^\S+@\S+\.\S+$/)) {
                        this.errors.email = "Valid email is required";
                    }
                    if (!this.phone.match(/^\+?[0-9()\-\s]+$/)) {
                        this.errors.phone = "Enter a valid phone number";
                    }

                    return Object.keys(this.errors).length === 0;
                },

                async submitForm() {
                    if (!this.validateForm()) return;

                    this.loading = true;
                    this.successMessage = '';

                    try {
                        const response = await fetch('/api/events/<?= $event['slug'] ?>/submit-register', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                // 'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                name: this.name,
                                email: this.email,
                                phone: this.phone
                            })
                        });

                        const result = await response.json();

                        if (response.ok) {
                            this.successMessage = "Form submitted successfully!";
                            this.name = this.email = this.phone = ''; // Reset fields
                        } else {
                            this.errors = result.errors || {};
                        }
                    } catch (error) {
                        console.error("Error submitting form:", error);
                    }

                    this.loading = false;
                }
            };
        }
    </script>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../layouts/app.php'; ?>