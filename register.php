<?php
include 'config.php';
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $access_level = $_POST['access_level']; 

    if (registerUser($name, $email, $password, $access_level)) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Erro ao registrar usuário.";
    }
}

include 'templates/header.php';
?>

<h2>Registrar</h2>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form method="post" action="register.php">
    <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Senha</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="form-group">
        <label for="access_level">Nível de Acesso</label>
        <select class="form-control" id="access_level" name="access_level" required>
            <option value="user">Usuário</option>
            <option value="admin">Administrador</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Registrar</button>
</form>

<?php include 'templates/footer.php'; ?>
