# Stocks
Manejo Simple de Stock - PHP y MySQL

Empece escribiendo esto como un programa para manejar el stock de productos del hogar, de esta manera se puede hacer una gran compra mensual y manejar vencimentos y ubicacion de productos de una forma simple y ordenada.

Básicamente, por ahora, la aplicación informa desde el index.php cuando un producto está muy cercano a vencer y se debe consumir, permite manejar una tabla con el stock conformado por TIPO y NOMBRE del producto, FECHA DE VENCIMIENTO, UBICACIÓN del mismo, CANTIDAD que existe y UNIDAD en la que se expresa.

Por ahora no se deben registrar tipos de producto ni unidades, el usuario debe pensar que, si registra fideos de cualquier tipo (por ejemplo), todos deberian tener tipo "FIDEOS" para poder luego buscar por ese tipo. Además todos deberían contabilizarse en la misma unidad, ya sea gramos, porciones o cualquiera sea.

Requisitos mínimos actuales:
  PHP 5.5.29 (esto uso yo, no se si anteriores funcionan)
  MySQL Server 5.7.9
  Navegador con soporte para HTML 5 y CSS 3 (Safari 9.0.1 hace un buen trabajo)
