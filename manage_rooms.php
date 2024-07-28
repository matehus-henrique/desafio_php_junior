<?php
session_start(); 
include 'config.php';
include 'functions.php';
include 'templates/header.php'; 


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isAdmin()) {
    $name = $_POST['name'];
    $capacity = $_POST['capacity'];
    $location = $_POST['location'];

    if (createRoom($name, $capacity, $location)) {
        echo "<div class='alert alert-success'>Sala criada com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao criar a sala.</div>";
    }
}
?>

<h2 class="mt-5">Gerenciar Salas de Reunião</h2>
<form method="post" action="manage_rooms.php">
    <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="capacity">Capacidade</label>
        <input type="number" class="form-control" id="capacity" name="capacity" required>
    </div>
    <div class="form-group">
        <label for="location">Localização</label>
        <input type="text" class="form-control" id="location" name="location" required>
    </div>
    <button type="submit" class="btn btn-primary">Criar Sala</button>
</form>

<?php include 'templates/footer.php'; ?>
