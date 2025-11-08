<?php require_once "create_order.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar con Wompi</title>
</head>
<body>

    <h2>Pagar un producto de ejemplo</h2>
    <button id="payBtn">Pagar $50.000 COP</button>

    <form action="https://checkout.wompi.co/p/" method="GET">
        <!-- OBLIGATORIOS -->
        <input type="hidden" name="public-key" value="<?php echo $transation->public_key ?>" />
        <input type="hidden" name="currency" value="<?php echo $transation->currency ?>" />
        <input type="hidden" name="amount-in-cents" value="<?php echo $transation->amount_in_cents ?>" />
        <input type="hidden" name="reference" value="<?php echo $transation->reference ?>" />
        <input type="hidden" name="signature:integrity" value="<?php echo $transation->signature ?>" />
        <!-- OPCIONALES -->
        <input type="hidden" name="redirect-url" value="<?php echo $transation->redirect_url ?>" />
        <input type="hidden" name="expiration-time" value="<?php echo $transation->expiration_time ?>" />
    </form>

</body>
</html>
