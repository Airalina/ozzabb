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

En general se empieza a confeccionar la siguiente Orden de Trabajo mientras en la línea de producción se está trabajando con la anterior.

Los pedidos que se incluyen en una orden de trabajo serán los que tengan las fechas de entrega pactadas más cercanas a la fecha de confección de la orden de trabajo, pero es el usuario quien los va ingresando al seleccionarlos de la lista de Pedidos de Clientes en estados distintos de rechazado.

Es posible que la cantidad de horas/ hombre necesarias para completar todos los pedidos comprometidos para un mes en particular, exceda la cantidad de horas disponible, por lo que es posible que algunos pedidos sean demorados o se implementen procedimientos para aumentar la cantidad de horas disponibles hasta que se termine con esos pedidos.

Para calcular las horas/hombre necesarias para crear los productos de un pedido, partiremos de la información cargada para cada instalación en la que tendremos una lista de pasos de construcción y la cantidad de horas/hombre que lleva cada paso. Para un pedido la cantidad de horas/hombre se calcula sumando la cantidad de horas necesarias para construir cada tipo de instalación incluida * la cantidad de unidades de la instalación pedida. 

Junto con la lista de pedidos, la orden de trabajo tendrá una **Lista de Materiales** y sus cantidades necesarias para completar los pedidos incluidos en la misma. Si no tenemos suficientes materiales en depósito, algunos pedidos se pueden re-planificar o se realizan compras de los materiales y cantidades faltantes. Esto dependerá de la fecha en la que estemos confeccionando la orden de trabajo y los tiempos de entrega de los proveedores.

La lista de materiales de una orden de trabajo es similar a la que se ve en una planilla de compra de materiales. Podemos ver el stock en planta, la cantidad que esperamos desde nuestros proveedores y la cantidad necesaria para construir los productos pedidos.

Un orden de trabajo se confeccionará para un periodo de trabajo dados por una Fecha de Inicio y una Fecha de Finalización. Y se proveerá la cantidad de horas de trabajo y la cantidad de empleados disponibles durante ese periodo. con esa información se calculará la cantidad de horas/hombre disponible y se podrá realizar al comparación con la cantidad de horas/hombre necesarias.

Una Orden de Trabajo se confecciona para un periodo de tiempo dado por una fecha de inicio y una fecha de finalización. La fecha de finalización se calculará en función de la cantidad de personal disponible, la cantidad de horas por día que trabajarán y la fecha de inicio. En este cálculo hay que hacerlo teniendo en cuenta los días no laborables, domingos, y a días corridos incluyendo domingos.

Una vez que tengamos todo el trabajo hecho, se puede grabar la orden de Trabajo. Las órdenes de trabajo se crean en **estado "Nueva"**, mientras están en estado nueva, se pueden modificar. Este estado es necesario para poder ir adelantando la planificación del próximo periodo de trabajo, mientras se está trabajando en los pedidos de la Orden de Trabajo Actual.

Cuando se envía una orden de trabajo a la línea de producción, esta se pasa a **estado "Actual"**, se anota la **fecha de inicio real** y se imprime su información para que la tenga disponible el encargado de producción, quien controlará cómo se va desarrollando el trabajo.

Cuando se pasa una orden de trabajo al estado "Actual", se realizará el proceso de **"Reserva de Materiales"**, el cuál consiste en descontar las cantidades que se necesitan de cada material del stock de los depósitos de tipo almacén. Como es posible que existan más de un depósito de tipo Almacén y que en ellos el material esté almacenado en diferentes presentaciones, el sistema deberá permitirle al usuario seleccionar los depósitos, presentaciones y cantidades a reservar en cada uno. El usuario ingresará una cantidad de unidades de material a reservar y el sistema debe validar que el valor ingresado sea múltiplo de la presentación seleccionada.

Las cantidades reservadas de materiales para la orden de trabajo actual, afectan los valores de los campos stock en planta de la tabla de materiales y los valores de la columna stock en planta de las planillas de compras que se hagan posteriormente a la reserva.

Los productos ensamblados y productos terminados (mazos) que se vayan creando durante el trabajo en la línea de producción, se irán ingresando a depósito, con referencia al pedido de cliente al que pertenecen.

Al terminarse de producir los pedidos incluidos en la Orden de Trabajo, se anota la fecha de finalización real y se pasa la ordena a **estado "Finalizada"**. 

Durante la vigencia de una orden de trabajo será posible que los **pedidos que no se hayan completado sean cancelados**. Al cancelar un pedido se deben anotar los productos ensamblados y los productos terminados que se generaron. El pedido se pasará a estado "Cancelado" y la orden de trabajo a estado "Con pedidos cancelados". **Es posible que una orden de trabajo esté en los estados "Finalizada" y "Con pedidos cancelados"**. La orden de trabajo Actual, puede tener estado Actual y Con pedidos cancelados.

Cuando se cancela un pedido dentro de una orden de trabajo, la cantidad de materiales que ese pedido necesitaba, se descuentan de la cantidad reservada para el material. La cantidad reservada para un material, se actualiza con cada orden de egreso que creamos con materiales con destino a un depósito de tipo Producción. 

