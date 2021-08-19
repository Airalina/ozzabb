# Ordenes de Compras

<a name='ordenes-de-compra'></a>

- [Ordenes de Compras](#ordenes-de-compras)
  - [Requerimiento del Negocio](#requerimiento-del-negocio)
  - [Datos de una Orden de Compra](#datos-de-una-orden-de-compra)
    - [Lista de Materiales de una Orden de Compra](#lista-de-materiales-de-una-orden-de-compra)

<a name='requerimiento-del-negocio'></a>

## Requerimiento del Negocio

Como empleado dela empresa a cargo de compras de materiales debo poder realizar las compras necesarias para cubrir las necesidades de producción tanto actuales como futuras.

Para comprar materiales, en general, comenzaré seleccionando un conjunto de pedidos de clientes y el sistema debe mostrarme la lista de materiales involucrados en las instalaciones pedidas.

Para cada material debo poder ver la cantidad en stock, en tránsito y la necesaria para cumplir con los pedidos seleccionados.

Junto a la cantidad, para cada material, debo poder seleccionar un proveedor, una presentación y escribir la cantidad de unidades que deseo comprar.

La cantidad a comprar de cada material puede ser menor o mayor a la necesaria para completar los pedidos de 
clientes seleccionados.

La cantidad a comprar debe ser múltiplo de la presentación seleccionada para el material.

Para cada pedido el sistema debe poder recordar si ya se realizaron compras para ese pedido.

En una orden de compra se debe poder agregar un material que no esté relacionado a los pedidos seleccionados.

Al confirmar las compras se deben generar las órdenes de compra individuales por proveedor.

Para cada orden de compra se debe enviar un correo electrónico a la casilla de correo de ventas del proveedor.

El sistema guardará la lista de pedidos de clientes y la lista de materiales comprados como una planilla de compras. 

Se podrá ver las planillas de compras para cada pedido de clientes desde el formulario del pedido y se deberá poder ir a la página de compras.

Cada orden de compra tendrá un nro. de identificación que será correlativo para cada año. ej. 00001/2021

<a name='datos-de-una-orden-de-compra'></a>

## Datos de una Orden de Compra

Para cada orden de compra se registrarán los siguientes datos:

|Dato      | Descripción                              |
|:--       | :--     |
| Número de Orden | Automático formato "d(7)/YYYY" |
| Fecha    | Fecha en formato "dd/MM/YYYY HH:SS". |
| ID de Proveedor | Identificador del Proveedor. |
| Precio Total  | Cantidad de unidades compradas. |
| Estado | Enviada, No Enviada, No se pudo enviar. |
| ID de Planilla de Compras | Es la planilla de compras desde la que se originó la orden de compra. |

<a name='lista-de-materiales-de-una-orden-de-compra'></a>

### Lista de Materiales de una Orden de Compra

Para cada orden de compra se registrarán los materiales que se compraron en ella.

Los datos de los Materiales comprados que se deben registrar son los siguientes:

|Dato      | Descripción                              |
|:--       | :--     |
| Número de Orden | 
| ID de Material  | 
| Presentación    | 
| Cantidad de Unidades |
| Precio Presentación |
| Precio Total USD |



