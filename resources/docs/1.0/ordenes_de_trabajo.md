- [Ordenes de Trabajo](#ordenes-de-trabajo)
  - [Requerimiento de Negocio](#requerimiento-de-negocio)
  - [Lo que el sistema deberá implementar](#lo-que-el-sistema-deberá-implementar)
  
<a name="ordenes-de-trabajo"></a>

# Ordenes de Trabajo

<a name="requerimiento-de-negocio"></a>

## Requerimiento de Negocio

Como empleado de la empresa a cargo de armar la planificación de trabajo para la línea de producción, debo poder confeccionar una Orden de Trabajo.

Una Orden de Trabajo, consiste principalmente de una lista de **Pedidos de Clientes** que se tienen que ensamblar en la línea de producción.

Típicamente se confecciona una orden de trabajo por mes y en ella se incluyen tantos pedidos de clientes como sea posible construir en las horas hombre que tenemos disponibles para el mes que estamos planificando. 

En general se empieza a trabajar en la siguiente Orden de Trabajo mientras en la línea de producción se está trabajando con la anterior.

Los pedidos de cliente que se priorizan según la fecha de entrega acordada con el cliente para ser incluidos en la orden de trabajo del mes que nos permita tenerlo terminado a tiempo para que los envíos se realicen de tal manera que se pueda cumplir con la fecha de entrega pactada.

Es posible que la cantidad de horas/ hombre necesarias para completar todos los pedidos comprometidos para un mes en particular, exceda la cantidad de horas disponible, por lo que es posible que algunos pedidos sean demorados o se implementen procedimientos para aumentar la cantidad de horas disponibles hasta que se termine con esos pedidos.

Junto con la lista de pedidos, la orden de trabajo tendrá una **Lista de Materiales** y sus cantidades necesarias para completar los pedidos incluidos en la misma. Al comenzar a confeccionar la orden de trabajo puede ser posible que nos demos cuenta de que no tenemos suficientes materiales en depósito, por lo que es posible que se re planifiquen las fechas de entrega de algunos pedidos o se realicen compras de los materiales y cantidades faltantes. Esto dependerá de la fecha en la que estemos confeccionando la orden de trabajo y los tiempos de entrega de los proveedores.

Para cada material en la Lista de Materiales, anotaremos las cantidades que tomaremos de cada depósito disponible, hasta sumar la cantidad necesaria.

Una vez que tenemos los materiales completos, podremos agregar una **lista de Productos Ensamblados** que tengamos en depósito y que se pueden utilizar para la confección de los productos pedidos, ej. cables cortados o algunos materiales, que ya han sido ensamblados previamente, pero no se ha logrado crear un producto final con ellos porque se canceló un pedido de cliente cuando ya estaba la línea de producción trabajando en él.

Una vez que tengamos todo el trabajo hecho, se puede grabar al orden de Trabajo que se confecciona con una fecha estimada de inicio y otra de finalización. 

Cuando se envía una orden de trabajo a la línea de producción, esta se pasa a **estado "Actual"**, se anota la **fecha de inicio real** y se imprime su información para que la tenga disponible en encargado de producción, quien controlará cómo se va desarrollando el trabajo.

Cuando se pasa una orden de trabajo al estado "Actual", se realizará el proceso de **"Reserva de Materiales"**, el cuál consiste en retirar de los depósitos mencionados en la orden de trabajo, los materiales correspondientes. Para el proceso de reserva de materiales se confeccionarán las correspondientes órdenes de retiro de materiales en las que se anotará como **destino "Línea de Producción"**. 

Los productos ensamblados y productos terminados (mazos) que se vayan creando durante el trabajo en la línea de producción, se irán ingresando a depósito, con referencia al pedido de cliente al que pertenecen.

Al terminarse de producir los pedidos incluidos en la Orden de Trabajo, se anota la fecha de finalización real y se pasa la ordena a **estado "Finalizada"**. Las ordenes que se hayan confeccionado previamente se pueden borrar y se pasarán a **estado "Rechazada"**.

Durante la vigencia de una orden de trabajo será posible que los **pedidos que no se hayan completado sean cancelados**. Al cancelar un pedido se deben anotar los productos ensamblados y los productos terminados que se generaron. El pedido se pasará a estado "Cancelado" y la orden de trabajo a estado "Con pedidos cancelados". **Es posible que una orden de trabajo esté en los estados "Finalizada" y "Con pedidos cancelados"**. 

Al cancelarse un pedido de una Orden de Trabajo en estado "Actual", se deberá devolver a depósito los materiales que se habían reservado para ese pedido, restando los materiales utilizados en los productos ensamblados y terminados que se hayan logrado producir. Para la **devolución de materiales** se confeccionarán las respectivas **Ordenes de Ingreso de Materiales**. Los materiales se devuelven a los depósitos de los cuales fueron tomados.

<a name="lo-que-el-sistema-debera-implementar"></a>

## Lo que el sistema deberá implementar

El sistema deberá permitirme crear, modificar y administrar la lista de Ordenes de Trabajo que existan en el sistema. Debo poder verlas sin importar su estado, pudiendo buscar por todos los campos de datos de las órdenes y filtrarlas por estado y rango de fechas. Además, permitirá que vea la orden de trabajo actual, la que se destacará del resto de la lista.

Para las órdenes de trabajo que estén en estado "Cancelada", "Con pedidos cancelados" y "Finalizada" debo poder ver los retiros e ingresos de materiales, ensamblados y productos terminados que se fueron anotando relacionados a la misma, de forma ordenada por fecha y hora en una sección que se llamará "Eventos".

Al crear o editar una orden de trabajo, que no esté en estado "Actual", el sistema llenará automáticamente la lista de materiales necesarios de forma totalizada para los pedidos de clientes incluidos y permitirá que el usuario escoja entre dos opciones para la elección de los depósitos de donde se tomarán los materiales. Las opciones son "Normal" y "Equilibrada". Esta opción puede ser cambiada al momento de pasar la orden a estado "Actual".

Cuando una orden de trabajo se pasa a estado "Actual", el sistema propondrá las cantidades a retirar de los depósitos donde un material esté disponible según el usuario haya optado al confeccionarla de la siguiente manera:

| Opción  | Acción |
| :-- | :-- |
| Normal | Se tomarán todos los materiales del depósito con la mayor cantidad del material mencionado, si fuera posible. Si no, se completará con la cantidad restante del segundo depósito con mayor cantidad del material y así sucesivamente. |
| Equilibrada | Se tomará la misma cantidad de material de cada depósito que lo contenga, de ser posible. |

 - Esta información puede ser cambiada por el usuario. 

Al cambiar el estado de una orden de trabajo a "Actual" y grabarla, el sistema generará la lista de ordenes de retiro para realizar la reserva de materiales. 





 








