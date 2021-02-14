<?php
//set variable
$amount = $reference = $checkoutId =  "";
//set function
function request($amount)
{
    $url = "https://test.oppwa.com/v1/checkouts";
    $data = "entityId=8ac7a4ca759cd78501759dd759ad02df" .
        "&amount=" . $amount .
        "&currency=GBP" .
        "&paymentType=DB" .
        "&merchantTransactionId=test1234";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization:Bearer OGFjN2E0Y2E3NTljZDc4NTAxNzU5ZGQ3NThhYjAyZGR8NTNybThiSmpxWQ=='
    ));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $responseData = curl_exec($ch);
    if (curl_errno($ch)) {
        return curl_error($ch);
    }
    curl_close($ch);
    return $responseData;
}
//error
$errors = array('amount' => '', 'reference' => '');

//if submit
if (isset($_POST['submit'])) {
    if (empty($_POST['amount'])) {
        $errors['amount'] = 'An amount is required';
    } else {
        $amount = $_POST['amount'];
    }
    if (empty($_POST['reference'])) {
        $errors['reference'] = 'A reference is required';
    } else {
        $reference = $_POST['reference'];
    }

    if (array_filter($errors)) {
        echo 'There is error in the form';
    } else {
        $responseData = request($amount);
        $phpDecode = json_decode($responseData);
        $checkoutId = $phpDecode->id;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<?php
include('template/header.php');
?>

<section class="container grey-text">
    <h4 class="center">Buy an item that you want 🤗!</h4>
    <form class="white" action="index.php" method="POST">
        <label>Amount(GBP):</label>
        <input type="text" name="amount" value="<?php echo htmlspecialchars($amount) ?>">
        <div class="red-text">
            <?php
            echo $errors['amount'];
            ?>
        </div>
        <label>Reference:</label>
        <input type="text" name="reference" value="<?php echo htmlspecialchars($reference) ?>">
        <div class="red-text">
            <?php
            echo $errors['reference'];
            ?>
        </div>
        <div class="center">
            <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
        </div>
    </form>

    <?php
    //The form, only displayed on condition
    if (strlen($reference) > 0) : ?>
        <form action="result.php" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>
    <?php endif; ?>
    <?php
        session_start();
        $_SESSION['checkout_id'] = $checkoutId;
        $_SESSION['amount'] = $amount;
        $_SESSION['reference'] = $reference;
    ?>
    <script>
        var wpwlOptions = {style: "card"}
    </script>
    <script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId=<?php echo $checkoutId ?>"></script>
</section>


<?php
include('template/footer.php')
?>

</html>