<?php

    foreach ($data as $key => $row) {
        echo '<a class="dropdown-item d-flex align-items-center" href="#">
            <div class="mr-3">
                <div class="icon-circle bg-primary">
                    <img src="assets/imgs/productos/' . $row['foto'] . '" alt="" class="img-thumbnail" >
                </div>
            </div>
            <div>
                <div class="small text-gray-500">' . $row['categoria'] . '</div>
                <span class="font-weight-bold">' . $row['cantidad'] . " - " . $row['descripcion'] . '</span><br>
                <span class="small text-gray-500">Total: ' . number_format($row['valor'] * $row['cantidad'], 2) . '</span>
            </div>
        </a>';
    }

    echo '<h7 style="background:white; color:black" class="dropdown-header">
    
    <i style="color:green" class="fa fa-credit-card fa-2x" aria-hidden="true">
    </i> <a href="javascript:ajaxLoadContentPanel(\'carrito/vista_listaitemstopay\', \'Lista de Productos\')">Pagar</a>
    </h7>';


?>

