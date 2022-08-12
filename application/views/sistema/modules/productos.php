<div class="row">
	<div class="col-sm-12">
	<br>
	<h1>Productos</h1>
	<hr>
	<a href="<?php echo base_url(); ?>" class="btn btn-secondary">Inicio</a>
	<a href="<?php echo base_url().'sistema/categorias'; ?>" class="btn btn-secondary">Categorías</a>
	<a href="<?php echo base_url().'sistema/marcas'; ?>" class="btn btn-secondary">Marcas</a>
	<a href="<?php echo base_url().'sistema/productos'; ?>" class="btn btn-success">Productos</a>
	<a href="<?php echo base_url().'sistema/reporte'; ?>" class="btn btn-secondary">Reporte</a>
	<hr>
	</div>
	
	<div class="col-sm-12">
	
	<form action="" method="post">
		<div class="input-group mb-3">
		  <span class="input-group-text"><i class="fa fa-barcode"></i></span>
		  <input type="text" name="CodigoBarras" value="<?php echo $codigo; ?>" class="form-control" placeholder="Codigo Barras">
		  <input type="submit" class="btn btn-success" value="Buscar">
		</div>
	</form>
	
	<!--Si no se encuentra registrado el código de barras, se muestra el botón-->
	<?php if($encontrado == 0) { ?>
	<hr><a href="javascript:void(0);" onclick="Agregar();" class="btn btn-success">Agregar Producto</a><hr>
	<?php } ?>
	
		<table class="table table-striped " id="datatable">
			<thead>
				<th style="text-align: center;">CodigoBarras</th>
				<th style="text-align: center;">Producto</th>
				<th style="text-align: center;">Marca</th>
				<th style="text-align: center;">Categoría</th>
				<th style="text-align: center;">Precio</th>
				<th style="text-align: center;">Cantidad</th>
				<th style="text-align: center;">Fecha Expiración</th>
				<th style="text-align: center;" width="140">Acción</th>
			</thead>
			<tbody>
			<?php foreach($listaproductos as $producto) { ?>
				<tr class="<?php if($producto['FechaExpiracion'] <= date('Y-m-d')) { echo 'bg-warning'; } ?>">
					<td style="text-align: center;"><?php echo $producto['CodigoBarras']; ?></td>
					<td style="text-align: center;"><?php echo $producto['Nombre']; ?></td>
					<td style="text-align: center;"><?php echo $producto['NombreMarca']; ?></td>
					<td style="text-align: center;"><?php echo $producto['NombreCategoria']; ?></td>
					<td style="text-align: center;">$ <?php echo number_format($producto['Precio'],2,',','.'); ?></td>
					<td style="text-align: center;"><?php echo $producto['Cantidad']; ?></td>
					<td style="text-align: center;"><?php echo date("d-m-Y", strtotime($producto['FechaExpiracion'])); ?></td>
					<td style="text-align: center;" width="140"><?php if ($producto['Id'] > 0) { ?><a title="Editar" href="javascript:void(0);" onclick="Editar('<?php echo $producto['Id']; ?>');" class="btn btn-primary btn-sm">Editar</a> <a title="Eliminar" href="javascript:void(0);" onclick="Delete('<?php echo $producto['Id']; ?>');" class="btn btn-danger btn-sm">Eliminar</a><?php } else { ?><a class='btn btn-success'>Agregar</a><?php } ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	
	<div id="form_producto" style="display: none;">
	<form action="<?php echo $formulario; ?>" name="productos" method="post" class="form-horizontal">
	<input type="hidden" name="Id" id="Id">
	<input type="hidden" name="Action" id="Action">
	
	<div class="row">
	
	<div class="col-sm-6">
	<label>Código de Barras</label>
	<input type="text" maxlength="80" id="CodigoBarras" class="form-control" value="<?php echo $data['CodigoBarras']; ?>" name="CodigoBarras" onblur="Verificar();" required=""/>
	<span id="Error" style="display: none;color: red;">El Código de Barras ingresado ya se encuentra registrado.</span>
	<br>
	</div>
	
	<div class="col-sm-6">
	<label>Nombre del Producto</label>
	<input type="text" maxlength="80" id="Nombre" class="form-control" value="<?php echo $data['Nombre']; ?>" name="Nombre" required=""/>
	<br>
	</div>
	
	<div class="col-sm-6">
	<label>Marca</label>
	<select name="Marca" id="Marca" class="form-control" required="">
	<option value="">--- Seleccione ---</option>
	<?php foreach($listamarcas as $lm) { ?>
	<option value="<?php echo $lm['Id']; ?>"><?php echo $lm['Marca']; ?></option>
	<?php } ?>
	</select>
	<br>
	</div>
	
	<div class="col-sm-6">
	<label>Categoría</label>
	<select name="Categoria" id="Categoria" class="form-control" required="">
	<option value="">--- Seleccione ---</option>
	<?php foreach($listacategorias as $lc) { ?>
	<option value="<?php echo $lc['Id']; ?>"><?php echo $lc['Categoria']; ?></option>
	<?php } ?>
	</select>
	<br>
	</div>
	
	<div class="col-sm-3">
	<label>Precio</label>
	<input type="text" id="Precio" class="form-control" value="<?php echo $data['Precio']; ?>" name="Precio" required=""/>
	<br>
	</div>
	
	<div class="col-sm-3">
	<label>Cantidad</label>
	<input type="number" min="0" id="Cantidad" class="form-control" value="<?php echo $data['Cantidad']; ?>" name="Cantidad" required=""/>
	<br>
	</div>
	
	<div class="col-sm-3">
	<label>Imagen</label>
	<input type="file" id="Image" class="form-control" name="Image"/>
	<br>
	</div>
	
	<div class="col-sm-3">
	<label>Fecha Expiración</label>
	<input type="date" id="FechaExpiracion" class="form-control" value="<?php echo $data['FechaExpiracion']; ?>" name="FechaExpiracion" required=""/>
	<br>
	</div>
	
	<div class="col-sm-12">
	<a href="<?php echo base_url().'sistema/productos'; ?>" class="btn btn-lg btn-warning">Cancelar</a>
	<input type="submit" value="Guardar" id="Guardar" class="btn btn-lg btn-secondary">
	</div>
	
	</div>
	
	</form>
	</div>
	
</div>
<script>
	$(document).ready(function () {
    	$('#datatable').DataTable({searching: false});
	});
	
	$('#Precio').mask('###0.00', {reverse: true});
	
	function Agregar() {
		$("#Action").val('agregar');
		document.getElementById("CodigoBarras").readOnly = false;
		$('#form_producto').show();
	}
	
	function Editar(Id) {
		$.post( "<?php echo base_url().'sistema/get_producto'; ?>", { Id: Id }, function( data ) {
		 if(data.status == 'success') {
		 	$("#Action").val('editar');
		 	$("#Id").val(data.Id);
		 	$("#Nombre").val(data.Nombre);
		 	$("#CodigoBarras").val(data.CodigoBarras);
		 	$("#Marca").val(data.Marca);
		 	$("#Categoria").val(data.Categoria);
		 	$("#Precio").val(data.Precio);
		 	$("#Cantidad").val(data.Cantidad);
		 	$("#FechaExpiracion").val(data.FechaExpiracion);
		 	$('#form_producto').show();
		 	document.getElementById("CodigoBarras").readOnly = true;
		 }
		}, "json");
	}
	
	function Verificar() {
		var CodigoBarras = $("#CodigoBarras").val();
		$.post( "<?php echo base_url().'sistema/verificar_codigo'; ?>", { Codigo: CodigoBarras }, function( data ) {
		 if(data.status == 'existe') {
		 	$("#Guardar").prop("disabled",true);
		 	$("#Error").show();
		 } else {
		 	$("#Guardar").prop("disabled",false);
		 	$("#Error").hide();
		 }
		}, "json");
	}
	
	function Delete(Id) {
		Swal.fire({
		  title: '¿Eliminar el registro?',
		  text: 'Este registro se eliminará de forma permanente',
		  showDenyButton: true,
		  showCancelButton: false,
		  confirmButtonText: 'Si',
		  denyButtonText: 'No',
		}).then((result) => {
		  if (result.isConfirmed) {
		    Eliminar(Id);
		  } else if (result.isDenied) {
		    Swal.fire('La operación fue cancelada exitosamente', '', 'info')
		  }
		});
	}
	
	function Eliminar(Id) {
		$.post( "<?php echo base_url().'sistema/del_producto'; ?>", { Id: Id }, function( data ) {
		 if(data.status == 'success') {
		 	Swal.fire('¡Registro eliminado con éxito!', '', 'success');
		 	setTimeout(function(){
			    location.reload(true);
			}, 3000);
		 }
		}, "json");
	}
	
	
</script>