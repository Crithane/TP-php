<?php
include('config/db_connect.php');

$sql = 'SELECT amount, reference, timestamp, id FROM payments ORDER BY timestamp';

$result = mysqli_query($conn, $sql);

$payments = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<?php
include('template/header.php');
?>
<h4>order list</h4>
<div class="container">
    <div class="row">
        <?php foreach ($payments as $payment) : ?>
        <div class="col s6 md3">
            <div class="card">
                <div class="card-content center">
                    <p><?php echo htmlspecialchars($payment['id']); ?></p>
                    <h5>Amount: <?php echo htmlspecialchars($payment['amount']); ?></h5>
                    <p>Reference: <?php echo htmlspecialchars($payment['reference']); ?></p>
                    <p>Date and Time: <?php echo htmlspecialchars($payment['timestamp']); ?></p>
                </div>
            </div>
        </div>

        <?php endforeach; ?>
    </div>
</div>
<?php
include('template/footer.php')
?>

</html>