<?php
require_once 'header.php';
include 'nav.php';

$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    if (!isset($_POST['csrf_token']) || !validate_csrf($_POST['csrf_token'])) {
        $error = 'Invalid CSRF token.';
    } elseif (empty($name) || empty($email) || empty($message)) {
        $error = 'Please fill all fields.';
    } else {
        // For now just show a success message. In a real app you'd store or email this.
        $success = 'Thank you — your message has been received.';
    }
}
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <h1 class="mb-4">Contact Us</h1>
            <?php if($success): ?><div class="alert alert-success"><?php echo e($success); ?></div><?php endif; ?>
            <?php if($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
            <form method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-control" rows="5" required></textarea>
                </div>
                <button class="btn btn-primary" type="submit">Send Message</button>
            </form>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body d-flex gap-3 align-items-start">
                    <img src="assets/img/icon-contact.svg" alt="contact" width="48" height="48">
                    <div>
                        <h5>Other ways to reach us</h5>
                        <p class="small text-muted mb-1">Email: email@carelink.example</p>
                        <p class="small text-muted mb-1">Phone: +1 (555) 123-4567</p>
                        <p class="small text-muted">Office hours: Mon - Fri, 9am - 5pm</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
