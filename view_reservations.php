<?php
include 'templates/header.php';
include 'functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}


$user_id = $_SESSION['user_id'];


$query = "SELECT rooms.name AS room_name, reservations.start_time, reservations.end_time 
          FROM reservations 
          JOIN rooms ON reservations.room_id = rooms.id 
          WHERE reservations.user_id = ? 
          ORDER BY reservations.start_time";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result === false) {
        die("Erro na execução da consulta: " . $conn->error);
    }
} else {
    die("Erro na preparação da consulta: " . $conn->error);
}



?>

<div class="container mt-5">
    <h2>Minhas Reservas</h2>
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sala</th>
                    <th>Início</th>
                    <th>Término</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['room_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['start_time']); ?></td>
                        <td><?php echo htmlspecialchars($row['end_time']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Você não possui reservas.</p>
    <?php endif; ?>
</div>

<?php include 'templates/footer.php'; ?>
