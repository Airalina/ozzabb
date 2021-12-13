# Ordenes de Compras

<a name='ordenes-de-compra'></a>

- [Ordenes de Compras](#ordenes-de-compras)
  - [Requerimiento del Negocio](#requerimiento-del-negocio)
  - [Planilla de Compras](#planilla-de-compras)
    - [Cómo se crean las Ordenes de Compra.](#cómo-se-crean-las-ordenes-de-compra)
  - [Datos de una Orden de Compra](#datos-de-una-orden-de-compra)
    - [Lista de Materiales de una Orden de Compra](#lista-de-materiales-de-una-orden-de-compra)

<a name='requerimiento-del-negocio'></a>

## Requerimiento del Negocio

Como empleado de la empresa a cargo de compras de materiales debo poder realizar las compras necesarias para cubrir las necesidades de producción tanto actuales como futuras.

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

<a name='planilla-de-compra'></a>

## Planilla de Compras

Las compras se realizan en general para tener suficiente cantidad de materiales para poder construir las instalaciones con fecha de entrega próxima y las Ordenes de Compra se confeccionan automáticamente por el sistema a partir de la confección de una Planilla de Compras.

La página de Planilla de Compras estará disponible desde como submenú del menú de Materiales.

En ella el usuario elije de la lista de Pedidos de Clientes que no están estado rechazado
los pedidos que para los que desea comprar materiales. Los pedidos elegidos se ven en una lista en la parte superior de la pantalla.

Para cada pedido de cliente en la lista se muestran los siguientes datos:

| Dato | Descripción  | 
| :-- |:--|
|Código de Pedido | Es el nro. de identificación interno del pedido del cliente. |
|Fecha de entrega | Es la fecha pactada de entrega para el pedido. |
|Cantidad total | Es la cantidad total de instalaciones que se pidieron. Si son hay más de 1 tipo de instalación, este campo suma todas las cantidades. |
|Estado | Muestra el estado actual de pedido. |
|Tiene Compras | True si el pedido figura en alguna otra planilla de compra. |
|Fecha de Inicio | Es la fecha en la que se empezó a fabricar el pedido. típicamente es la fecha en la que se lo mandó a producción junto con otros pedidos en una Orden de Trabajo. |

En la misma página, por debajo de la lista de pedidos, se muestra una grilla con los materiales que se van a utilizar en los pedidos seleccionados.

En la grilla se muestran los siguientes datos:

| Dato | Descripción  | Cómo se Calcula |
| :-- |:--| :--|
| Código de Material | Es el código interno del material. | De la entidad |
| Descripción | Es el campo descripción de la entidad material. | De la entidad |
| Stock | Es la cantidad que hay en depósitos para ese material. | Es la suma de las cantidades del material en los depósitos de tipo Almacén. |
| En tránsito | es la cantidad de unidades del material que están en órdenes de compra de materiales que están en estado No enviada. | Se suman las cantidades en las órdenes de compra. |
| Necesidad | Es la cantidad de unidades que se necesitan para construir todas las instalaciones que figuran en los pedidos de la lista de arriba. | Se suma la cantidad de productos por cada tipo de instalación y se la multiplica por la cantidad pedida. |
| Presentación | Es un selector cargado con las presentaciones que el proveedor seleccionado en la columna proveedor tiene asociada en la lista de precio. | Se toman de la lista de precio y se elige la más pequeña. |
| Proveedor | Es un selector que permite elegir el nombre del proveedor al que le vamos a comprar este material. | De la lista de precios. |
| Comprar | Es un campo editable numérico entero positivo que acepta el valor 0. El usuario anota aquí la cantidad que desea comprar de unidades del material. Debe poder escribirse un múltiplo de la columna Presentación. | Editable.|
|Precio de la compra | Es el valor en dólares de la compra | Precio de la presentación * (Cantidad en [Comprar] / [Presentación])

Debajo de la lista de Materiales se mostrará el SubTotal de la Compra, el campo % de IVA, que será editable por el usuario y el Precio Total en dólares que se calcula como Subtotal * (1 + (%Iva /100)).

La información de las Planilla de Compra se debe guardar en la DB y el sistema debe permitirme ver la lista de las planillas confeccionadas y poder ver la información contenida en ella.

En la página de una Planilla de Compras se debe poder ver la lista de Ordenes de compra generadas para la misma.


### Cómo se crean las Ordenes de Compra.

Al guardarse una planilla de compras, el sistema deberá generar las órdenes de compra individuales para cada proveedor mencionado en la lista de materiales de la planilla de compras. Se toman los registros de materiales que tengan valores correctos mayores a 0 en la columna comprar y se agrupan por proveedor. Para cada uno de esos grupos se registrará, de forma automática, una Orden de Compra con el detalle y cantidades correspondientes.

Luego de confeccionadas las órdenes de compra, el sistema procederá a enviar un correo electrónico a cada cliente con la información de la orden de compra. 

|Datos a incluir en el mail de Orden de Compra |
|:-- |
| Logo de Setecel |
| Nro. de Orden de Compra |
| Listado de Materiales |
| Texto con saludo |
| Firma con información de contacto de compras en Setecel |

Para el lista de Materiales de la orden se incluirán:

|Datos a incluir en el mail de Orden de Compra |
|:-- |




<a name='datos-de-una-orden-de-compra'></a>

## Datos de una Orden de Compra

Para cada orden de compra se registrarán los siguientes datos:

|Dato      | Descripción                              |
|:--       | :--     |
| Número de Orden | Automático formato "d(7)/YYYY" |
| Fecha de Compra | Fecha en formato "dd/MM/YYYY HH:SS". |
| ID de Proveedor | Identificador del Proveedor. |
| Precio Total  | Precio total en USD. |
| Estado | Enviada, No Enviada, No se pudo enviar. Nos dice si pudo ser enviada al proveedor por email u otros medios.|
| ID de Planilla de Compras | Es la planilla de compras desde la que se originó la orden de compra. |

Es posible confeccionar Ordenes de Compra que no están relacionadas a una Planilla de Compras. De esa manera se pueden hacer compras de materiales sin que se las asocie a un pedido de cliente.

Por lo tanto el sistema debe permitirme confeccionar una orden de compra llenando los datos a mano en una página específica que debe estar accesible desde el menú de materiales.

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







