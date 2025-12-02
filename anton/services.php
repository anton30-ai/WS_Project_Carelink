<?php
require_once 'header.php';
include 'nav.php';
?>

<div class="container my-5">
    <h1 class="mb-4">Our Services</h1>
    <div class="row g-4">
        <div class="col-md-6">
            <a href="education.php" class="text-decoration-none service-card-link">
                <div class="card h-100">
                    <div class="card-body d-flex gap-3 align-items-start">
                        <img src="assets/img/icon-education.svg" alt="education" width="48" height="48">
                        <div>
                            <h5>Education Programs</h5>
                            <p>Community-based classes, scholarships, and mentoring to help children and adults access education.</p>
                            <p class="small text-muted mb-0">Click to learn more about our education initiatives.</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="health.php" class="text-decoration-none service-card-link">
                <div class="card h-100">
                    <div class="card-body d-flex gap-3 align-items-start">
                        <img src="assets/img/icon-health.svg" alt="health" width="48" height="48">
                        <div>
                            <h5>Health &amp; Welfare</h5>
                            <p>Health screenings, basic medical support, and welfare services coordinated with local clinics.</p>
                            <p class="small text-muted mb-0">Click to explore how we support community health and welfare.</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="livelihood.php" class="text-decoration-none service-card-link">
                <div class="card h-100">
                    <div class="card-body d-flex gap-3 align-items-start">
                        <img src="assets/img/icon-volunteer.svg" alt="volunteer" width="48" height="48">
                        <div>
                            <h5>Livelihood Training</h5>
                            <p>Skills training and small-business support to help families build sustainable income sources.</p>
                            <p class="small text-muted mb-0">Click to see specific trainings and livelihood programs.</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="emergency.php" class="text-decoration-none service-card-link">
                <div class="card h-100">
                    <div class="card-body d-flex gap-3 align-items-start">
                        <img src="assets/img/icon-donate.svg" alt="donate" width="48" height="48">
                        <div>
                            <h5>Emergency Assistance</h5>
                            <p>Rapid response and relief in times of crisis, focusing on shelter, food, and medical aid.</p>
                            <p class="small text-muted mb-0">Click to read how we respond when families face crisis.</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
