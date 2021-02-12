<?php


$amount = $reference = "";

$errors = array('amount' => '', 'reference' => '');

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

    function request($amount)
    {
        $url = "https://test.oppwa.com/v1/checkouts";
        $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
            "&amount=" . $amount .
            "&currency=GBP" .
            "&paymentType=DB";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='
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

    $responseData = request($amount);

    if (array_filter($errors)) {
        echo 'error';
    } else {
        //echo 'no error' . $responseData . '</br>';
        $phpDecode = json_decode($responseData);
        //print_r($phpDecode);
        echo $phpDecode->result->description;
        //print_r($phpDecode['buildNumber']);
        //print_r($phpDecode['timestamp']);
        // stdClass Object ( 
        //    [result] => stdClass Object ( 
        //[code] => 000.200.100 
        //[description] => successfully created checkout 
        //)
        //[buildNumber] => bf26cbbf467aefb66c1fc211bf3c36ae46335604@2021-02-12 03:42:28 +0000 
        //[timestamp] => 2021-02-12 22:03:37+0000 
        //[ndc] => 8D5728E3AA1CB62672579E64C12175BA.uat01-vm-tx04 
        //[id] => 8D5728E3AA1CB62672579E64C12175BA.uat01-vm-tx04 )

    }
}



?>


<!DOCTYPE html>
<html lang="en">
<?php
include('template/header.php');
?>

<section class="container grey-text">
    <h4 class="center">Add a wish list that you want someone to pay!</h4>
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
</section>

<?php

include('template/footer.php')
?>

</html>