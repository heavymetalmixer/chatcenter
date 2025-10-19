<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagar con PlacetoPay Checkout</title>
</head>
<body>
    <h2>Pagar con PlacetoPay</h2>
    <form method="post" action="../src/placetopay_create.php">
        <label>Referencia:</label><br>
        <input type="text" name="reference" value="ORD-<?php echo time(); ?>"><br><br>

        <label>Descripción:</label><br>
        <input type="text" name="description" value="Pago de prueba"><br><br>

        <label>Monto total (COP):</label><br>
        <input type="number" step="0.01" name="amount" value="50000"><br><br>

        <button type="submit">Pagar ahora</button>
    </form>
</body>
</html>
