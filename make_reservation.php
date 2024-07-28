<?php
include 'templates/header.php';
include 'functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_id = $_POST['room_id'];
    $user_id = $_SESSION['user_id'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    if (makeReservation($room_id, $user_id, $start_time, $end_time)) {
        echo "<p class='alert alert-success'>Reserva feita com sucesso!</p>";
    } else {
        echo "<p class='alert alert-danger'>Erro ao fazer reserva. Tente novamente.</p>";
    }
}

$rooms = $conn->query("SELECT * FROM rooms");
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Fazer Reserva</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="make_reservation.php">
                        <div class="form-group">
                            <label for="room_id">Sala</label>
                            <select class="form-control" id="room_id" name="room_id" required>
                                <?php while ($room = $rooms->fetch_assoc()): ?>
                                    <option value="<?php echo $room['id']; ?>"><?php echo $room['name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="start_time">Início</label>
                            <input type="datetime-local" class="form-control" id="start_time" name="start_time" required>
                        </div>
                        <div class="form-group">
                            <label for="end_time">Término</label>
                            <input type="datetime-local" class="form-control" id="end_time" name="end_time" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Fazer Reserva</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
