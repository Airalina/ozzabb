<a name='materiales'></a>

# Materiales

  - [Materiales](#materiales)
   - [Requerimiento del Negocio](#requerimiento-del-negocio)
   - [Lista de Materiales](#lista-de-materiales)
   - [Datos de Materiales](#datos-de-materiales)
      - [Datos comunes a todas las Familia de Materiales](#datos-comunes-a-todas-las-familia-de-materiales)
      - [Datos que se agregan para familia Conectores](#datos-que-se-agregan-para-familia-conectores)
      - [Datos que se agregan para las familias Terminales y Cables](#datos-que-se-agregan-para-las-familias-terminales-y-cables)
  

<a name='requerimiento-del-negocio'></a>

## Requerimiento del Negocio

Como usuario supervisor quiero llevar registro de los materiales que utilizamos para construir nuestros productos y la cantidad que tenemos de cada uno de ellos en depósito y los que hemos comprado y estamos esperando que lleguen. Para los materiales deseo conocer, además, quiénes son sus proveedores, sus precios y poder ver varias fotos del mismo.

<a name='lista-de-materiales'></a>

## Lista de Materiales

- Debo poder ver una lista con los materiales registrados en el sistema, ordenados alfabéticamente por nombre.
- Los datos que se muestran en la lista de materiales son los siguientes:
  
| Dato              | Tipo              | Descripción                                                                                           |
| :---------------- | :---------------- | :---------------------------------------------------------------------------------------------------- |
| Código            | Texto con enlace  | Permite entrar al Formulario de Alta y Modificación de Materiales                                     |
| Familia           | Texto             | Nombre de la familia de materiales a la que pertenece.                                                |
| Nombre            | Texto             | Nombre por el que se conoce el material coloquialmente                                                |
| Color             | Caja de color     | Color que tiene el producto                                                                           |
| Línea             | Selector múltiple | Líneas de producto donde se utiliza el producto                                                       |
| Stock en planta   | Numérico          | Cuántas unidades del producto tenemos en el depósito de la planta                                     |
| Stock en tránsito | Numérico          | Es la cantidad de unidades de este material que están referidas en las Órdenes de Compra no cerradas. |
| Stock             | Numérico          | Es la suma de los campos Stock en Planta y Stock en Tránsito.                                         |

  - La lista debe poder ordenarse por todos las columnas de datos.
  - Debo poder buscar en la lista escribiendo texto.

<a name='datos-de-materiales'></a>

## Datos de Materiales

  - Para cada material debo poder registrar los siguientes datos:  
  
<a name='datos-comunes-a-todas-las-familia-de-materiales'></a>

  ### Datos comunes a todas las Familia de Materiales
| Datos    | Tipo      | Descripción | Requerido  |
| :---- | :---- | :----------- | :--------: |
| Código                                                | Texto                                                                        | Es el código de material interno para la empresa.                                      |     Sí     |
| Nombre                                                | Texto                                                                        | Es el nombre por el que se conoce al material coloquialmente.                          |     Sí     |
| Familia                                               | Selector                                                                     | Conectores, Terminales, Cables, Sellos                                                 |     Sí     |
| Color                                                 | Selector de Color                                                            | Muestra una paleta de colores, ej. amarillo, Rojo y Negro.                              |     Sí     |
| Descripción                                           | Texto multilínea                                                             | Permite escribir una pequeña descripción del material. tamaño máximo de 500 chars      |     No     |
| Línea                                                 | Texto|Muestra la lista de Líneas de productos en la que se usa este material. | Sí                                                                                     |
| Uso                                                   | Texto                                                                        | Muestra la lista de Áreas de Uso de los productos en los que se utiliza este material. |     Sí     |
| Reemplazo                                             | Selector                                                                     | Es una lista de materiales de la misma familia, con los que se puede reemplazar|Sí                                                                           |
| Stock Mínimo                                          | Numérico                                                                     | No puede haber menos de esta cantidad de unidades de este material en stock.           |     Sí     |
| Stock Máximo                                          | Numérico                                                                     | Es el máximo que se puede tener en depósito                                            |     No     |
| Stock en Planta                                       | Numérico                                                                     | Cuántas unidades del producto tenemos en el depósito de la planta.                     |     Sí     |

<a name='datos-que-se-agregan-para-familia-conectores'></a>

### Datos que se agregan para familia Conectores

|Dato|Tipo|Descripción|Requerido|
|:--|:---|:--------|:--:|
|Terminal Asociado|Selector|Muestra la lista de materiales de familia Terminales.|No|
|Sello Asociado|Selector|Es una lista de materiales Familia Sellos.|No|
|Cantidad de Vías|Numérico|Permite ingresar un número Natural de 2 cifras.|Sí|
|Tipo|Selector|Valores: Porta Macho, Porta Hembra|Sí|
|Contraparte|Selector|Lista de materiales de familia Conectores.|No|

<a name='datos-que-se-agregan-para-las-familias-terminales-y-cables'></a>

### Datos que se agregan para las familias Terminales y Cables

|Dato|Tipo|Descripción|Requerido|
|:--|:---|:--------|:--:|
|Tamaño|Numérico|Es el tamaño del cable para el que se usa esta terminal. Valores ej.: 1,2;1,5;1,8;2;2,5;2,8;6,3. mm|Sí|
|Sección mínima|Numérico| | No|
|Sección Máxima|Numérico| | No|


<a name=''></a>

## Lista de Precios












  






