<a name="ordenes-de-ingreso-de-materiales"></a>

- [Ordenes de Ingreso de Materiales](#ordenes-de-ingreso-de-materiales)
  - [Requerimiento del Negocio](#requerimiento-del-negocio)
  - [Ingresos de materiales sin Orden de Compra](#ingresos-de-materiales-sin-orden-de-compra)
  - [Lista de Ordenes de Ingreso](#lista-de-ordenes-de-ingreso)
  - [Datos en Orden de Ingreso de Materiales](#datos-en-orden-de-ingreso-de-materiales)
  - [Planilla de Recepción de Materiales R37-0](#planilla-de-recepción-de-materiales-r37-0)
  - [Impresión de Etiquetas de Materiales](#impresión-de-etiquetas-de-materiales)
  - [Información sobre la impresora de etiquetas que deberá utilizar el sistema](#información-sobre-la-impresora-de-etiquetas-que-deberá-utilizar-el-sistema)


# Ordenes de Ingreso de Materiales

<a name="requerimiento-del-negocio"></a>

## Requerimiento del Negocio

Como empleado de la empresa a cargo de registrar el ingreso de materiales, debo poder ver un listado de todas las órdenes de compra de materiales, destacando las que están en estado "En Tránsito" y "Parcialmente Recibidas".

Cuando un envío de materiales arriba a la empresa, el transporte presenta el remito de envío en el cuál figura el nro. de orden de compra al que el envío está relacionado y el manifiesto de la lista de materiales que han sido enviados y sus cantidades.

Luego de la inspección inicial del envío, el próximo paso es crear una orden de ingreso de materiales para la orden de compra que figura en el remito. Para ello seleccionaré la orden de compra relacionada y anotaré el nro. de remito y fecha.

En la orden de ingreso el sistema cargará la lista de materiales pedidos. La lista debe mostrar junto a los datos del material las columnas: Cantidad Pedida, Presentación, Cantidad Enviada, Cantidad declarada en Remito, Diferencia y Sin Entrega.

En las **columnas Cantidad Pedida y Presentación** se copia el valor que está en la Orden de Compra para cada material.

En la columna "Cantidad Enviada" se anota la cantidad que se declara en el remito del cliente.

En el siguiente paso es usuario anotará, en la columna "Cantidad Enviada" la cantidad de Presentaciones que llegaron, es decir la cantidad de cajas o bolsas.

Puede darse el caso de que las cantidad envida sea 0, porque no se envió algún material pedido o que la cantidad recibida sea mayor a la pedida.

El sistema calculará el valor de la columna "Diferencia" a medida que vaya ingresando las cantidades enviadas y recibidas. Se calcula con la fórmula Cantidad Enviada - Cantidad Pedida. Un valor negativo nos dice que aún se nos deben materiales, uno positivo nos dice que vino material de más.

Para una misma orden de compra podrían llegar más de un envío, para lo que tendremos diferentes números de remito y crearemos diferentes ordenes de ingreso.

La columna "Sin Entrega" estará en cero hasta que se haga un cierre con diferencias para la orden de compra. Este proceso se realiza por un usuario con autorización específica y lo que nos dice es que los materiales restantes no se espera que sean enviados. Al momento de hacer el cierre con diferencias la columna tomará el valor absoluto de la columna "Diferencia". 

Al momento de guardar una orden de ingreso, si la suma de las cantidades recibidas para un material en todas las ordenes de ingreso asociadas a la misma orden de compra es menor que la cantidad pedida ese material, entonces la orden de compra pasará a estado "Parcialmente Recibida"

Las ordenes de compra que no tengan diferencias, se cerrarán automáticamente cuando se grabe la orden de ingreso de materiales y pasarán a estado "Completa".

El sistema deberá poder mostrar todos los ingresos del día en el formato de la planilla R37-O que se utiliza actualmente. la planilla debe poder exportarse como un archivo Excel.

Al confeccionar una orden de ingres, para cada material recibido se imprime en una etiqueta autoadhesiva la información del material, fecha y hora de ingreso y Nro. de orden de Ingreso.

## Ingresos de materiales sin Orden de Compra

Es posible ingresar materiales a depósito que no están relacionados a una compra a un proveedor. En este caso se anotará el origen del mismo y la información de orden de compra quedará en blanco. 

Este tipo de ingresos se utiliza típicamente para anotar préstamos de materiales de empresas colegas o para realizar ajustes de stock luego de realizado un inventario.

Para estos casos se le pedirá al usuario que describa la razón que fundamenta el nuevo ingreso.

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
| Nro. de Remito de Envío | Es el nro. del remito enviado por el cliente. | Si hay un nro. de Orden de Compra. |
| Nro. de Orden de Compra | Es la orden de compra que vino en el remito. | No |
| Fecha y hora de Recepción | Es la fecha de la orden de recepción. | Sí |
| Origen | Descripción del origen de los materiales de la orden. 300 caracteres | Cuando NO hay un nro. de Orden de compara. |
| Causa | Descripción de la razón que motiva este ingreso de materiales. 300 caracteres |Cuando NO hay un nro. de Orden de compara. |

Solo si hay un nro. de orden de compra, entonces el campo Nro. de Remito de Envío es mandatorio.

Si no hay nro. de orden de compra, se mostrarán los campos Origen y Causa, que serán requeridos.


Para cada material pedido en la orden de compra registramos los siguientes datos:

| Dato | Descripción | Requerido |
|:-- | :---- | :--: |
| Cod. Material | Es cód. interno del material pedido. | Automático |
| Descripción | Descripción del material. | Automático |
| Lote | Es el nro. de lote del proveedor. viene en el remito. | No |
| Cantidad Pedida | Es la cantidad de la orden de compra. | Automático |
| Presentación | Es la cantidad por paquete, viene de la orden de compra. | Automático |
| Cantidad Remito | Es la cantidad que manifiesta haber enviado el cliente. | Sí |
| Cantidad Enviada | Anotamos lo recibido. | Sí |
| Diferencia | Recibida - Pedida | Automático |
| Sin Entrega | Es la cantidad que sabemos que no vamos a recibir. | Automático |
| Depósito | Permite elegir el depósito al que va ir el material recibido. | Sí |
| Cantidad Recibida para OC | Es la suma de todas las cantidades enviadas en todas las ordenes de ingreso de la misma Orden de Compra | Automático |

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
| Presentación | Es la cantidad por paquete, viene de la orden de compra. | Automático |
| nro. Orden de Compra | Orden de compra para la que ingresó el material. |
| Remito Proveedor | Nro. del Remito del proveedor. |
| Lote | Nro. de Lote del Material. Viene en el remito.|
| Proveedor | Nombre del proveedor. Viene de la orden de compra. |
| Cantidad Remito | La cantidad de material que declara el remito. |
| Cantidad Recibida | Es la cantidad de material que llegó en el envío |
| Depósito | Nombre del depósito donde se almacenó el material ingresado. | 

Un ejemplo de la planilla actual se puede encontrar en:

https://docs.google.com/document/d/1L3pwqke0TlVDdHghR-EsD6dKHL0PwM7W/edit?usp=sharing&ouid=108623408733850810728&rtpof=true&sd=true página 6.

## Impresión de Etiquetas de Materiales

El sistema deberá imprimir una etiqueta autoadhesiva por cada material que haya llegado en la orden de ingreso. Se imprimirá 1 por cada presentación que se reciba.

La información que aparecerá en la etiqueta es la siguiente.

| Dato | Formato |
|:-- | :-- |
| Setecel srl. | texto |
| Descripción del Material | texto |
| Color, Familia, línea y  sección | texto. para familiar terminales, conectores y sellos
| Código de Material | texto |
| Presentación | numérico | 
| Ingreso: Fecha de ingreso | texto |
| Nro. de Orden de Ingreso | texto |
| Código de barras | Con la información de los otros campos en formato Code 128 |

Algunas imágenes de ejemplo de las etiquetas actuales se pueden encontrar en el siguiente link:

https://docs.google.com/document/d/1L3pwqke0TlVDdHghR-EsD6dKHL0PwM7W/edit?usp=sharing&ouid=108623408733850810728&rtpof=true&sd=true Página 5.

El nuevo formato que se desarrolle debe ser similar, pero incluir el campo Código de Barras.


## Información sobre la impresora de etiquetas que deberá utilizar el sistema
El nuevo formato que se desarrolle debe ser similar, pero incluir el campo Código de Barras.

La impresora a utilizar es una Zebra modelo TLP 2844.

Información sobre esta impresora en el fabricante se puede encontrar en la url: 

https://www.zebra.com/la/es/support-downloads/printers/desktop/tlp-2844.html

Manual de programación: 

https://www.zebra.com/content/dam/zebra_new_ia/en-us/manuals/printers/common/programming/epl2-pm-en.pdf










