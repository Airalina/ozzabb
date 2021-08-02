# Ordenes de Compras

<a name='ordenes-de-compra'></a>

  - [Ordenes de Compras](#ordenes-de-compras)
  - [Requerimiento del Negocio](#requerimiento-del-negocio)
   - [Datos de una Orden de Compra](#datos-de-una-orden-de-compra)
     - [Lista de Materiales de una Orden de Compra](#lista-de-materiales-de-una-orden-de-compra)

<a name='requerimiento-del-negocio'></a>

## Requerimiento del Negocio

<p style='text-style : justify;'>
Como empleado de la empresa, a cargo de compras de materiales, debo poder realizar las compras necesarias para cubrir las necesidades de producción tanto actuales como futuras.
</p>

Debo poder ver una lista de todas las compras realizadas en un periodo de tiempo que defina como parámetro y debo poder inspeccionar cada registro de compra para ver los datos del proveedor, cantidades y precios de los materiales comprados.

### Otros procesos relacionados
Las cantidades descriptas en las ordenes de compras se sumarán al stock de los materiales comprados cuando se realice el proceso de ingreso de materiales, que se describe en el documento "Ingreso de Materiales" y las ordenes tendrán un estado que me informa si han arribado esos materiales o no. Es posible dar como terminada una orden de compra aún si no han arribado todos los materiales comprados en un proceso llamado "Cierre manual de Ordenes de compras" que se describe en el documento "Cierre manual de ordenes de compras"

<a name='datos-de-una-orden-de-compra'></a>

## Datos de una Orden de Compra

Para cada orden de compra se registrarán los siguientes datos:

|Dato      | Descripción                              |
|:--       | :--     |
| Número de Orden | Automático formato "d(7)/YYYY" |
| Fecha    | Fecha en formato "dd/MM/YYYY HH:SS". |
| ID de Proveedor | Identificador del Proveedor. |
| Precio Total  | Precio total en USD. |
| Estado | Enviada, No Enviada, No se pudo enviar. |
| ID de Planilla de Compras | Es la planilla de compras desde la que se originó la orden de compra. |

Desde el formulario de orden de compra, debo poder acceder al detalle de los materiales comprados.

<a name='lista-de-materiales-de-una-orden-de-compra'></a>

### Lista de Materiales de una Orden de Compra

Para cada orden de compra se registrarán los materiales que se compraron en ella.

Los datos de los Materiales comprados que se deben registrar son los siguientes:

|Dato      | Descripción                              |
|:--       | :--     |
| Número de Orden | Orden a la que pertenecen.|
| Código de Material  | Código interno del Material.|
| Presentación    | La presentación comprada. |
| Cantidad de Unidades | Cuántas unidades se compraron. |
| Precio Presentación | El precio del proveedor para la presentación elegida. |
| Precio Total USD | Precio Presentación * (Cantidad de Unidades / Presentación) 






### Cómo se realizan las compras : Planilla de Compras

Dedo poder crear una planilla de compras la que comenzaré seleccionando un conjunto de pedidos de clientes y el sistema debe mostrarme la lista de materiales involucrados en las instalaciones pedidas, además puedo agregar un material no relacionado a los pedidos de clientes seleccionados a la planilla.
</p> 

Para cada uno de los materiales que están en la lista, el sistema me mostrará los siguientes datos:
|Dato | Descripción |
|:-- | :-- |
|Código | Código interno de material. |
|Descripción | Descripción del Material. |
|En Planta | Es la suma del stock del material en todos los depósitos registrados. |
|En Tránsito | Es la suma de todas las cantidades que se han comprado para este material, pero que todavía no han sido ingresadas. |
|Necesidad | Es la cantidad de unidades del material que se necesitan para los pedidos seleccionados. |
|Presentación | Es el valor del campo presentación del material según el proveedor seleccionado. |
|Proveedor | Es el proveedor al que le compramos por última vez el material. Debo poder seleccionar otro.| 
| Precio USD | Es el precio en USD provisto por el proveedor para el material y la presentación elegidos. |
| Precio ARS | El precio en pesos argentinos según la cotización del dólar vigente en el sistema. |
|Comprar | Me permite escribir la cantidad a comprar. Se carga inicialmente con el dato del campo necesidad. |
| Total USD | Es el precio en USD de la cantidad de unidades que estamos comprando. |
| Total ARS | Total USD en pesos argentinos según la cotización del dólar vigente en el sistema. |
  
- La cantidad a comprar de cada material puede ser menor o mayor a la necesaria para completar los pedidos de 
clientes seleccionados.

- La cantidad a comprar debe ser múltiplo de la presentación seleccionada para el material.

Al confirmar las compras se deben generar las órdenes de compra individuales por proveedor.
 
Para cada orden de compra el sistema enviará un correo electrónico a la casilla de correo de ventas del proveedor.
 
El sistema guardará la lista de pedidos de clientes y la lista de materiales comprados como una planilla de compras. 
 
Se podrá ver las planillas de compras para cada pedido de clientes desde el formulario del pedido y se deberá poder ir a la página de compras.
 
Cada orden de compra tendrá un nro. de identificación que será correlativo para cada año. ej. 00001/2021




