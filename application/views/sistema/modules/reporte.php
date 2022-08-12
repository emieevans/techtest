<div class="row">
	<div class="col-sm-12">
	<br>
	<h1>Reporte</h1>
	<hr>
	<a href="<?php echo base_url(); ?>" class="btn btn-secondary">Inicio</a>
	<a href="<?php echo base_url().'sistema/categorias'; ?>" class="btn btn-secondary">Categorías</a>
	<a href="<?php echo base_url().'sistema/marcas'; ?>" class="btn btn-secondary">Marcas</a>
	<a href="<?php echo base_url().'sistema/productos'; ?>" class="btn btn-secondary">Productos</a>
	<a href="<?php echo base_url().'sistema/reporte'; ?>" class="btn btn-success">Reporte</a>
	<hr>
	</div>
	
	<div class="col-sm-12">
	<form action="" method="post">
	<div class="row">
	
	<div class="col-sm-5">
		<label>Marca</label>
		<select name="Marca" id="Marca" class="form-control">
		<option value="">--- Seleccione ---</option>
		<?php foreach($listamarcas as $lm) { ?>
		<option value="<?php echo $lm['Id']; ?>" <?php if($Marca == $lm['Id']) { echo 'selected'; } ?>><?php echo $lm['Marca']; ?></option>
		<?php } ?>
		</select>
	</div>
	
	<div class="col-sm-5">
		<label>Categoría</label>
		<select name="Categoria" id="Categoria" class="form-control">
		<option value="">--- Seleccione ---</option>
		<?php foreach($listacategorias as $lc) { ?>
		<option value="<?php echo $lc['Id']; ?>" <?php if($Categoria == $lc['Id']) { echo 'selected'; } ?>><?php echo $lc['Categoria']; ?></option>
		<?php } ?>
		</select>
	</div>
	<div class="col-sm-2">
	<br>
	<input type="submit" class="btn btn-success" value="Generar Reporte"/>
	</div>
	</div>
	</form>
	
	</div>
	
	<div class="col-sm-12">
	<?php if($encontrado >= 1) { ?>
	
	<form action="<?php echo base_url().'sistema/excel'; ?>" method="post" target="_blank">
		<input type="hidden" name="Marca" value="<?php echo $Marca; ?>">
		<input type="hidden" name="Categoria" value="<?php echo $Categoria; ?>">
		<input type="submit" class="btn btn-secondary" value="Exportar Excel">
	</form>
	
		<table class="table table-striped " id="datatable">
			<thead>
				<th style="text-align: center;">CódigoBarras</th>
				<th style="text-align: center;">Producto</th>
				<th style="text-align: center;">Marca</th>
				<th style="text-align: center;">Categoría</th>
				<th style="text-align: center;">Precio</th>
				<th style="text-align: center;">Cantidad</th>
				<th style="text-align: center;">Fecha Expiración</th>
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
				</tr>
				<?php } ?>
			</tbody>
		</table>	
		<?php } else { ?>
		<h5>No se pudo encontrar ningún resultado...</h5>
		<?php } ?>
	</div>

</div>