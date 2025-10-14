<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagar con PayU</title>
</head>
<body>
    <h2>Pagar un producto de ejemplo (PayU Sandbox)</h2>

    <form action="../src/payu_payment.php" method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="name" value="Cliente de prueba"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="cliente@correo.com"><br><br>

        <label>Valor:</label><br>
        <input type="number" name="amount" value="50000"><br><br>

        <button type="submit">Pagar ahora</button>
    </form>
</body>
</html>
