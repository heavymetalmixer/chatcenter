<?php require_once "create_order.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar con Wompi</title>
</head>
<body>

    <form>
        <script
            src="https://checkout.wompi.co/widget.js"
            data-render="button"
            data-public-key="<?php echo $transaction['public_key']; ?>"
            data-currency="<?php echo $transaction['currency']; ?>"
            data-amount-in-cents="<?php echo $transaction['amount_in_cents']; ?>"
            data-reference="<?php echo $transaction['reference']; ?>"
            data-signature:integrity="<?php echo $transaction['signature']; ?>"
            data-redirect-url="<?php echo $transaction['redirect_url']; ?>"
            data-expiration-time="<?php echo $transaction['expiration_time']; ?>"
        ></script>
    </form>

</body>
</html>
