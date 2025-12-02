<?php
require_once 'header.php';
require_once 'db.php';
include 'nav.php';

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$id = $_SESSION['user_id'];
$error = '';
$success = '';

// Fetch user info
$sql = "SELECT * FROM applicants WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    if (!isset($_POST['csrf_token']) || !validate_csrf($_POST['csrf_token'])) {
        $error = 'Invalid CSRF token.';
    } else {
        $fullname = $_POST['fullname'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $birthdate = $_POST['birthdate'] ?? '';
        $religion = $_POST['religion'] ?? '';
        $address = $_POST['address'] ?? '';
        $occupation = $_POST['occupation'] ?? '';
        $emergency_contact = $_POST['emergency_contact'] ?? '';

        $sqlu = "UPDATE applicants SET fullname=?, phone=?, gender=?, birthdate=?, religion=?, address=?, occupation=?, emergency_contact=? WHERE id=?";
        $stmtu = $conn->prepare($sqlu);
        $stmtu->bind_param('ssssssssi', $fullname, $phone, $gender, $birthdate, $religion, $address, $occupation, $emergency_contact, $id);
        try {
            $stmtu->execute();
            $_SESSION['user_name'] = $fullname;
            $success = 'Profile updated.';
            // refresh user
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
        } catch (Exception $ex) {
            $error = 'Failed to update profile.';
        }
    }
}
?>

<div class="container my-5">
    <h2 class="mb-4">Your Profile</h2>

    <?php if($success): ?><div class="alert alert-success"><?php echo e($success); ?></div><?php endif; ?>
    <?php if($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-center p-3">
                <div class="card-body">
                    <div class="rounded-circle bg-white d-inline-flex align-items-center justify-content-center mb-3" style="width:120px;height:120px;box-shadow:0 6px 18px rgba(0,0,0,0.06);">
                        <span style="font-size:40px;color:var(--bs-primary);font-weight:600;"><?php echo strtoupper(substr($user['fullname'] ?? '',0,1)); ?></span>
                    </div>
                    <p class="mb-1 h5"><?php echo e($user['fullname']); ?></p>
                    <p class="small text-muted"><?php echo e($user['email']); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <form method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input class="form-control" name="fullname" value="<?php echo e($user['fullname']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input class="form-control" name="phone" value="<?php echo e($user['phone']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Birthdate</label>
                            <input type="date" name="birthdate" class="form-control" value="<?php echo e($user['birthdate']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Religion</label>
                            <input class="form-control" name="religion" value="<?php echo e($user['religion']); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email (cannot change)</label>
                            <input class="form-control" value="<?php echo e($user['email']); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Select</option>
                                <option value="Male" <?php if($user['gender']==='Male') echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if($user['gender']==='Female') echo 'selected'; ?>>Female</option>
                                <option value="Other" <?php if($user['gender']==='Other') echo 'selected'; ?>>Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input class="form-control" name="address" value="<?php echo e($user['address']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Occupation</label>
                            <input class="form-control" name="occupation" value="<?php echo e($user['occupation']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Emergency Contact</label>
                            <input class="form-control" name="emergency_contact" value="<?php echo e($user['emergency_contact']); ?>">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit" name="update_profile">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
