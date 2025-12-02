<?php
require_once 'header.php';
require_once 'db.php';
include 'nav.php';

$error = '';
$success = '';
$fieldErrors = [];
$values = [
    'fullname' => '',
    'email' => '',
    'phone' => '',
    'gender' => '',
    'birthdate' => '',
    'religion' => '',
    'address' => '',
    'occupation' => '',
    'emergency_contact' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    if (!isset($_POST['csrf_token']) || !validate_csrf($_POST['csrf_token'])) {
        $error = 'Invalid CSRF token.';
    } else {
        foreach ($values as $key => $_) {
            $values[$key] = trim($_POST[$key] ?? '');
        }
        $rawPassword = $_POST['password'] ?? '';

        if ($values['fullname'] === '') {
            $fieldErrors['fullname'] = 'Full name is required.';
        }
        if ($values['email'] === '') {
            $fieldErrors['email'] = 'Email is required.';
        } elseif (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
            $fieldErrors['email'] = 'Please enter a valid email address.';
        }
        if ($values['phone'] === '') {
            $fieldErrors['phone'] = 'Phone number is required.';
        }
        if ($values['gender'] === '') {
            $fieldErrors['gender'] = 'Please select a gender.';
        }
        if ($values['birthdate'] === '') {
            $fieldErrors['birthdate'] = 'Birthdate is required.';
        }
        if ($rawPassword === '') {
            $fieldErrors['password'] = 'Password is required.';
        } elseif (strlen($rawPassword) < 8) {
            $fieldErrors['password'] = 'Password must be at least 8 characters.';
        }

        if (!empty($fieldErrors)) {
            $error = 'Please correct the highlighted fields.';
        } else {
            $password = password_hash($rawPassword, PASSWORD_DEFAULT);

            $sql = "INSERT INTO applicants 
                (fullname, email, phone, gender, birthdate, religion, address, occupation, emergency_contact, password) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "ssssssssss", 
                $values['fullname'],
                $values['email'],
                $values['phone'],
                $values['gender'],
                $values['birthdate'],
                $values['religion'],
                $values['address'],
                $values['occupation'],
                $values['emergency_contact'],
                $password
            );

            try {
                if($stmt->execute()) {
                    $success = "Registration successful! You may now log in.";
                    foreach ($values as $key => $_) {
                        $values[$key] = '';
                    }
                }
            } catch (Exception $ex) {
                $error = 'Registration failed.';
            }
        }
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4"><img src="assets/img/icon-volunteer.svg" alt="volunteer" width="28" height="28" class="me-2 align-text-bottom">Register as a Volunteer</h2>

            <?php if($success) echo '<div class="alert alert-success">'.e($success).'</div>'; ?>
            <?php if($error) echo '<div class="alert alert-danger">'.e($error).'</div>'; ?>

            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name</label>
                                <input
                                    type="text"
                                    name="fullname"
                                    class="form-control<?php echo !empty($fieldErrors['fullname']) ? ' is-invalid' : ''; ?>"
                                    value="<?php echo e($values['fullname']); ?>"
                                    required
                                >
                                <?php if (!empty($fieldErrors['fullname'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($fieldErrors['fullname']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control<?php echo !empty($fieldErrors['email']) ? ' is-invalid' : ''; ?>"
                                    value="<?php echo e($values['email']); ?>"
                                    required
                                >
                                <?php if (!empty($fieldErrors['email'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($fieldErrors['email']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control<?php echo !empty($fieldErrors['phone']) ? ' is-invalid' : ''; ?>"
                                    value="<?php echo e($values['phone']); ?>"
                                    required
                                >
                                <?php if (!empty($fieldErrors['phone'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($fieldErrors['phone']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gender</label>
                                <select
                                    name="gender"
                                    class="form-select<?php echo !empty($fieldErrors['gender']) ? ' is-invalid' : ''; ?>"
                                    required
                                >
                                    <option value="">Select</option>
                                    <option <?php echo $values['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                                    <option <?php echo $values['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                                    <option <?php echo $values['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                                </select>
                                <?php if (!empty($fieldErrors['gender'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($fieldErrors['gender']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Birthdate</label>
                                <input
                                    type="date"
                                    name="birthdate"
                                    class="form-control<?php echo !empty($fieldErrors['birthdate']) ? ' is-invalid' : ''; ?>"
                                    value="<?php echo e($values['birthdate']); ?>"
                                    required
                                >
                                <?php if (!empty($fieldErrors['birthdate'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($fieldErrors['birthdate']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Religion</label>
                                <input
                                    type="text"
                                    name="religion"
                                    class="form-control"
                                    value="<?php echo e($values['religion']); ?>"
                                >
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input
                                type="text"
                                name="address"
                                class="form-control"
                                value="<?php echo e($values['address']); ?>"
                            >
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Occupation</label>
                                <input
                                    type="text"
                                    name="occupation"
                                    class="form-control"
                                    value="<?php echo e($values['occupation']); ?>"
                                >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Emergency Contact</label>
                                <input
                                    type="text"
                                    name="emergency_contact"
                                    class="form-control"
                                    value="<?php echo e($values['emergency_contact']); ?>"
                                >
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control<?php echo !empty($fieldErrors['password']) ? ' is-invalid' : ''; ?>"
                                required
                            >
                            <?php if (!empty($fieldErrors['password'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo e($fieldErrors['password']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit" name="register">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
