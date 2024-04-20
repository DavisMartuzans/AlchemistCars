<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <a class="navbar-brand" href="index.php">AlchemistCars</a>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contacts</a>
      </li>
      <?php
      if (isset($_SESSION['username'])) {
          if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'user') {
              echo '<li class="nav-item"> <a class="nav-link" href="parts.php">Parts</a></li>';
              echo '<li class="nav-item"><a class="nav-link" href="sellcars.php">Sell Your Car</a></li>';
              echo '<li class="nav-item"><a class="nav-link" href="leasing.php">Leasing</a></li>';
          }
      }
      ?>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Account
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <?php
          if (isset($_SESSION['username'])) {
              // For administrators
              if ($_SESSION['role'] === 'admin') {
                  echo '<li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Admin Dashboard</a></li>';
              }
              // For users
              echo '<li class="nav-item"><a class="nav-link" href="account.php">Account Settings</a></li>';
              echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
          } else {
              // For guests
              echo '<li class="nav-item"><a class="nav-link" href="signin.php">Sign In</a></li>';
          }
          ?>
        </ul>
      </li>
    </ul>
  </div>
</nav>
