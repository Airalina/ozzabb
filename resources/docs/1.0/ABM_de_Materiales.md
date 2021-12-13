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

Como usuario del sistema debo poder llevar registro de los materiales que utilizamos para construir nuestros productos y la cantidad que tenemos de cada uno de ellos en depósito y la cantidad que hemos comprado y estamos esperando que lleguen. Para los materiales deseo conocer, además, quiénes son sus proveedores, sus precios y poder ver varias fotos del mismo.

<a name='lista-de-materiales'></a>

## Lista de Materiales

- Debo poder ver una lista con los materiales registrados en el sistema, ordenados alfabéticamente por nombre. La lista debe estar paginada, pero debo poder buscar por todos los campos de la misma.

- Los datos que se muestran en la lista de materiales son los siguientes:
  
| Dato              | Tipo              | Descripción                |
| :-- | :-- | :-- |
| Código            | Texto   | Permite entrar al Formulario de Alta y Modificación de Materiales.     |
| Familia           | Texto   | Nombre de la familia de materiales a la que pertenece.    |
| Detalle           | Texto   | Descripción coloquial del material.     |
| Color             | Cuadro de color | Color que tiene el producto.  |
| Línea             | Texto | Líneas de producto donde se utiliza el producto. Proviene de un enumerado que se usa en edición. |
| Stock en planta   | Numérico, 6 dígitos | Cuántas unidades del producto tenemos en el depósito de la planta.     |
| Stock en tránsito | Numérico, 6 dígitos | Es la cantidad de unidades de este material que están referidas en las Órdenes de Compra no cerradas. |
| Stock             |  Numérico          | Es la suma de los campos Stock en Planta y Stock en Tránsito.          |

  - La lista debe poder ordenarse por todos las columnas de datos.
  - Debo poder buscar en la lista escribiendo texto.

<a name='datos-de-materiales'></a>

## Datos de Materiales

  - Para cada material debo poder registrar los siguientes datos:  
  
<a name='datos-comunes-a-todas-las-familia-de-materiales'></a>

  ### Datos comunes a todas las Familia de Materiales
| Datos    | Tipo      | Descripción | Requerido  |
| :---- | :---- | :----------- | :--------: |
| Código | Texto   | Es el código de material interno para la empresa.  |     Sí     |
| Nombre    | Texto  | Es el nombre por el que se conoce al material coloquialmente.  |     Sí     |
| Familia   | Selector | Conectores, Terminales, Cables, Sellos     |     Sí     |
| Color     | Selector de Color | Muestra una paleta de colores, ej. amarillo, Rojo y Negro. |     Sí     |
| Descripción | Texto multilínea | Permite escribir una pequeña descripción del material. tamaño máximo de 500 caracteres. |     No     |
| Línea     | Enumerado: Superseal, Mini Fit, Bulldog, Econoseal, Eco |Muestra la lista de Líneas de productos en la que se usa este material. | Sí          |
| Uso       | Enumerado: Motos, GNC, Electro | Muestra la lista de Áreas de Uso de los productos en los que se utiliza este material. |     Sí     |
| Reemplazo | Selector   | Es una lista de materiales de la misma familia, con los que se puede reemplazar|Sí             |
| Stock Mínimo |  Numérico  | No puede haber menos de esta cantidad de unidades de este material en stock.           |     Sí     |
| Stock Máximo |  Numérico  | Es el máximo que se puede tener en depósito.  |     No     |
| Stock en Planta |  Numérico  | Cuántas unidades del producto tenemos en el depósito de la planta.      Sí     |

<a name='datos-que-se-agregan-para-familia-conectores'></a>

### Datos que se agregan para familia Conectores

|Dato|Tipo|Descripción|Requerido|
|:--|:---|:--------|:--:|
|Terminal Asociado|Selector|Muestra la lista de materiales de familia Terminales.|No|
|Sello Asociado|Selector|Es una lista de materiales Familia Sellos.|No|
|Cantidad de Vías| Numérico, 2 dígitos |Cantidad de cables que pueden conectarse.|Sí|
|Tipo|Selector|Valores: Porta Macho, Porta Hembra|Sí|
|Contraparte|Selector|Lista de materiales de familia Terminales.|No|
|Estanco | Binario | Describe si el conector es estanco. | Sí |

<a name='datos-que-se-agregan-para-las-familias-terminales-y-cables'></a>

### Datos que se agregan para las familias Terminales 

|Dato|Tipo|Descripción|Requerido|
|:--|:---|:--------|:--:|
|Tamaño| Numérico, 2 decimales |Es el tamaño del cable para el que se usa esta terminal. Valores ej.: 1,2;1,5;1,8;2;2,5;2,8;6,3. mm|Sí|
|Sección mínima agrafado| Numérico, 2 decimales| Es el grosor mínimo de cable que se puede utilizar con este Terminal. | No|
|Sección Máxima agrafado| Numérico, 2 decimales| Es el grosor máximo de cable que se puede utilizar con este Terminal.| No|
|Material | enumerado: Latón, Estañado | Es el material del que está hecho el Terminal | Sí |
|Tipo | enumerado: Hembra, Macho | Es el tipo de Terminal. | Sí |


### Datos que se agregan para las familias Cables 

|Dato|Tipo|Descripción|Requerido|
|:--|:---|:--------|:--:|
|Sección | Numérico , 2 decimales | Es el grosor del cable en milímetros. | Sí |
|Color Base | Color | Es el color general de la cobertura. | Sí |
|Color línea | Color | Es el color de la línea. | No |
|Configuración de Trenza | Enumerado: 16 x 20mm; 34 x 20mm | Describe cómo está construido el cable | Sí |
|Norma | Enumerado: Iram 247-5, Iram 247-3, IR, ID, Blindado, Multifilar | Norma de construcción del cable | Sí |
|Cantidad de unipolares | Numérico | -- | No |
|Tipo de Malla | Texto | -- | No |
|Temperatura de Servicio | Numérico, 2 decimales | Temperatura en grados Celsius. | Sí |

Para Cables el campo Línea no se debe cargar.


<a name=''></a>

## Lista de Precios
Para cada material, debo poder registrar los siguientes datos:

|Dato|Tipo|Descripción|Requerido
|:--|:---|:--------|:--:|
|Código Proveedor | Texto | Es el código con el que el material es conocido en el proveedor.| No
|Presentación | Numérico | Es la cantidad de unidades en las que el proveedor vende el material. | Sí
| Fecha | Fecha en formato "dd/MM/YYYY" | Es la fecha en la que se cargó el precio, pero puede editarse para cargar fechas diferentes. | Sí
| Precio | Numérico, 2 decimales | Precio al que vende el proveedor el material en  esta presentación. | Sí

Desde el mismo formulario de alta y edición de materiales debo poder agregar los precios por proveedor y verlos ordenados por fecha de forma descendente.

La lista de precios debe poder ordenarse por todos sus campos de datos.
















  






