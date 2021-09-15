# Depósitos

- [Depósitos](#depósitos)
  - [Requerimiento del Negocio](#requerimiento-del-negocio)
  - [Datos de Depósito](#datos-de-depósito)
    - [Detalle de Materiales almacenados](#detalle-de-materiales-almacenados)
    - [Detalle de Ensamblados almacenados](#detalle-de-ensamblados-almacenados)
    - [Detalle de Instalaciones almacenadas](#detalle-de-instalaciones-almacenadas)

<a name='requerimiento-del-negocio'></a>

## Requerimiento del Negocio

Como empleado a cargo de stock debo poder crear y administrar una lista de lugares destinados al almacenamiento de materiales, productos semi-ensamblados y productos terminados. Se denominarán Depósitos.

Un depósito puede hacer referencia a una estructura, como por ej. un galpón, lote o edificio, o a una zona dentro de una estructura destinada al almacenamiento de materiales, productos y subproductos.

Un depósito puede ser temporal o permanente y debo poder darle de baja, siempre y cuando no se registren unidades almacenadas en él.

Un depósito puede almacenar objetos de distinto tipo.

Para registrar el ingreso de Materiales a un depósito se debe confeccionar una Orden de Ingreso de Materiales. Las ordenes de ingreso de materiales se describen en otro documento.

Los Materiales se ingresan a depósito por presentación, es decir por paquete. Se guarda la cantidad de paquetes de cierto tamaño de unidades que tenemos en el depósito. por ej. si tenemos 12000 conectores de tipo X en bolsas de 3000 unidades en el depósito Y, entonces en Código de material dirá X, Presentación dirá 3000 y en cantidad de unidades 4. Esto sirve para poder contestar a preguntas del estilo. ¿Cuántas bolsas de 3000 conectores tipo X tenemos en un depósito Y?

Si un material no viene en empaques, por ejemplo los cables o se ingresan ensamblados ambos se anotan con Presentación = 1. De esta manera la fórmula (Presentación * [Cantidad de unidades]) nos dará el total de unidades que se han almacenado de un material o ensamblado.

Los productos terminados (instalaciones) se registran de manera diferente, en vez de anotar una presentación y una cantidad de unidades, cada mazo se anotará con cantidad 1 y su nro. de serie de serie y nro. de pedido al que pertenecen. Esto nos permite hacer envíos a los clientes de manera más sencilla al tener la información del pedido.

Para cada depósito debo poder ver la lista de materiales, productos terminados y ensamblados que están almacenados en él.

Debo poder ver una lista de los depósitos registrados en el sistema y explorar sus existencias. También debo poder realizar ingresos y egresos de objetos desde el formulario de administración de un depósito.


<a name='datos-de-depositos'></a>

## Datos de Depósito

Para un depósito debo poder registrar los siguientes datos:

| Dato | Descripción | Requerido |
| :--  | :------     | :--:  |
| Nombre | Nombre del depósito. | Sí |
| Ubicación | Descripción de la ubicación de lugar de almacenamiento. | Sí |
| Estado | Habilitado, Lleno, Deshabilitado. | Sí: Habilitado |
| Fecha | Fecha de Creación del depósito. | Sí |
| Descripción | Descripción breve de qué se pretende almacenar mayormente. | No |


<a name='detalle-de-objetos-almacenados'></a>

### Detalle de Materiales almacenados

Para cada depósito debo poder ver la lista de los objetos almacenados en él. Para cada material se registrarán los siguientes datos.

| Dato | Descripción | Requerido |
| :--  | :------     | :--:  |
| Código | De Material, ensamblado o Producto final. | Sí |
| Cantidad | Cantidad de unidades del objeto. Siempre mayor de 0. | Sí |
| Fecha ingreso | Fecha del último ingreso de material al depósito | Sí |

El ingreso de materiales a un depósito se registra mediante la confección de una Orden de Ingreso de Materiales. 

El ingreso de Materiales puede darse por dos razones: 1) Cuando llega un envío con pedidos de clientes. 2) Cuando se registra un ingreso para corregir datos de stock.

<a name='detalle-de-ensamblados-almacenados'></a>

### Detalle de Ensamblados almacenados

Para registrar productos ensamblados se registrarán los siguientes datos:

| Dato | Descripción | Requerido |
| :--  | :------     | :--:  |
| Código | De ensamblado. Es el código numérico secuencial asignado al crear un producto ensamblado. | Sí |
| Cantidad | Cantidad de unidades del objeto. Siempre mayor de 0. | Sí |
| Fecha ingreso | Fecha del último ingreso de material al depósito | Sí |

<a name='detalle-de-instalaciones-almacenadas'></a>

### Detalle de Instalaciones almacenadas

Para registrar productos terminados en un depósito se registrarán los siguientes datos:

| Dato | Descripción | Requerido |
| :--  | :------     | :--:  |
| Código | De instalación. | Sí |
| Nro. Versión | Es el nro. de revisión de la instalación almacenada | Sí |
| Número de Serie | Es el número otorgado en la ficha de producción al mazo. | Sí |
| Cód. Pedido de Cliente | Es el código de pedido al que perteneces el mazo ingresado | Sí |
| Fecha ingreso | Fecha del último ingreso de material al depósito | Sí |

Nota: Mazo e Instalación son sinónimos.






































