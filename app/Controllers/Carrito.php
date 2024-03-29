<?php

namespace App\Controllers;

use App\Models\producto_model;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Files\File;

class Carrito extends BaseController
{

    public function viewProductosToPay(): string
    {
        $session = session();
        if ($session->has('carro'))
            return view('producto/listitemcartstopay', ['data' => $session->get('carro')]);
        else
            return view('producto/listitemcartstopay',  ['data' => null]);
    }


    public function viewProductosGrid(): string
    {
        $session = session();
        if ($session->has('carro'))
            return view('producto/listitemcarts', ['data' => $session->get('carro')]);
        else
            return view('producto/listitemcarts',  ['data' => null]);
    }


    public function addProducto($id)
    {
        if (!isset($id))         return $this->sendBadRequest('Parámetro ID requerido');
        if (!is_numeric($id))    return $this->sendBadRequest('Parámetro ID numérico');
        if ($id < 1)             return $this->sendBadRequest('Parámetro ID numérico mayor a 0');

        $model = new producto_model();
        $producto = $model->findById($id);
        if (!$producto) return $this->sendBadRequest("Producto a agregar No existe");

        $carro_session = array();
        $session = session();

        if (!$session->has('carro')) {
            $session->set('items', 0);
            $session->set('total_precio', '0.00');
        } else {
            $carro_session = $session->get('carro');
        }


        if (isset($carro_session[$id])) {
            $item = $carro_session[$id];
            $item['cantidad']++;
            $carro_session[$id] = $item;
        } else {
            $item = [
                "cantidad" => 1,
                "descripcion" => $producto[0]['descripcion'],
                "categoria" => $producto[0]['categoria'],
                "marca" => $producto[0]['marca'],
                "valor" => $producto[0]['pvp'],
                "foto" => $producto[0]['foto'],
            ];
            $carro_session[$id] = $item;
        }

        $session->set('items', $session->get('items') + 1);
        $session->set('total_precio', $session->get('total_precio') + $item['valor']);
        $session->set('carro', $carro_session);

        return $this->sendResponse(['message' => 'Producto agregado correctamente.']);
    }

    public function getItemsNotifications()
    {

        $session = session();
        $carro_session = array();
        if ($session->has('carro')) {
            $carro_session = $session->get('carro');
        }
        echo json_encode($carro_session);
    }

    public function getCountNotifications()
    {

        $session = session();
        $item = array();
        if ($session->has('carro')) {
            $item = [
                "cantidad" =>  $session->get('items'),
                "total_precio" => number_format($session->get('total_precio'), 2)
            ];
        } else {
            $item = [
                "cantidad" => 0,
                "total_precio" => 0
            ];
        }
        echo json_encode($item);
    }

    public function deleteProducts()
    {
        $session = session();
        $session->set('items', 0);
        $session->set('total_precio', '0.00');
        $session->remove('carro');
    }


    public function responsePayPhoneDone($authorizationCode, $transactionStatus): string
    {
        return view(
            'producto/listitemcartsdone',
            [
                'authorizationCode' => $authorizationCode,
                'transactionStatus' => $transactionStatus
            ]
        );
    }


    public function responsePayPhone()
    {

        $transaccion = $_GET["id"];
        $client = $_GET["clientTransactionId"];

        $data_array = array(
            "id" => $transaccion,
            "clientTxId" => $client
        );

        $data = json_encode($data_array);

        //Iniciar Llamada
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://pay.payphonetodoesposible.com/api/button/V2/Confirm");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer 7lzTn34_S-my5JSJaJbNNWDyCT61l1_dd_q-Vu5cTbIhzoEjGzXaoFORklZQSl-2lWjkDzn3C3Qp76X_RCkwtGvuWgyiyGmblF7DNqVXrCB0f-ER-QzH_atWB6aHkbdgwaVenLLu_Y5LmMlKAWetJYUOgUP03l0DcTlpVh1kja5fXErA1ajqBNBE5gDFhnY2KGs06xKxbtItv5oBNYUeb4ZAXv9MaSibdd--6TP05K9g0icAEJOiyZ68f_xAbYxI4oQGps_ly8VXAqUnvlJq0q-faV2gMAs-BwCirVfslIX3DaUlBjkz67DjZNYmCj4psdPK3A", "Content-Type:application/json"
            ),
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);

        if ($result !== false && curl_errno($curl) == 0) {
            $jsonObject = json_decode($result);
            if (json_last_error() == JSON_ERROR_NONE) {
                $this->deleteProducts();
                return view(
                    'producto/listitemcartsdone',
                    [
                        'authorizationCode' => $jsonObject->authorizationCode,
                        'transactionStatus' => $jsonObject->transactionStatus
                    ]
                );
            } else {
                return view('producto/listitemcartstopay', [
                    'data' => $session->get('carro'),
                    'error_msg' => "Error al decodificar JSON: " . json_last_error_msg()
                ]);
            }
        } else {
            return view('producto/listitemcartstopay', [
                'data' => $session->get('carro'),
                'error_msg' => "Error al ejecutar cURL: " . curl_error($curl)
            ]);
        }
    }
}
