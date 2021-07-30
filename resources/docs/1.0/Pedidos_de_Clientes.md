<a name='pedidos-de-clientes'></a>

 - [Pedidos de Clientes](#pedidos-de-clientes)
 - [Requerimiento del Negocio](#requerimiento-del-negocio)
 - [Datos de un Pedido de Cliente](#datos-de-un-pedido-de-cliente)
 - [Lista de Productos](#lista-de-productos)
 - [Domicilio de Entrega](#domicilio-de-entrega)
 - [Listado de Pedidos](#listado-de-pedidos)

<a name='pedidos-de-clientes'></a>

# Pedidos de Clientes

<a name='requerimiento-del-negocio'></a>

## Requerimiento del Negocio

<p style='text-align: justify;'>
 Como empleado de la empresa, a cargo de pedidos, debo poder registrar los pedidos de nuestros clientes.

 Los pedidos de clientes nos dicen qué es lo que estaremos construyendo en las líneas de producción y cuándo el cliente necesita los productos terminados que ha pedido.

 </p>
<p style='text-align: justify;'>
 Un pedido incluye una lista de productos y cantidades que el cliente nos ha pedido le enviemos.

 Los pedidos se comprometen para una fecha de entrega.  
</p>
<p style='text-align: justify;'>
 Debo poder ver los pedidos que están empezados y cuáles tengo comprometidos para los meses siguientes, cuáles están terminados y cuáles y cuándo fueron enviados a los clientes.
</p>
<p style='text-align: justify;'>
 Los Clientes pueden realizarnos pedidos por varias vías, teléfono, correo electrónico o mensajes de WhatsApp.
</p> 

<a name='datos-de-un-pedido-de-cliente'></a>

## Datos de un Pedido de Cliente

Los pedidos de clientes tienen los siguientes datos:

| Dato                | Descripción                                                            | Requerido / Default |
| :--------           | :---------------------------                                           | :----:              |
| Nro. de Pedido      | Es el nro. interno de pedido. nro. correlativo/ año (YYYY).            | Auto                | 
| Código de Cliente   | Es el código interno de la compañía asigno al cliente.                 |    Sí               |
| Nombre del Cliente  | Es el nombre del cliente según está en su registro.                    | Auto                |
| Fecha de Entrega    | Fecha en la que se deberá entregar el pedido de ser producido.         | Sí                  |
| Estado              | Nuevo, Confirmado, Rechazado, Demorado, En producción, En Depósito.    | Sí: Nuevo           |
| Compras             | Nos dice si el pedido fue utilizado para generar ordenes de compra de materiales| No | 
| Fecha de Inicio     | Es la fecha en que entró en producción.                                | No                  |
| Orden de trabajo    | Nro. de la orden de trabajo en la que se incluyó este pedido.          | No                  |
| Precio Total U$D    | Calculado de la lista de productos incluidos en el pedido.             | Auto                |
| Precio Total AR$    | Calculado de Precio Total en U$D y valor del dólar en el sistema.      | Auto                | 


<a name='lista-de-productos'></a>

## Lista de Productos (Instalaciones)

Es la lista de los Productos que el cliente solicitó en su pedido. 

La lista de productos debe tener los siguientes datos:

| Dato                   |  Descripción                                         |
| :-----                 | :-------                                             |
| Código de Producto     | Es el código interno de la empresa para el producto. |
| Cantidad               | 
| Precio Unitario en U$D |


<a name='domicilio-de-entrega'></a>

## Domicilio de Entrega

Para cada envío se debe especificar un domicilio de entrega de la lista de domicilios de entrega del cliente.

Se debe poder agregar uno nuevo al crear el pedido.

Se puede registrar un domicilio diferente al realizar el envío del pedido.

Los domicilios previamente utilizados para un cliente, deben estar disponibles para utilizarse en nuevos pedidos.

<a name='listado-de-pedidos'></a>

## Listado de Pedidos

En el sistema debo poder ver un listado de los pedidos que están registrados en el sistema.

La lista de pedidos mostrará los siguientes datos:

| Dato                | Descripción                                                            | 
| :--------           | :---------------------------                                           |
| Nro. de Pedido      | Es el nro. interno de pedido. nro. correlativo/ año (YYYY).            | 
| Código de Cliente   | Es el código interno de la compañía asigno al cliente.                 | 
| Nombre del Cliente  | Es el nombre del cliente según está en su registro.                    | 
| Fecha de Entrega    | Fecha en la que se deberá entregar el pedido de ser producido.         | 
| Estado              | Nuevo, Confirmado, Rechazado, Demorado, En producción, En Depósito.    | 
| Depósito            | Nombre del depósito en el que se encuentra el pedido.                  | 
| Fecha de Inicio     | Es la fecha en que entró en producción.                                | 
| Orden de trabajo    | Nro. de la orden de trabajo en la que se incluyó este pedido.          | 
| Precio Total U$D    | Calculado de la lista de productos incluidos en el pedido.             | 
| Precio Total AR$    | Calculado de Precio Total en U$D y valor del dólar en el sistema.      | 

La lista de Pedidos se debe poder ordenar por todas su columnas y debo poder buscar en ella escribiendo texto.








