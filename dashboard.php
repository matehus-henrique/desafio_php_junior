<?php
include 'templates/header.php';
include 'functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}
?>

<h2 class="mt-5">Dashboard</h2>
<p>Bem-vindo, <?php echo $_SESSION['user_name']; ?>!</p>
<p>Use o menu acima para navegar pelo sistema.</p>

<?php include 'templates/footer.php'; ?>
