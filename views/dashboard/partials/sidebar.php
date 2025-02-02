<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu"
         aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel"><?= \App\Auth::user()['name'] ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"
                    aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 <?= \App\Requests\Request::url() == '/dashboard' ? 'text-dark' : '' ?>" aria-current="page" href="/dashboard">
                        <svg class="bi">
                            <use xlink:href="#house-fill"/>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 <?= str_contains(\App\Requests\Request::url(),'/events') ? 'text-dark' : '' ?>" href="/events">
                        <svg class="bi">
                            <use xlink:href="#puzzle"/>
                        </svg>
                        Events
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 <?= str_contains(\App\Requests\Request::url(),'/attendees') ? 'text-dark' : '' ?>" href="/attendees">
                        <svg class="bi">
                            <use xlink:href="#people"/>
                        </svg>
                        Attendees
                    </a>
                </li>
            </ul>

            <hr class="my-3">

            <ul class="nav flex-column" style="margin-bottom: 50vh;">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="/logout">
                        <svg class="bi">
                            <use xlink:href="#door-closed"/>
                        </svg>
                        Sign out
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>