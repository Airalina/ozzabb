<a name='proveedores'></a>

# Proveedores

  - [Proveedores](#proveedores)
  - [Requerimiento del Negocio](#requerimiento-del-negocio)
  - [Datos de Proveedor](#datos-de-proveedor)
  - [Lista de Precios](#lista-de-precios)
  - [Historial de Precios del Proveedor](#historial-de-precios-del-proveedor)
  - [Misceláneos](#misceláneos)

<a name='requerimiento-del-negocio'></a>

## Requerimiento del Negocio

 Como usuario del sistema debo poder registrar los proveedores de materiales a quienes realizo pedidos para mantener el stock de materiales al día, las presentaciones y precios de los  productos que vende y los precios a los que los vendía en el pasado.Además debo poder subir algunas fotos asociadas al proveedor.

<a name='datos-de-proveedor'></a>

## Datos de Proveedor

- Para cada Proveedor necesito poder registrar los siguientes datos:
  
  | Dato                 | Requerido |
  | :--                  | :--: |
  | Nombre de la empresa | Sí |
  | Domicilio            | Sí |
  | Teléfono             | No |
  | Correo electrónico para ventas | Sí |
  | Nombre de Contacto en la empresa | No |
  | Puesto de Contacto en la empresa | No |
  | Página Web | No |
  | Estado | Sí (Activo, Inactivo) |

- Debo poder ver primero una lista de los proveedores con los que trabajo actualmente.
- La lista debe estar ordenada alfabéticamente.
- La lista se puede ordenar por todas las columnas.
- Debo poder buscar en la lista de proveedores escribiendo un texto.

<a name='lista-de-precios'></a>

## Lista de Precios
- Para cada proveedor necesito acceder a su lista de precios.
- La lista de precios muestra los materiales que provee el proveedor y sus precios.
- Para cada presentación diferente del mismo material, se debe poder registrar su precio.
  
  
- Los datos a registrar en la lista de precios son los siguientes:

| Dato | Requerido |
| :--  | :--:      |
| Código de Material | Sí|
| Nombre | Sí |
| Cantidad | Sí |
| Unidad de presentación | Sí (milímetros, unidades, cajas) |
| Precio U$D| Sí |
| Precio AR$| Se calcula según valor del dólar en el sistema|

- Desde el perfil de un proveedor tengo que poder agregar rápidamente un nuevo material para agregar a la lista de precios.

<a name='historial-de-precios-del-proveedor'></a>

### Historial de Precios del Proveedor
- Debo poder ver los precios de los materiales provistos por el proveedor en el pasado.
- Los datos a mostrar en el el historial de precios son los siguientes:

| Dato | 
| :--  |
| Fecha |
| Código de Material |
| Nombre |
| Precio en U$D |

<a name='misceláneos'></a>
## Misceláneos
  
- Para cada proveedor debo poder guardar fotos y poder verlas en el perfil del proveedor en estilo carrusel.
- Debo poder dar de baja a un proveedor para que no se puedan realizar más compras, pero deseo pode seguir viendo sus datos históricos de precios y compras que le realizamos.
  
  