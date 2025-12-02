<?php
require_once 'header.php';
require_once 'db.php';

$error = '';
$email = '';
$password = '';
$fieldErrors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    if (!isset($_POST['csrf_token']) || !validate_csrf($_POST['csrf_token'])) {
        $error = 'Invalid CSRF token.';
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '') {
            $fieldErrors['email'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $fieldErrors['email'] = 'Please enter a valid email address.';
        }

        if ($password === '') {
            $fieldErrors['password'] = 'Password is required.';
        }

        if (empty($fieldErrors)) {
            $sql = "SELECT * FROM applicants WHERE email=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                // store user name for quick access in nav
                $_SESSION['user_name'] = $user['fullname'];
                $_SESSION['welcome_message'] = 'Welcome back, ' . $user['fullname'] . '!';
                header("Location: dashboard.php");
                exit;
            } else {
                $error = 'Invalid email or password.';
                $fieldErrors['email'] = "We couldn't find an account with that email and password.";
                $fieldErrors['password'] = 'Please double-check your password and try again.';
            }
        } else {
            $error = 'Please correct the highlighted fields.';
        }
    }
}
?>

        <?php include 'nav.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4"><i class="bi bi-box-arrow-in-right me-2"></i>Login</h2>
            <?php if($error): ?>
                <div class="alert alert-danger"><?php echo e($error); ?></div>
            <?php endif; ?>
            <div class="card">
              <div class="card-body">
                <form method="POST" action="">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control<?php echo !empty($fieldErrors['email']) ? ' is-invalid' : ''; ?>"
                            value="<?php echo e($email); ?>"
                            required
                        >
                        <?php if (!empty($fieldErrors['email'])): ?>
                            <div class="invalid-feedback">
                                <?php echo e($fieldErrors['email']); ?>
                            </div>
                        <?php endif; ?>
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
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="register.php" class="small">Create account</a>
                        <button class="btn btn-primary" type="submit" name="login">Login</button>
                    </div>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
