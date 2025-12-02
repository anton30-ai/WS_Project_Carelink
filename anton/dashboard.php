<?php
require_once 'header.php';
require_once 'db.php';
include 'nav.php';

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user info
$id = $_SESSION['user_id'];
$sql = "SELECT * FROM applicants WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$welcomeMessage = $_SESSION['welcome_message'] ?? null;
if ($welcomeMessage !== null) {
    unset($_SESSION['welcome_message']);
}
?>
<div class="container my-5">
    <div class="row gx-4">
        <div class="col-md-4">
            <div class="card mb-3 shadow-sm">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-white d-inline-flex align-items-center justify-content-center mb-3" style="width:96px;height:96px;box-shadow:0 6px 18px rgba(0,0,0,0.06);">
                        <span style="font-size:28px;color:var(--bs-primary);font-weight:600;"><?php echo e(strtoupper(substr($user['fullname'],0,1))); ?></span>
                    </div>
                    <h5 class="card-title mb-0"><?php echo e($user['fullname']); ?></h5>
                    <p class="text-muted small mb-2"><?php echo e($user['email']); ?></p>
                    <a href="profile.php" class="btn btn-outline-primary btn-sm mt-2">Edit Profile</a>
                </div>
            </div>

            <div class="row gx-2">
                <div class="col-6">
                    <div class="card text-center">
                        <div class="card-body py-2">
                            <small class="text-muted">Phone</small>
                            <div class="fw-bold"><?php echo e($user['phone'] ?: '—'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card text-center">
                        <div class="card-body py-2">
                            <small class="text-muted">Registered</small>
                            <div class="fw-bold"><?php echo e(!empty($user['date_registered']) ? date('M j, Y', strtotime($user['date_registered'])) : '—'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <?php if (!empty($welcomeMessage)): ?>
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <?php echo e($welcomeMessage); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <h2 class="mb-3">Volunteer Details</h2>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <strong>Gender</strong>
                            <div class="text-muted"><?php echo e($user['gender'] ?: '—'); ?></div>
                        </div>
                        <div class="col-sm-6">
                            <strong>Birthdate</strong>
                            <div class="text-muted"><?php echo e($user['birthdate'] ?: '—'); ?></div>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <strong>Address</strong>
                        <div class="text-muted"><?php echo e($user['address'] ?: '—'); ?></div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-sm-6">
                            <strong>Occupation</strong>
                            <div class="text-muted"><?php echo e($user['occupation'] ?: '—'); ?></div>
                        </div>
                        <div class="col-sm-6">
                            <strong>Emergency Contact</strong>
                            <div class="text-muted"><?php echo e($user['emergency_contact'] ?: '—'); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="logout.php" class="btn btn-danger me-2">Logout</a>
                <a href="index.php" class="btn btn-secondary">Home</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
