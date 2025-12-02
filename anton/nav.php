<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$userName = '';
if (!empty($_SESSION['user_id'])) {
  // attempt to fetch latest fullname (db available)
  if (!isset($conn)) {
    @include_once 'db.php';
  }
  if (isset($conn)) {
    $sql = "SELECT fullname FROM applicants WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $userName = $row['fullname'] ?? ($_SESSION['user_name'] ?? '');
  } else {
    $userName = $_SESSION['user_name'] ?? '';
  }
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">CareLink</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        <?php if(empty($_SESSION['user_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="notification-bell" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-bell"></i>
              <span class="notification-badge<?php echo !empty($_SESSION['welcome_message']) ? ' show' : ''; ?>"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notification-bell" id="notification-dropdown">
              <li><a class="dropdown-item" href="#">No new notifications</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo htmlspecialchars($userName ?: ($_SESSION['user_name'] ?? 'Profile'), ENT_QUOTES, 'UTF-8'); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
              <li><a class="dropdown-item" href="profile.php">Profile</a></li>
              <li><a class="dropdown-item" href="messages.php">Messages</a></li>
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
