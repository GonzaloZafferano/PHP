<?php



/*

ALUMNO: ZAFFERANO GONZALO

Funciones de filtrado:
se deben realizar la funciones que reciban datos por parámetros y puedan
ejecutar la consulta para responder a los siguientes requerimientos

A. Obtener los detalles completos de todos los usuarios y poder ordenarlos
alfabéticamente de forma ascendente o descendente.
B. Obtener los detalles completos de todos los productos y poder ordenarlos
alfabéticamente de forma ascendente y descendente.
C. Obtener todas las compras filtradas entre dos cantidades.
D. Obtener la cantidad total de todos los productos vendidos entre dos fechas.
E. Mostrar los primeros “N” números de productos que se han enviado.
F. Mostrar los nombres del usuario y los nombres de los productos de cada venta.
G. Indicar el monto (cantidad * precio) por cada una de las ventas.
H. Obtener la cantidad total de un producto (ejemplo:1003) vendido por un usuario
(ejemplo: 104).
I. Obtener todos los números de los productos vendidos por algún usuario filtrado por
localidad (ejemplo: ‘Avellaneda’).
J. Obtener los datos completos de los usuarios filtrando por letras en su nombre o
apellido.

K. Mostrar las ventas entre dos fechas del año.

Nota: Organice el código de estas consultas de la manera que quiera , pero debe
tener las funcionalidades en clases y las llamadas desde un archivo .php
Respuestas:
las respuestas de GDB deberían tener una primer hoja con índice indicando el archivo y el
renglón que resuelve la consigna ej:
a :{ archivo :usuarios.php, renglón :66}
b:{ archivo :productos.php, renglón :666}
...etc.
*/

include_once("./productos.php");
include_once("./usuarios.php");
include_once("./ventas.php");

//A - archivo: usuarios.php, renglon 64
Usuarios::OrdenarUsuarios(true);
echo "<br>";
Usuarios::OrdenarUsuarios(false);

//B - archivo: productos.php, renglon 67
Productos::OrdenarProductos(true);
echo "<br>";
Productos::OrdenarProductos(false);

//C - archivo: ventas.php, renglon 63
Ventas::ObtenerComprasEntreDosCantidades(5,6);

//D - archivo: ventas.php, renglon 121
Ventas::MostrarCantidadProductosVendidosEntreDosFechas("2020/06/01", "2021/08/01");
echo "<br>";
Ventas::MostrarCantidadProductosVendidosEntreDosFechas("2020/06/01", "2022/12/01");

//E - archivo: ventas.php, renglon 94
Ventas::MostrarPrimerosProductosEnviados(1);
echo "<br>";
Ventas::MostrarPrimerosProductosEnviados(4);
echo "<br>";
Ventas::MostrarPrimerosProductosEnviados(6);
echo "<br>";

//F - archivo: ventas.php, renglon 139
Ventas::MostrarNombreUsuarioyProductoDeCadaVenta();

//G - archivo: ventas.php, renglon 166
Ventas::MostrarPrecioPorVenta();

//H - archivo: ventas.php, renglon 193
Ventas::MostrarCantidadDeProductoVendidoPorUsuario(104,1003);
Ventas::MostrarCantidadDeProductoVendidoPorUsuario(106,1003);

//I - archivo: ventas.php, renglon 210
Ventas::ObtenerProductosVendidosPorUsuarioDeLocalidad("avellaneda");
echo "<br>";
Ventas::ObtenerProductosVendidosPorUsuarioDeLocalidad("moreno");

//J - archivo: usuarios.php, renglon 97
Usuarios::TraerTodosLosUsuariosFiltrando("n");
echo "<br>";
Usuarios::TraerTodosLosUsuariosFiltrando("g");
echo "<br>";
Usuarios::TraerTodosLosUsuariosFiltrando("er");

//K - archivo: ventas.php, renglon 240
Ventas::MostrarVentasEntreDosFechas("2020/06/01", "2021/12/01");
echo "<br>";
Ventas::MostrarVentasEntreDosFechas("2015/06/01", "2020/06/01");
echo "<br>";
Ventas::MostrarVentasEntreDosFechas("2020/06/01", "2022/12/01");

?>