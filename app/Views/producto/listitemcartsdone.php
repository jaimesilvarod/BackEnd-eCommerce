<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
        .card {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            width: 40%;
            border-radius: 5px;
            padding: 16px;
            background-color: #f1f1f1;
            margin: auto;
            text-align: center;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }

        .card-icon {
            font-size: 48px;
            color: #4CAF50;
        }
    </style>

<div class="card">
<i class="fas fa-check-circle card-icon"></i>
  <h1>Pago Aprobado</h1> 
  <p><?php
    echo "Transacción ".$transactionStatus." Código: ".$authorizationCode;
  ?></p>
  <p>Tu pago ha sido procesado exitosamente. ¡Gracias por tu compra!</p> 
  <p><a href="/tienda/panel">Regresar a la Tienda</a></p>
</div>







        



