<?php
session_start();
$checkoutId = $_SESSION['checkout_id'];

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
?>



<!DOCTYPE html>
<html lang="en">
<?php
include('template/header.php');
?>

<div class="container grey-text">
<h5 class="center">Payment Result</h5>
    <p>Result Code : <?php echo htmlspecialchars($resultCode) ?>
    <p>Result : <?php echo htmlspecialchars($resultDescription); ?>
</div>
<?php
include('template/footer.php')
?>

</html>