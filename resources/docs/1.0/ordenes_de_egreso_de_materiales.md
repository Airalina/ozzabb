<a name="ordenes_de_egreso_de_materiales"></a>
- [Ordenes de Egreso de Materiales](#ordenes-de-egreso-de-materiales)
  - [Requerimiento del Negocio](#requerimiento-del-negocio)
  - [Ordenes de Egreso para llevar materiales a otro depósito](#ordenes-de-egreso-para-llevar-materiales-a-otro-depósito)
  - [Datos a mostrar en lista de Ordenes de Egreso de Materiales](#datos-a-mostrar-en-lista-de-ordenes-de-egreso-de-materiales)
  - [Datos de Orden de Egreso de Materiales](#datos-de-orden-de-egreso-de-materiales)
    - [Detalle de Orden de Egreso de Materiales](#detalle-de-orden-de-egreso-de-materiales)
# Ordenes de Egreso de Materiales

<a name="requerimiento_de_negocio"></a>

## Requerimiento del Negocio

Como empleado de la empresa a cargo de la administración de depósitos de materiales debo poder anotar los materiales que se han retirado de depósito.

Para cada egreso deberé poder anotar el depósito de origen, los materiales retirados, su cantidad, un destino y quién es el responsable del retiro.

Para anotar los movimientos de materiales, confeccionaré una Orden de Egreso de Materiales donde constataré todos los datos antes mencionados, junto con la fecha y hora del evento.

Cada Orden de Retiro será identificada con un nro. único consecutivo dentro de un año calendario.

Al confeccionar una orden de egreso las cantidades anotadas serán descontadas de la cantidad del material correspondiente en el depósito especificado.

Una orden de Egreso puede incluir Materiales Puro, ensamblados y productos terminados.

Las Ordenes de Retiro de Materiales no se podrán borrar, si no que se pondrán en estado "Cancelada", los otros estados posibles son "Nueva", los materiales no fueron retirados y "Cerrada" los materiales fueron retirados de los depósitos.

El sistema debe permitirme ver una lista de todas las Ordenes de Egreso ordenarlas y realizar búsquedas por texto en todos sus campos. 

En los depósitos donde tenemos almacenados materiales en su empaque original, pudiendo estos ser bolsas, cajas u otras formas de empaque, las extracciones se realizarán por paquete.

En el detalle de la orden se anotará el tipo de empaque que se está retirando y la cantidad de los mismos que nos estamos llevando.

En los depósitos que no almacenan por paquete, como por ejemplo un depósito destinado a producción o a ensamblados, la presentación puede ser 1 y la cantidad anotar los elementos individuales que tenemos en el depósito, ya sean bandejas, cajones, cajas u otro medio de almacenamiento.

En un típico movimiento de materiales de un almacén a la línea de producción, las ordenes de egreso de materiales especificarán la presentación que se retira y en la Orden de Ingreso relacionada para el depósito llamado Producción se anotará la cantidad de unidades de cada material que entraron, sin información de presentación.

## Ordenes de Egreso para llevar materiales a otro depósito

En general los retiros de materiales se hacen para llevar materiales a la línea de producción, por lo tanto existe de hecho un depósito especial y permanente denominado "Producción". 

Cuando se confeccionen órdenes de egreso de materiales para movimientos entre depósitos, el usuario deberá confeccionar la correspondiente orden de ingreso de los materiales en el depósito destino. A menos que el destino de los materiales retirados sea la línea de producción en cuyo caso el sistema se encargará de confeccionar automáticamente la orden de ingreso en el depósito denominado Producción.



## Datos a mostrar en lista de Ordenes de Egreso de Materiales

En la lista de Ordenes de Egreso de Materiales el sistema mostrará los siguientes datos:

| Dato | Descripción |
|:-- | :---- |
| Nro. de orden | El el nro. de la orden. |
| Fecha y hora | Cuando se realizó. |
| Cantidad | La cantidad de materiales retirados. Es la cantidad de materiales diferentes que se retiraron, no la suma de las cantidades individuales retiradas. | 
| Usuario que retira | Nombre y Apellido de la persona que retira los materiales. |


<a name="datos-de-orden-de-egreso-de-materiales"></a>

## Datos de Orden de Egreso de Materiales

Una Orden de Egreso de Materiales registrará los siguientes datos:

| Dato | Descripción | Requerido |
|:-- | :---- | :--: |
| nro. de orden de egreso | Nro. consecutivo dentro del un año calendario. formato d(5)YYYY | Automático |
| Fecha y hora | Fecha y hora en la que se realizó el egreso. | Automático |
| Usuario que retira | Nombre y Apellido de la persona que retira los materiales. Puede ser diferente de la persona que crea la orden de egreso. | Sí |
| Estado | Nos dice si los materiales fueron retirados usando la orden como autorización. Los valores posibles son "Nueva", "Cerrada", "Cancelada" | Sí |


### Detalle de Orden de Egreso de Materiales

| Dato | Descripción | Requerido |
|:-- | :---- | :--: |
| Código de Material | Es el código de Material interno. | Sí |
| Detalle de Material | Descripción del material. | Automático |
| Depósito | Nombre del depósito del que se retira el material.| Sí |
| Presentación | Cantidad de materiales que tiene el paquete que se retira de depósito. 1 para materiales sin presentación. | Sí |
| Cantidad | Cantidad de unidades del material que se retira. | Sí |
| Destino | Campo para explicar la razón del retiro. Puede ser que se lleve a producción o otro depósito o a una entidad externa (prestamos, ventas, etc.) 300 caracteres.| Sí |



