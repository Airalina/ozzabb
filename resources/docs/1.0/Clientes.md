
   - [Clientes](#clientes)
   - [Requerimiento del Negocio](#requerimiento-del-negocio)
   - [Datos de Clientes](#datos-de-clientes)
   - [Domicilios de Entrega](#domicilios-de-entrega)
   - [Historial de Pedidos](#historial-de-pedidos)

<a name='clientes'></a>

# Clientes

<a name='requerimiento-del-negocio'></a>

## Requerimiento del Negocio

<p style='text-style : justify;'>
Como usuario del sistema debo poder registrar los datos de los clientes que realizan pedidos a nuestra empresa.

En general nuestros clientes son otras empresas que utilizan nuestros productos para integrarlos en los suyos propios.

Las direcciones de los envíos pueden diferir de la dirección de las  oficinas de la empresa.
</p>

<a name='datos-de-clientes'></a>

## Datos de Clientes

De los Clientes de la empresa debo poder registrar los siguientes datos:

| Dato                     | Descripción                                                        |
| :------                  | :------------                                                      |
| Nombre                   | Es la razón social de la empresa cliente.                          |
| Correo Electrónico       | Dirección de correo para comunicaciones con el cliente.            |
| Domicilio administrativo | Domicilio para trámites administrativos.                           |
| Estado                   | Activo, Inactivo, Se utiliza para saber cuáles están en actividad. |
| Contacto                 | Nombre y Apellido de la persona de contacto en la empresa.         |
| Cargo del Contacto       | Cargo que el contacto ocupa en la empresa.                         |


<a name ='domicilios-de-entrega'></a>

## Domicilios de Entrega

Son los domicilios a los cuales se despachan los envíos de nuestros productos cuando estén terminados los pedidos del cliente.

Para cada domicilio de entrega se deben registrar los siguientes datos:

| Domicilio de Entrega     | Requerido |
| :-----                   | :--       |
| Calle                    | Sí        |
| Número                   | Sí        |
| Localidad                | Sí        |
| Provincia                | Sí        |
| País                     | Sí        |
| Código Postal            | Sí        |  
| Descripción General      | No        |

Se registran junto al cliente, pero pueden agregarse nuevos en cada envío.


<a name='historial-de-pedidos'></a>

## Historial de Pedidos

Para cada cliente debo poder ver sus datos, editarlos y también poder ver una lista de los últimos 10 pedidos que nos hayan realizado.

Para la lista de pedidos se mostrarán los siguientes datos.

| Dato                | Descripción                                    |
| :---                | :------------------------                      |
| Nro. de Pedido      | Es el nro. interno de pedido.                  |
| Fecha de Pedido     | Es la fecha en la que se anotó el pedido.      |
| Fecha de Entrega    | Es la fecha pactada de entrega.                |
| Fecha de Inicio     | Fecha de inicio de la producción del pedido.   |
| Estado              | Estado del pedido.                             |
| Precio Total en U$D | Precio total del pedido en dólares.            |

Debo poder ingresar al detalle de un pedido de cliente desde el historial de pedidos.






















