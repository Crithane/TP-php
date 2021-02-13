<?php
session_start();
$checkoutId = $_SESSION['checkout_id'];
echo $checkoutId;

function request($checkoutId)
{
    $url = "https://test.oppwa.com/v1/checkouts/" . $checkoutId . "/payment";
    $url .= "?entityId=8ac7a4ca759cd78501759dd759ad02df";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='
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
?>



<!DOCTYPE html>
<html lang="en">
<?php
include('template/header.php');
?>
<p>
    <?php
    $phpDecode = json_decode($responseData);
    $resultCode = $phpDecode->result->code;
    $resultDescription = $phpDecode->result->description;

    echo $resultCode . '<br/>' . $resultDescription;
    ?>
</p>
<?php
include('template/footer.php')
?>

</html>