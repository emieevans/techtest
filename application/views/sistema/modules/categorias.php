<div class="row">
	<div class="col-sm-12">
	<br>
	<h1>Categorías</h1>
	<hr>
	<a href="<?php echo base_url(); ?>" class="btn btn-secondary">Inicio</a>
	<a href="<?php echo base_url().'sistema/categorias'; ?>" class="btn btn-success">Categorías</a>
	<a href="<?php echo base_url().'sistema/marcas'; ?>" class="btn btn-secondary">Marcas</a>
	<a href="<?php echo base_url().'sistema/productos'; ?>" class="btn btn-secondary">Productos</a>
	<a href="<?php echo base_url().'sistema/reporte'; ?>" class="btn btn-secondary">Reporte</a>
	<hr>
	</div>
	
	<div class="col-sm-12">
	<a href="javascript:void(0);" onclick="Agregar();" class="btn btn-success">Agregar Categoria</a><hr>
	
		<table class="table table-striped" id="datatable">
			<thead>
				<th style="text-align: center;">#</th>
				<th style="text-align: center;">Categoría</th>
				<th style="text-align: center;" width="140">Acción</th>
			</thead>
			<tbody>
			<?php foreach($listacategorias as $categoria) { ?>
				<tr>
					<td style="text-align: center;"><?php echo $categoria['Id']; ?></td>
					<td style="text-align: center;"><?php echo $categoria['Categoria']; ?></td>
					<td style="text-align: center;" width="140"><?php if ($categoria['Id'] > 0) { ?><a title="Editar" onclick="Editar('<?php echo $categoria['Id']; ?>');" class="btn btn-primary btn-sm">Editar</a> <a onclick="Delete('<?php echo $categoria['Id']; ?>');" title="Eliminar" href="javascript:void(0);" class="btn btn-danger btn-sm">Eliminar</a><?php } else { ?> <a class='btn btn-success'>Agregar</a><?php } ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div id="form_categoria" style="display: none;">
	<form action="<?php echo $formulario; ?>" name="categorias" method="post" class="form-horizontal">
	<input type="hidden" name="Id" id="Id">
	<input type="hidden" name="Action" id="Action">
	
	<div class="row">
	<div class="col-sm-6">
	
	<label>Categoría</label>
	<input type="text" maxlength="80" id="Categoria" class="form-control" value="<?php echo $data['Categoria']; ?>" name="Categoria" required=""/>
	<br>
	</div>
	
	<div class="col-sm-12">
	<a href="<?php echo base_url().'sistema/categorias'; ?>" class="btn btn-lg btn-warning">Cancelar</a>
	<input type="submit" value="Guardar" class="btn btn-lg btn-secondary">
	</div>
	
	</div>
	
	</form>
	</div>
</div>
<script>

	$(document).ready(function () {
    	$('#datatable').DataTable();
	});
	
	function Agregar() {
		$("#Action").val('agregar');
		$('#form_categoria').show();
	}
	
	function Editar(Id) {
		$.post( "<?php echo base_url().'sistema/get_categoria'; ?>", { Id: Id }, function( data ) {
		 if(data.status == 'success') {
		 	$("#Action").val('editar');
		 	$("#Id").val(data.Id);
		 	$("#Categoria").val(data.Categoria);
		 	$('#form_categoria').show();
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
		$.post( "<?php echo base_url().'sistema/del_categoria'; ?>", { Id: Id }, function( data ) {
		 if(data.status == 'success') {
		 	Swal.fire('¡Registro eliminado con éxito!', '', 'success');
		 	setTimeout(function(){
			    location.reload(true);
			}, 3000);
		 }
		}, "json");
	}
	
</script>