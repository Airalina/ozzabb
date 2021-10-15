# Familias de Materiales - Extensión.

## Requerimiento del negocio

En este documento se describen los datos que se deben registrar de otras Familias de Materiales que no se mencionan en el documento ABM de Materiales.

Estas nuevas familias se agregaron posteriormente en el análisis y por esa razón se han puesto en un documento separado.

Además, para familias de materiales ya mencionadas en el documento ABM de Materiales, se detallan algunos cambios y campos nuevos.

Estas familias de materiales tendrán los mismos campos comunes a las otras familias. Esos campos se muestran a continuación.

Las nuevas familias son las siguientes:
  - Sellos
  - Tubos
  - Accesorios
  - Clips

<a name='datos-comunes-a-todas-las-familia-de-materiales'></a>

  ### Datos comunes a todas las Familia de Materiales
| Datos    | Tipo      | Descripción | Requerido  |
| :---- | :---- | :----------- | :--------: |
| Código | Texto   | Es el código de material interno para la empresa.  |     Sí     |
| Nombre    | Texto  | Es el nombre por el que se conoce al material coloquialmente.  |     Sí     |
| Familia   | Selector | Conectores, Terminales, Cables, Sellos     |     Sí     |
| Color     | Selector de Color | Muestra una paleta de colores, ej. amarillo, Rojo y Negro. |     Sí     |
| Descripción | Texto multilínea | Permite escribir una pequeña descripción del material. tamaño máximo de 500 caracteres. |     No     |
| Línea     | Texto |Muestra la lista de Líneas de productos en la que se usa este material. | Sí          |
| Uso       | Texto | Muestra la lista de Áreas de Uso de los productos en los que se utiliza este material. |     Sí     |
| Reemplazo | Selector   | Es una lista de materiales de la misma familia, con los que se puede reemplazar|Sí             |
| Stock Mínimo | Numérico  | No puede haber menos de esta cantidad de unidades de este material en stock.           |     Sí     |
| Stock Máximo | Numérico  | Es el máximo que se puede tener en depósito.  |     No     |
| Stock en Planta | Numérico  | Cuántas unidades del producto tenemos en el depósito de la planta.      Sí     |

### Datos para la familia Sellos
| Datos    | Tipo      | Descripción | Requerido  |
| :-- | :-- | :-- | :--: |
| Diámetro mínimo de Cable | numérico, 2 decimales | Es la sección mínima que tiene que tener el cable al que se le puede aplicar este sello.  | Sí |
| Diámetro mínimo de Cable | numérico, 2 decimales | Es la sección máxima que puede tener el cable al que se le aplique este sello.  | Sí |
| Tipo | texto, 30 caracteres. | Es el tipo de sello. | No |

### Datos para la familia Tubos
| Datos    | Tipo      | Descripción | Requerido  |
| :-- | :-- | :-- | :--: |
| Tipo | enumerado | Valores: Corrugado, Termocontraible, PVC | Sí |
| Diámetro | numérico, 2 decimales | Diámetro del tubo en milímetros | Sí |
| Espesor de Pared |  numérico, 2 decimales | Grosor de la pared del tubo en mm | Sí |
| Diámetro Contraído | numérico, 2 decimales | Diámetro del tubo una vez contraído. Para tubos no contraíbles será el mismo valor del campo Diámetro | Sí |
| Temperatura mínima de Servicio | numérico, 2 decimales | Es la temp. en grados Celsius a la que opera este material. | Sí |
| Temperatura máxima de Servicio | numérico, 2 decimales | Es la temp. en grados Celsius máxima del rango de operación del material. | Sí |

### Datos para la familia Accesorios
| Datos    | Tipo      | Descripción | Requerido  |
| :-- | :-- | :-- | :--: |
| Tipo de accesorio | enumerado: Tapa de Conector, Fusible, Relay, Pasante de Goma | Tipo de accesorio. | Sí |

### Datos para la familia Clips
| Datos    | Tipo      | Descripción | Requerido  |
| :-- | :-- | :-- | :--: |
| Tipo | enumerado: Clip, Precinto | Es el tipo de material. | Sí |
| Largo | numérico, 2 decimales | Es el largo en mm. | Sí |
| Ancho | numérico, 2 decimales | Es el ancho en mm. | Sí |
| Diámetro del Orificio | numérico, 2 decimales | Es una cantidad en mm. | Sí |



