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

Para registrar el ingreso de Materiales a un depósito se debe confeccionar una Orden de Ingreso de Materiales.

Para registrar un ingreso de productos ensamblados o finales se realizará la modificación del registro de producto en el depósito correspondiente cuando se realice una carga de nuevo productos terminados.

Los productos semi-ensamblados se registrar por cantidad, de forma similar a las de los materiales, pero los productos terminados (instalaciones) se registran con número de serie y nro. de pedido al que pertenecen.

Para cada depósito debo poder ver la lista de materiales, productos y subproductos que están almacenados en él.

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
| Propósito | Descripción breve de qué se pretende almacenar mayormente. | No |

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
| Código | De ensamblado. Es el código creado al crear un producto ensamblado. | Sí |
| Cantidad | Cantidad de unidades del objeto. Siempre mayor de 0. | Sí |
| Fecha ingreso | Fecha del último ingreso de material al depósito | Sí |

<a name='detalle-de-instalaciones-almacenadas'></a>
### Detalle de Instalaciones almacenadas

Para registrar productos terminados en un depósito se registrarán los siguientes datos:

| Dato | Descripción | Requerido |
| :--  | :------     | :--:  |
| Código | De instalación. | Sí |
| Nro. Versión | Es el nro. de revisión de la instalación almacenada | Sí |
| Número de Serio | Es el número otorgado en la ficha de producción al mazo. | Sí |
| Cód. Pedido de Cliente | Es el código de pedido al que perteneces el mazo ingresado | Sí |
| Fecha ingreso | Fecha del último ingreso de material al depósito | Sí |

Nota: Mazo e Instalación son sinónimos.






































