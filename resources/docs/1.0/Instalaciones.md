# Instalaciones

<a name='Instalaciones'></a>
 
 - [Instalaciones](#instalaciones)
 - [Requerimiento del Negocio](#requerimiento-del-negocio)
 - [Datos de Instalaciones](#datos-de-instalaciones)
 - [Revisiones](#revisiones)
 - [Lista de Materiales](#lista-de-materiales)

<a name='requerimiento-del-negocio'></a>

## Requerimiento del Negocio
 
Las instalaciones son los productos que fabricamos. Son mazos de cables que se utilizan para conectar componentes electrónicos de motos, equipos de GNC y electrodomésticos.

Como empleado de la empresa a cargo de instalaciones, debo poder registrar los modelos de instalaciones que construimos, agregar nuevos y agregar revisiones del diseño para una instalación existente.

Una revisión es un cambio en la lista de materiales que componen una instalación. 

Una instalación puede tener varias revisiones y se marca como la actual a la más nueva. La revisión actual es la que se utiliza habitualmente en los pedidos de clientes, aunque siempre puede elegirse alguna otra.

La lista de materiales que componen una instalación se carga por código de producto y la cantidad que se utiliza de los mismos.

Cada instalación tendrá su diseño, que es un esquema de cómo se conectan sus materiales componentes para crearla.

Debo poder anotar en qué depósito se guardan las instalaciones cuando  salen de la línea de producción se las almacena en un depósito.  

El sistema debe permitirme ver una lista de las instalaciones registradas y los datos de sus revisiones y materiales que las componen.

El sistema me permitirá duplicar una revisión para poder realizar cambios en sus componentes sin tener que ingresar todos los materiales nuevamente.


<a name='datos-de-instalaciones'></a>

## Datos de Instalaciones

Para las instalaciones debo poder registrar los siguientes datos:

| Dato | Descripción | Requerido |
|:-- | :----- | :--: |
| Código | Código interno del producto | Sí |
| Descripción | Breve descripción del producto | Sí |
| Fecha | Fecha de ingreso de la instalación | Sí |


<a name='revisones'></a>

## Revisiones 

Para cada revisión del diseño de una instalación debo poder cargar la lista de materiales que la componen y debo registrar los siguientes datos:

| Dato | Descripción | Requerido |
| :--  | :------ |:--:|
| Número de revisión | Es correlativo empezando desde 0 | Automático |
| Descripción | Breve descripción de la revisión | Sí |
| Fecha | Fecha de creación de la revisión | Automático |
| Razón | Comentario sobre las razones de cambio de versión. | Sí |

Debo crear una revisión desde el formulario de edición de datos de una instalación.


<a name='lista-de-materiales'></a>

## Lista de Materiales

| Dato | Descripción | Requerido |
| :-- | :------ | :--: |
| Código de Material | Es el código interno del material | Sí |
| Descripción | Breve descripción del Material | Automático |
| Cantidad | Cuantas unidades de este material se utilizan | Sí |
| Unidad de medida | mm, unidades, gr | Automático |







