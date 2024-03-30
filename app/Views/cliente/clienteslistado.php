<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Clientes</title>
    <!-- Agrega aquí tus enlaces a hojas de estilo CSS si los tienes -->
</head>
<body>
    <h1>Listado de Clientes</h1>
    <a href="/clientes/agregar" class="btn btn-primary">Agregar Cliente</a>
    <table border="1">
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Correo Electrónico</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí puedes utilizar un bucle para mostrar cada cliente -->
            <tr>
                <td>Juan</td>
                <td>Pérez</td>
                <td>juan@example.com</td>
                <td>1234567890</td>
                <td>
                    <a href="/clientes/editar/1">Editar</a>
                    <a href="/clientes/eliminar/1">Eliminar</a>
                </td>
            </tr>
            <!-- Fin del bucle -->
        </tbody>
    </table>
</body>
</html>
