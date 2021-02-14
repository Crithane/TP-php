<?php
//pass variable through session
session_start();
$checkoutId = $_SESSION['checkout_id'];
$amount = $_SESSION['amount'];
$reference = $_SESSION['reference'];

//connect mysql
include('config/db_connect.php');
//result request with checkoutId
function request($checkoutId)
{
    $url = "https://test.oppwa.com/v1/checkouts/" . $checkoutId . "/payment";
    $url .= "?entityId=8ac7a4ca759cd78501759dd759ad02df";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization:Bearer OGFjN2E0Y2E3NTljZDc4NTAxNzU5ZGQ3NThhYjAyZGR8NTNybThiSmpxWQ=='
    ));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // this should be set to true in production
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $responseData = curl_exec($ch);
    if (curl_errno($ch)) {
        return curl_error($ch);
    }
    curl_close($ch);
    return $responseData;
}
$responseData = request($checkoutId);

$phpDecode = json_decode($responseData);
$resultCode = $phpDecode->result->code;
$resultDescription = $phpDecode->result->description;
$timeStamp = $phpDecode->timestamp;
$timeStampReplace = str_replace("+0000", "", $timeStamp);

if($resultCode == "000.100.110"){
    $amount_db = mysqli_real_escape_string($conn, $amount);
    $reference_db =  mysqli_real_escape_string($conn, $reference);
    $timestamp_db = mysqli_real_escape_string($conn, $timeStampReplace);
    $sql = "INSERT INTO payments(amount,reference,timestamp) VALUES('$amount_db','$reference_db','$timestamp_db')";
    
    if (!mysqli_query($conn, $sql)) {
        echo 'query error:' . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
include('template/header.php');
?>

<div class="container center">
    <h5 class="center">Payment Result</h5>
    <?php if($resultCode == "000.100.110"):?>
        <h6>Your payment has been successfully made.</h6>
    <?php endif; ?>
    <p>Result Code: <?php echo htmlspecialchars($resultCode) ?>
    <p>Result: <?php echo htmlspecialchars($resultDescription); ?>
</div>
<?php
include('template/footer.php')
?>

</html>