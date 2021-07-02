<div id="formulario_create">
		<div id="cont-name">
			<label>Nombre Usuario</label>  
			<input id="name" wire:model="name" type="text" placeholder="Nombre Usuario" />		
		</div>  
		<div id="cont-nya">
			<label>Nombre y Apellido</label>  
			<input id="nombre_y_apellido" wire:model="nombre_y_apellido" type="text" maxlength="200" placeholder="Nombre Y Apellido" />		
		</div>
		<div id="cont-dni">
			<label>D.N.I.</label>  
			<input id="dni" wire:model="dni" type="text" maxlength="15" placeholder="DNI" />		
		</div> 
		<div id="cont-domi">
			<label>Domicilio</label>  
			<input id="domicilio" wire:model="domicilio" type="text" maxlength="250" placeholder="Domicilio" />		
		</div> 
		<div id="cont-mail">
			<label>Email</label>  
			<input id="email" wire:model="email" type="text" placeholder="Email" />		
		</div> 
		<div id="cont-tel">
			<label>Telefono</label>  
			<input id="telefono" wire:model="telefono" type="text" placeholder="Telefono" />		
		</div>
		  
    </div>
    