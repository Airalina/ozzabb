# Depósitos

  - [Depósitos](#depósitos)
  - [Requerimiento del Negocio](#requerimiento-del-negocio)
  - [Datos de Depósito](#datos-de-depósito)
  - [Detalla de objetos almacenados](#detalla-de-objetos-almacenados)
  - [Ordenes de Movimiento](#ordenes-de-movimiento)

<a name='requerimiento-del-negocio'></a>

## Requerimiento del Negocio

Como empleado a cargo de stock debo poder crear y administrar una lista de lugares destinados al almacenamiento de materiales, productos semi-ensamblados y productos terminados.

Un almacenamiento puede hacer referencia a una estructura, como por ej. un galpón, lote o edificio, o a una zona dentro de una estructura destinada a el almacenamiento de materiales, productos y subproductos.

Un depósito puede ser temporal o permanente y debo poder darle de baja, siempre y cuando no se registren unidades almacenadas en él.

Un depósito puede almacenar objetos de distinto tipo.

La identificación de un depósito se utiliza en la administración del stock de Materiales, Las Ordenes de Retiro e Ingreso de los mismos y para llevar inventario de los productos semi-ensamblados que no están en la línea de producción y los productos terminados que no han sido aún enviados a los clientes.

Para cada depósito debo poder ver la lista de materiales, productos y subproductos que están almacenados en él y la cantidad de cada uno de los objetos que allí se guardan.

Para cada objeto almacenado en un depósito debo poder llevar registro de las entradas y salidas de objetos. Para Materiales pueden ser Ordenes de Ingreso de Materiales y Ordenes de Retiro de Materiales, Ordenes de movimiento de objetos entre depósitos. 

Para cada entrada se confeccionará una Orden de Ingreso al depósito y para las salidas será una orden de Salida. Cuando se realice un movimiento de un depósito a otro, se realizarán las correspondientes Ordenes de Salida y de Entrada de Objetos.

Debo poder ver una lista de los depósitos registrados en el sistema y explorar sus existencias. También debo poder desde el formulario de administración de un depósito agregar una orden de movimiento.



<a name='datos-de-depositos'></a>

## Datos de Depósito

Para un depósito debo poder registrar los siguientes datos:

| Dato | Descripción | Requerido |
| :--  | :------     | :--:  |
| Nombre | Nombre del depósito. | Sí |
| Ubicación | Descripción de la ubicación de lugar de almacenamiento. | Sí |
| Estado | Habilitado, Lleno, Deshabilitado. | Sí: Habilitado |
| Fecha | Fecha de Creación del depósito. | Sí |
| Propósito | Descripción breve de qué se pretende almacenar mayormente. | No |

<a name='detalle-de-objetos-almacenados'></a>

## Detalla de objetos almacenados

Para cada depósito debo poder ver la lista de los objetos almacenados en él. Para cada objeto se registrarán los siguientes datos.

| Dato | Descripción | Requerido |
| :--  | :------     | :--:  |
| Código | De Material, ensamblado o Producto final. | Sí |
| Tipo de objeto | Material, ensamblado, Instalación. | Sí |
| Cantidad | Cantidad de unidades del objeto. Siempre mayor de 0. | Sí |
| Orden de entrada | Nro. del comprobante que dio entrada al objeto al depósito. | Sí |


<a name = 'ordenes-de-movimiento'></a>

## Ordenes de Movimiento

Para cada movimiento de entrada o salida de objetos de un depósito se deben registrar los siguientes datos:

| Dato | Descripción | Requerido |
| :--  | :------     | :--:  |
| Nro. de Orden de Movimiento | Es el identificador. | Sí |
| Depósito | El deposito en el que se hace el movimiento. | Sí |
| Entrada | Verdadero si es de entrada o falso para salidas. | Sí |
| Fecha | Fecha y hora en la que se anota el movimiento. | Sí |
| Destino | Brevísima descripción del destino del material Producción, Pedido, Nombre de otro depósito. | Sí |


















