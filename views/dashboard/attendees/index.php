<?php ob_start(); ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include __DIR__ . '/../partials/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Attendees</h1>
                </div>

                <div x-data="attendeeList" x-init="fetchAttendees()">
                    <!-- Filter Section -->
                    <div class="row g-2 align-items-center mb-3">
                        <div class="col-md-3">
                            <input type="text" x-model="name" @input.debounce.500ms="fetchAttendees"
                                   class="form-control" id="name" placeholder="Search by name">
                        </div>
                        <div class="col-md-3">
                            <input type="email" x-model="email" @input.debounce.500ms="fetchAttendees"
                                   class="form-control" id="email" placeholder="Search by email">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="event_id" x-model="event_id" @change="fetchAttendees">
                                <option value="" readonly>Select Event</option>
                                <?php foreach ($events as $event): ?>
                                    <option value="<?= $event['id'] ?>"><?= $event['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="sortBy" x-model="sortBy" @change="fetchAttendees">
                                <option value="id">Sort by ID</option>
                                <option value="name">Sort by Name</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="sortOrder" x-model="sortOrder" @change="fetchAttendees">
                                <option value="desc">Descending</option>
                                <option value="asc">Ascending</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive small">
                        <table class="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Created At</th>
                            </tr>
                            </thead>
                            <tbody>

                            <template x-for="(attendee, index) in attendees" :key="attendee.id">
                                <tr>
                                    <td x-text="(page-1)*perPage+(index+1)"></td>
                                    <td x-text="attendee.name"></td>
                                    <td x-text="attendee.email"></td>
                                    <td x-text="attendee.phone"></td>
                                    <td x-text="attendee.created_at"></td>
                                </tr>
                            </template>

                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Section -->
                    <div class="d-flex justify-content-between align-items-center">
                        <button @click="prevPage" :disabled="page === 1" class="btn btn-primary">Previous</button>
                        <div>
                            <span>Page <span x-text="page"></span> of <span x-text="totalPages"></span></span>.
                            <span>Total <span x-text="total"></span> items</span>
                        </div>
                        <button @click="nextPage" :disabled="page >= totalPages" class="btn btn-primary">Next</button>
                    </div>
                </div>

                <script>
                    document.addEventListener('alpine:init', () => {
                        Alpine.data('attendeeList', () => ({
                            attendees: [],
                            page: 1,
                            perPage: 10,
                            total: 0,
                            sortBy: 'id',
                            sortOrder: 'DESC',
                            name: '',
                            email: '',
                            event_id: '',

                            get totalPages() {
                                return Math.ceil(this.total / this.perPage);
                            },

                            async fetchAttendees() {
                                const url = `/api/attendees?page=${this.page}&perPage=${this.perPage}&sortBy=${this.sortBy}&sortOrder=${this.sortOrder}&name=${this.name}&event_id=${this.event_id}&email=${this.email}`;
                                const response = await fetch(url, {
                                    method: 'GET',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                    },
                                });
                                const data = await response.json();

                                this.attendees = data.data.data;
                                this.total = data.data.total;
                            },

                            nextPage() {
                                if (this.page < this.totalPages) {
                                    this.page++;
                                    this.fetchAttendees();
                                }
                            },

                            prevPage() {
                                if (this.page > 1) {
                                    this.page--;
                                    this.fetchAttendees();
                                }
                            }
                        }));
                    });
                </script>

            </main>
        </div>
    </div>

<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../../layouts/app.php'; ?>