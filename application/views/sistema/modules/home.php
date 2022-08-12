<div class="row">
	<div class="col-sm-12">
	<br>
	<h1>Proyecto</h1>
	<hr>
	<a href="<?php echo base_url(); ?>" class="btn btn-success">Inicio</a>
	<a href="<?php echo base_url().'sistema/categorias'; ?>" class="btn btn-secondary">Categorías</a>
	<a href="<?php echo base_url().'sistema/marcas'; ?>" class="btn btn-secondary">Marcas</a>
	<a href="<?php echo base_url().'sistema/productos'; ?>" class="btn btn-secondary">Productos</a>
	<a href="<?php echo base_url().'sistema/reporte'; ?>" class="btn btn-secondary">Reporte</a>
	<hr>
	</div>
	
	<div class="col-sm-6">
		<canvas id="Grafico1" style="width:100%;"></canvas>
	</div>
	<div class="col-sm-6">
		<canvas id="Grafico2" style="width:100%;"></canvas>
	</div>
	<div class="col-sm-12">
		<canvas id="Grafico3" style="width:100%;"></canvas>
	</div>
	
</div>

<script>
var xCategorias = [<?php foreach($listacategorias as $lc) { ?>"<?php echo $lc['Categoria']; ?>",<?php } ?>];
var yMontos = [<?php foreach($listacategorias as $lc) { ?>"<?php echo productos_catg($lc['Id']); ?>",<?php } ?>];
var barColors1 = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#e8c3b9",
  "#1e7145"
];

new Chart("Grafico1", {
  type: "pie",
  data: {
    labels: xCategorias,
    datasets: [{
      backgroundColor: barColors1,
      data: yMontos
    }]
  },
  options: {
    title: {
      display: true,
      text: "PRODUCTOS POR CATEGORIA"
    }
  }
});


var xProductos = [<?php foreach($listamarcas as $lm) { ?>"<?php echo $lm['Marca']; ?>",<?php } ?>];
var yVencimiento = [<?php foreach($listamarcas as $lm) { ?>"<?php echo productos_marcas($lm['Id']); ?>",<?php } ?>];
var barColors2 = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#e8c3b9",
  "#1e7145"
];

new Chart("Grafico2", {
  type: "doughnut",
  data: {
    labels: xProductos,
    datasets: [{
      backgroundColor: barColors2,
      data: yVencimiento
    }]
  },
  options: {
    title: {
      display: true,
      text: "PRODUCTOS POR MARCA"
    }
  }
});
</script>