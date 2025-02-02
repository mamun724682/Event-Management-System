<?php ob_start(); ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include __DIR__ . '/../partials/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Events</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="/events/create" type="button"
                                class="btn btn-sm btn-primary d-flex align-items-center gap-1">
                            <svg class="bi">
                                <use xlink:href="#plus-circle"/>
                            </svg>
                            Create
                        </a>
                    </div>
                </div>

                <?php include __DIR__ . '/../../layouts/partials/flashMessage.php'; ?>

                <div x-data="eventList" x-init="fetchEvents()">
                    <!-- Filter Section -->
                    <div class="row g-2 align-items-center mb-3">
                        <div class="col-md-6">
                            <input type="text" x-model="name" @input.debounce.500ms="fetchEvents" class="form-control" id="name" placeholder="Search by name">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="sortBy" x-model="sortBy" @change="fetchEvents">
                                <option value="id">Sort by ID</option>
                                <option value="name">Sort by Name</option>
                                <option value="date">Sort by Date</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="sortOrder" x-model="sortOrder" @change="fetchEvents">
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                        </div>
                    </div>

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

                            <template x-for="(event, index) in events" :key="event.id">
                                <tr>
                                    <td x-text="(page-1)*perPage+(index+1)"></td>
                                    <td x-text="event.name"></td>
                                    <td x-text="event.location"></td>
                                    <td>
                                        Capacity: <span x-text="event.capacity"></span><br>
                                        Attendees: <span x-text="event.total_attendees"></span>
                                    </td>
                                    <td x-text="event.date"></td>
                                    <td x-text="event.created_at"></td>
                                    <td>
                                        <a x-bind:href="'/events/'+event.slug+'/register'" target="_blank">View</a>
                                        <a x-bind:href="'/events/'+event.id+'/export'">Export</a>
                                        <a x-bind:href="'/events/'+event.id+'/edit'">Edit</a>
                                        <a x-bind:href="'/events/'+event.id+'/delete'" onclick="return confirm('Are you sure to delete?')">Delete</a>
                                    </td>
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
                        Alpine.data('eventList', () => ({
                            events: [],
                            page: 1,
                            perPage: 10,
                            total: 0,
                            sortBy: 'id',
                            sortOrder: 'ASC',
                            name: '',

                            get totalPages() {
                                return Math.ceil(this.total / this.perPage);
                            },

                            async fetchEvents() {
                                const url = `/api/events?page=${this.page}&perPage=${this.perPage}&sortBy=${this.sortBy}&sortOrder=${this.sortOrder}&name=${this.name}`;
                                const response = await fetch(url);
                                const data = await response.json();

                                this.events = data.data.data;
                                this.total = data.data.total;
                            },

                            nextPage() {
                                if (this.page < this.totalPages) {
                                    this.page++;
                                    this.fetchEvents();
                                }
                            },

                            prevPage() {
                                if (this.page > 1) {
                                    this.page--;
                                    this.fetchEvents();
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