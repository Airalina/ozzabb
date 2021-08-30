<a name="ordenes-de-ingreso-de-materiales"></a>

- [Ordenes de Ingreso de Materiales](#ordenes-de-ingreso-de-materiales)
  - [Requerimiento del Negocio](#requerimiento-del-negocio)
  - [Lista de Ordenes de Ingreso](#lista-de-ordenes-de-ingreso)
  - [Datos en Orden de Ingreso de Materiales](#datos-en-orden-de-ingreso-de-materiales)
  - [Planilla de Recepción de Materiales R37-0](#planilla-de-recepción-de-materiales-r37-0)


# Ordenes de Ingreso de Materiales

<a name="requerimiento-del-negocio"></a>

## Requerimiento del Negocio

Como empleado de la empresa a cargo de registrar el ingreso de materiales, debo poder ver un listado de todas las órdenes de compra de materiales, destacando las que están en estado "En Tránsito" y "Parcialmente Recibidas".

Cuando un envío de materiales arriba a la empresa, el transporte presenta el remito de envío en el cuál figura el nro. de orden de compra al que el envío está relacionado y el manifiesto de la lista de materiales que han sido enviados y sus cantidades.

Luego de la inspección inicial del envío, el próximo paso es crear una orden de ingreso de materiales para la orden de compra que figura en el remito. Para ello seleccionaré la orden de compra relacionada y anotaré el nro. de remito y fecha.

En la orden de ingreso el sistema cargará la lista de materiales pedidos. La lista debe mostrar junto a los datos del material las columnas: Cantidad Pedida, Cantidad Enviada, Cantidad Recibida, Cantidad en el Remito, Diferencia y Sin Entrega.

El siguiente paso es anotar la cantidad de materiales que vinieron, en la columna "Cantidad Enviada", para cada material presente en la orden de compra. Puede darse el caso de que las cantidades no coincidan tanto porque vino más cantidad, como porque vino menos. Además puede que no venga en el envío alguno de los materiales pedido.

El sistema calculará el valor de la columna "Diferencia" a medida que vaya ingresando las cantidades enviadas. Se calcula con la fórmula Cantidad Enviada - Cantidad Pedida. Un valor negativo nos dice que aún se nos deben materiales, uno positivo nos dice que vino material de más.

Para una misma orden de compra podrían llegar más de un envío, para lo que tendremos diferentes números de remito y crearemos diferentes ordenes de ingreso.

La columna "Cantidad Recibida" mostrará la cantidad de materiales ya recibida en previas órdenes de ingreso para la misma orden de compra.

La columna "Sin Entrega" estará en cero hasta que se haga un cierre con diferencias para la orden de compra. Este proceso se realiza por un usuario con autorización específica y lo que nos dice es que los materiales restantes no se espera que sean enviados. Al momento de hacer el cierre con diferencias la columna tomará el valor absoluto de la columna "Diferencia". 

Al momento de guardar una orden de ingreso, si la orden de compra no registra diferencias negativas, la orden se guardará en estado "Recibida Completa". Si hay diferencias se grabará en estado "Parcialmente Recibida".

Las ordenes de compra que no tengan diferencias, se cerrarán automáticamente cuando se grabe la orden de ingreso de materiales y pasarán a estado "Completa".

El sistema deberá poder mostrar todos los ingresos del día en el formato de la planilla R37-O que se utiliza actualmente. la planilla debe poder exportarse como un archivo Excel.


<a name="lista-de-ordenes-de-ingreso"></a>

## Lista de Ordenes de Ingreso

El sistema permitirá ver una lista de todas las ordenes de ingreso entrando desde el menú principal y mostrará las ordenes de ingreso relacionadas a una orden de compra cuando estemos viendo el formulario de orden de compra.

Ambas listas de ordenes de ingreso deben poder ser ordenadas por todos sus campos y se debe poder buscar por texto y por cualquiera de sus campos.

El formato de la lista de ordenes de ingreso es el siguiente:

| Dato | Descripción |
|:-- | :---- | 
| nro. de orden | Es el nro. dela orden de ingreso.
| Orden de Compra | Es el nro. de la orden de compra. No es visible cuando estamos en el formulario de orden de compra |
| Fecha y hora de la orden de ingreso | La fecha y la hora en la que se creó la orden de ingreso de materiales. |
| nro. de Remito | El remito del proveedor que presentó el transportista. |
| Proveedor | El nombre del proveedor que realizó el envío. |
| Cantidad de materiales | Es la cantidad de materiales distintos que trae el envío.|

<a name="datos-en-orden-de-ingreso-de-materiales"></a>

## Datos en Orden de Ingreso de Materiales

Para una Orden de Ingreso de Materiales se registrarán los siguientes datos:

| Dato | Descripción | Requerido |
|:-- | :---- | :--: |
| Nro. de Orden de Ingreso | Es un nro. correlativo de ordenes de ingreso. | Automático |
| Nro. de Remito de Envío | Es el nro. del remito enviado por el cliente. | Sí |
| Nro. de Orden de Compra | Es la orden de compra que vino en el remito. | Sí |
| Fecha y hora de Recepción | Es la fecha de la orden de recepción. | Sí |


Para cada material pedido en la orden de compra registramos los siguientes datos:

| Dato | Descripción | Requerido |
|:-- | :---- | :--: |
| Cod. Material | Es cód. interno del material pedido. | Automático |
| Descripción | Descripción del material. | Automático |
| Lote | Es el nro. de lote del proveedor. viene en el remito. | No |
| Cantidad Pedida | Es la cantidad de la orden de compra. | Automático |
| Cantidad Remito | Es la cantidad que manifiesta haber enviado el cliente. | Sí |
| Cantidad Enviada | Anotamos lo recibido. | Sí |
| Cantidad Recibida | La cantidad de material que hemos recibido hasta el momento en todas las ordenes de ingreso para esta orden de compra y este material. | Automático |
| Diferencia | Recibida - Pedida | Automático |
| Sin Entrega | Es la cantidad que sabemos que no vamos a recibir. | Automático |
| Depósito | Permite elegir el depósito al que va ir el material recibido. | Sí |

<a name="planilla-de-recepcion-de-materiales-R37-0"></a>

## Planilla de Recepción de Materiales R37-0

Esta planilla se utiliza actualmente para registrar la entrada de materiales al depósito y registra los movimientos diarios. El sistema debe poder crear esta planilla con la información de las ordenes de ingreso de materiales para una fecha dada como parámetro y permitir exportarla en formato Excel.

Los datos del registro de la planilla R37-0 son los siguientes:

| Dato | Descripción |
|:-- | :---- |
| nro. IR | nro. correlativo de ingreso. Comienza desde 1.  | 
| nro. de Orden de ingreso | nro. de la orden de ingreso de materiales. |
| Fecha Ingreso | Es la fecha en la que ingresó el material. |
| Cód. Material | Código de Material interno. |
| nro. Orden de Compra | Orden de compra para la que ingresó el material. |
| Remito Proveedor | Nro. del Remito del proveedor. |
| Lote | Nro. de Lote del Material. Viene en el remito.|
| Proveedor | Nombre del proveedor. Viene de la orden de compra. |
| Cantidad Remito | La cantidad de material que declara el remito. |
| Cantidad Recibida | Es la cantidad de material que llegó en el envío |
| Depósito | Nombre del depósito donde se almacenó el material ingresado. | 