Las cantidades reservadas, si existiera alguna, se dejarán en cero cuando la orden de trabajo actual se termine.

Los materiales que se hayan ingresado en los depósitos de tipo Producción no se devolverán a los depósitos de tipo Almacén desde donde vinieron cuando se termine la orden de trabajo actual o al cancelar pedidos en ella.


<a name="lo-que-el-sistema-debera-implementar"></a>

## Lo que el sistema deberá implementar

El sistema deberá permitirme crear, modificar y administrar la lista de Ordenes de Trabajo que existan en el sistema. Debo poder verlas sin importar su estado, pudiendo buscar por todos los campos de datos de las órdenes y filtrarlas por estado y rango de fechas. Además, permitirá que vea la orden de trabajo actual, la que se destacará del resto de la lista.

Para las órdenes de trabajo que estén en estado "Cancelada", "Con pedidos cancelados" y "Finalizada" debo poder ver los retiros e ingresos de materiales, ensamblados y productos terminados que se fueron anotando relacionados a la misma, de forma ordenada por fecha y hora en una sección que se llamará "Eventos".

Al crear una orden de trabajo el sistema me permitirá elegir los pedidos de clientes que serán incluidos en la misma. Me debe dar la posibilidad de buscar en la lista de los pedidos que no estén en estado cancelado o rechazado. Se puede buscar por código, por estado , por fecha de entrega, etc.

Al seleccionar uno o más pedidos de clientes para confeccionar una orden de trabajo, el sistema mostrará una lista de los materiales necesarios para fabricar las instalaciones que figuran en los pedidos. Por cada material el sistema nos mostrará los siguientes datos:

| Dato | Descripción | Editable |
| :-- | :-- | :--: |
| Código de Material | Código interno del Material. | No |
| Descripción | Campo Descripción del material. | No |
| Stock | Suma de las cantidad de unidades en los depósitos de tipo almacén y producción. | No |
| En tránsito | Suma de la cantidad de unidades en las órdenes de compra en estado "enviada" para este material.| No |
| Necesidad | Es la suma de la cantidad de materiales que se necesitan para fabricar los productos que figuran en los pedidos seleccionados. | No |

Junto a esta información el sistema mostrará un botón llamado "Comprar materiales" que permitirá confeccionar una Planilla de Compras con la información de los pedidos de la orden de trabajo.


Cuando una orden de trabajo se pasa a estado "Actual", el sistema propondrá las cantidades a retirar de los depósitos donde un material esté disponible según el usuario haya optado al confeccionarla de la siguiente manera:

| Opción  | Acción |
| :-- | :-- |
| Normal | Se tomarán todos los materiales del depósito con la mayor cantidad del material mencionado, si fuera posible. Si no, se completará con la cantidad restante del segundo depósito con mayor cantidad del material y así sucesivamente. |
| Equilibrada | Se tomará la misma cantidad de material de cada depósito que lo contenga, de ser posible. |

El usuario podrá modificar la lista de depósitos propuesta y las cantidades de material que se tomarán para construir los productos incluidos en los pedidos de la orden de trabajo. En esta lista de depósitos se pueden seleccionar depósitos de tipo almacén y producción.

Para los depósitos de tipo almacén, se anotarán las cantidades seleccionadas en una lista de materiales reservados para la orden de trabajo actual.

Estás cantidades reservadas tendrán impacto en la cantidad de materiales disponibles en los depósitos para poder hacer retiros no destinados a producción,  en el cálculo de la columna stock de la página de Planilla de Compras y en el formulario de materiales donde se mostrará la cantidad reservada de cada uno junto a las cantidades stock en planta y stock en tránsito. La manera en la que se administrarán las cantidades reservadas se detallarán en un documento específico.

Al cambiar el estado de una orden de trabajo a "Actual" y grabarla, la orden de trabajo se convertirá en la orden con la que se estará trabajando en la línea de producción. Solo puede haber una orden marcada como actual en el sistema.

El sistema tendrá una acceso destacado para ver la orden de trabajo actual.

Para la orden actual o las órdenes de trabajo que fueron la orden de trabajo actual en algún momento, el sistema mostrará una sección con los egresos e ingresos que se anotaron con origen en un depósito de tipo almacén en el que se reservaron materiales y un depósito de tipo producción y junto a ellos mostrará las cantidades reservadas luego del egreso del material del depósito almacén.

El sistema permitirá, desde la vista de la orden actual, agregar ingresos a depósitos de tipo expedición de los productos terminados y a depósitos de tipo ensamblados los productos semiterminados y semiprocesados que se hayan generado en el trabajo de la línea de producción. Esto puede hacer mientras la orden está en estado actual o luego de pasada a terminada. El usuario elegirá el momento que más le convenga para hacerlo.

Los pedidos en producción pueden cancelarse, desde la vista de la orden actual, para lo cual el sistema pedirá al usuario una descripción de la situación que motiva la cancelación y ahí le ofrecerá la oportunidad de anotar los materiales terminados y semiterminados que se hayan producido para ese pedido hasta el momento del avance de la producción.

















 








