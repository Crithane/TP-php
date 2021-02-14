<?php
include('config/db_connect.php');

$sql = 'SELECT amount, reference, timestamp, id FROM payments ORDER BY id';

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
<div class="container">
    <h5 class="center m3">Payment History</h5>
    <div class="row">
        <?php foreach ($payments as $payment) : ?>
        <div class="s12 m3">
            <div class="card z-depth-0">
                <div class="card-content center">
                    <p>Id: <?php echo htmlspecialchars($payment['id']); ?></p>
                    <p>Amount: <?php echo htmlspecialchars($payment['amount']); ?></p>
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