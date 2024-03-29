<?php
echo '<table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Imagen</th>
                    <th>Categoría</th>
                    <th>Descripción</th>
                    <th>Cant</th>
                    <th>Valor Unitario</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>';
$total = 0;
foreach ($data as $key => $row) {
    echo '<tr>
                    <td><img src="assets/imgs/productos/' . $row['foto'] . '" style="width: 50px; height: auto;"></td>
                    <td>' . $row['categoria'] . '</td>
                    <td>' . $row['descripcion'] . '</td>
                    <td>' . $row['cantidad'] . '</td>
                    <td>' . number_format($row['valor'], 2) . '</td>
                    <td>' . number_format($row['valor'] * $row['cantidad'], 2) . '</td>
                </tr>';
    $total += $row['valor'] * $row['cantidad'];
}

echo '</tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-right">Total:</th>
                    <th>$ ' . number_format($total, 2) . '</th>
                </tr>
            </tfoot>
        </table>';
?>

<div id="pp-button"></div>

<script type="text/javascript">
    payphone.Button({

        token: "7lzTn34_S-my5JSJaJbNNWDyCT61l1_dd_q-Vu5cTbIhzoEjGzXaoFORklZQSl-2lWjkDzn3C3Qp76X_RCkwtGvuWgyiyGmblF7DNqVXrCB0f-ER-QzH_atWB6aHkbdgwaVenLLu_Y5LmMlKAWetJYUOgUP03l0DcTlpVh1kja5fXErA1ajqBNBE5gDFhnY2KGs06xKxbtItv5oBNYUeb4ZAXv9MaSibdd--6TP05K9g0icAEJOiyZ68f_xAbYxI4oQGps_ly8VXAqUnvlJq0q-faV2gMAs-BwCirVfslIX3DaUlBjkz67DjZNYmCj4psdPK3A",

        btnHorizontal: false,
        btnCard: true,

        createOrder: function(actions) {


            return actions.prepare({

                amount: 100,
                amountWithoutTax: 100,
                currency: "USD",
                clientTransactionId: "id<?= rand(1, 100) ?>",
                lang: "es"

            }).then(function(paramlog) {
                console.log(paramlog);
                return paramlog;
            }).catch(function(paramlog2) {
                console.log(paramlog2);
                return paramlog2;
            });
        },

        onComplete: function(model, actions) {}
    }).render("#pp-button");
</script>