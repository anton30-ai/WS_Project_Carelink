<?php require_once 'header.php'; include 'nav.php'; ?>

<header class="bg-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h1 class="display-5 fw-bold">CareLink — Community Care & Support</h1>
                <p class="lead">We connect volunteers, donors, and resources to build stronger, healthier communities through education and direct support programs.</p>
                <div class="mt-4">
                    <?php if(!empty($_SESSION['user_id'])): ?>
                        <a href="dashboard.php" class="btn btn-primary btn-lg me-2">Go to Dashboard</a>
                    <?php else: ?>
                        <a href="register.php" class="btn btn-primary btn-lg me-2">Join as Volunteer</a>
                        <a href="services.php" class="btn btn-accent-green">Explore Services</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-5 d-none d-md-block">
                <div class="text-center">
                    <img src="assets/img/hero-illustration.svg" alt="Community illustration" class="img-fluid shadow-sm" style="border-radius:12px;">
                </div>
            </div>
        </div>
    </div>
</header>

<main class="container my-5">
    <section class="row g-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Our Mission</h5>
                    <p class="card-text">Provide accessible care and education, uplift vulnerable families, and create lasting community programs.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Volunteer</h5>
                    <p class="card-text">Join our volunteers to deliver programs locally — education, health drives, and community outreach.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Donate</h5>
                    <p class="card-text">Support our work with donations that directly fund local initiatives and emergency relief.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
