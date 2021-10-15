<a name="reserva-de-materiales"></a>

# Reserva de Materiales

<a name="requerimiento-del-negocio"></a>

## Requerimiento del Negocio

El proceso de reserva de materiales es un proceso automático que debe hacer el el sistema y que se realiza cuando una Orden de Trabajo pasa a ser la orden Actual.

Una orden de trabajo tiene una lista de materiales necesarios para poder crear los productos pedidos por los clientes en los pedidos que se incluyeron en la orden de trabajo.

Esa lista de materiales necesarios se tomará de depósitos de tipo almacén y/o producción según lo instruya el usuario al pasar la orden al estado "Actual".

El sistema tomará nota de ellos y guardará esa información en la lista de materiales reservados par la orden de trabajo actual. 

La lista de materiales reservados tendrá los siguientes datos:

| Dato | Descripción |
|:-- |:-- |
| Código de Material | Es el código interno del material. |
| Id de depósito | Es el id del depósito del que se reserva el material. |
| Presentación | Es la cantidad de unidades que vienen en la presentación reservada. |
| Cantidad de unidades | Es la cantidad de unidades reservadas del material. Si la presentación es mayor a 1, es la cantidad de paquetes de tamaño presentación que se reservan. |
| Fecha de reserva | Es la fecha en la que reservó el material. |



<a name="donde-se-vera-cantidad-de-unidades-reservadas"></a>

## Dónde se verá la cantidad de unidades reservadas

La cantidad de unidades reservadas de un material se obtendrá por la fórmula Presentación * Cantidad de unidades y se verá en dos lugares dentro del sistema.

1) En la lista de materiales depositados dentro de la vista de un depósito: 
   Para cada material que tenga una cantidad reservada mayor a 0 en ese depósito, se mostrará la información junto a la cantidad total de unidades almacenadas en el depósito. 
   
2) Junto a la columna stock en planta de la vista de datos de un material: En el caso de haber cantidades reservadas de un mismo material en más de un depósito, se mostrará la suma de las unidades reservadas.

3) En la vista de Planilla de Compras: En la columna Stock se muestra la cantidad disponible de un material. Esta cantidad es el total de unidades disponibles del material, restando la cantidad de unidades reservadas para el material. El primer valor viene de la entidad material y la segunda es la suma de las unidades reservadas del material para todos los depósitos.
   
<a name="cantidad-reservada-en-planila-de-compras"></a>

## Cantidad reservada en la Planilla de Compras

La cantidad reservada, también jugará un papel importante en la planilla de compras, ya que la columna stock que se ve en la lista de materiales de la planilla, se deberá restar la cantidad total de unidades reservadas para el material relacionado.

Esto se debe a que en la decisión de compra se debe tener en cuenta solo el material no comprometido para los pedidos que están siendo producidos en el presente.





















