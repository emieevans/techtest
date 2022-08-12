<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sistema extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function index() {
        $this->home();
    }
    
    public function home() {
        $page_data['load_name'] = "home";
        $page_data['listacategorias'] = $this->crud_model->get_categorias();
		$page_data['listamarcas'] = $this->crud_model->get_marcas();
		
        $this->load->view('sistema/index', $page_data);
    }
    
	public function productos() {
		$CodigoBarras = trim($this->input->post('CodigoBarras'));
		$Result = $this->crud_model->getProductosInnerJoin($CodigoBarras);
		$page_data['listaproductos'] = $Result;
		$page_data['encontrado'] = count($Result);
		$page_data['codigo'] = $CodigoBarras;
		$page_data['listacategorias'] = $this->crud_model->get_categorias();
		$page_data['listamarcas'] = $this->crud_model->get_marcas();
		$page_data['formulario'] = base_url().'sistema/post_productos';
        $page_data['load_name'] = "productos";
        $this->load->view('sistema/index', $page_data);
    }
    
    public function categorias() {
    	$page_data['listacategorias'] = $this->crud_model->get_categorias();
    	$page_data['formulario'] = base_url().'sistema/post_categorias';
        $page_data['load_name'] = "categorias";
        $this->load->view('sistema/index', $page_data);
    }
    
    public function marcas() {
    	$page_data['listamarcas'] = $this->crud_model->get_marcas();
    	$page_data['formulario'] = base_url().'sistema/post_marcas';
        $page_data['load_name'] = "marcas";
        $this->load->view('sistema/index', $page_data);
    }
    
    public function reportes() {
        $page_data['load_name'] = "reportes";
        $this->load->view('sistema/index', $page_data);
    }
    
    public function get_marca() {
    	$json = array();
    	$Id = trim($this->input->post('Id'));
    	$row = $this->crud_model->get_marca_byid($Id);
    	$json['status'] = 'success';
    	$json['Id'] = $row['Id'];
    	$json['Marca'] = $row['Marca'];
    	echo json_encode($json);
    }
    
    public function post_marcas() {
    	
    	$Action = trim($this->input->post('Action'));
    	
    	if($Action == 'editar') {
    		$Id = trim($this->input->post('Id'));
    		$Marca = trim($this->input->post('Marca'));
    		$this->crud_model->edit_post_marcas($Id,$Marca);
			redirect(base_url('sistema/marcas'));
    	} else {
    		$Marca = trim($this->input->post('Marca'));
    		$this->crud_model->add_post_marcas($Marca);
			redirect(base_url('sistema/marcas'));
    	}
    	
    }
    
    public function del_marca() {
    	$json = array();
    	$Id = trim($this->input->post('Id'));
    	$this->crud_model->del_post_marcas($Id);
    	$json['status'] = 'success';
    	echo json_encode($json);
    }
    
    
    // CATEGORIAS 
    public function get_categoria() {
    	$json = array();
    	$Id = trim($this->input->post('Id'));
    	$row = $this->crud_model->get_categoria_byid($Id);
    	$json['status'] = 'success';
    	$json['Id'] = $row['Id'];
    	$json['Categoria'] = $row['Categoria'];
    	echo json_encode($json);
    }
    
    public function post_categorias() {
    	
    	$Action = trim($this->input->post('Action'));
    	
    	if($Action == 'editar') {
    		$Id = trim($this->input->post('Id'));
    		$Categoria = trim($this->input->post('Categoria'));
    		$this->crud_model->edit_post_categorias($Id,$Categoria);
			redirect(base_url('sistema/categorias'));
    	} else {
    		$Categoria = trim($this->input->post('Categoria'));
    		$this->crud_model->add_post_categorias($Categoria);
			redirect(base_url('sistema/categorias'));
    	}
    	
    }
    
    public function del_categoria() {
    	$json = array();
    	$Id = trim($this->input->post('Id'));
    	$this->crud_model->del_post_categorias($Id);
    	$json['status'] = 'success';
    	echo json_encode($json);
    }
    
    // PRODUCTOS 
    public function get_producto() {
    	$json = array();
    	$Id = trim($this->input->post('Id'));
    	$row = $this->crud_model->get_producto_byid($Id);
    	$json['status'] = 'success';
    	$json['Id'] = $row['Id'];
    	$json['Nombre'] = $row['Nombre'];
    	$json['CodigoBarras'] = $row['CodigoBarras'];
    	$json['Marca'] = $row['Marca'];
    	$json['Categoria'] = $row['Categoria'];
    	$json['Precio'] = $row['Precio'];
    	$json['Cantidad'] = $row['Cantidad'];
    	$json['FechaExpiracion'] = $row['FechaExpiracion'];
    	echo json_encode($json);
    }
    
    public function post_productos() {
    	
    	$Action = trim($this->input->post('Action'));
    	
    	if($Action == 'editar') {
    		$Id = trim($this->input->post('Id'));
    		$CodigoBarras = trim($this->input->post('CodigoBarras'));
    		$Nombre = trim($this->input->post('Nombre'));
    		$Marca = trim($this->input->post('Marca'));
    		$Categoria = trim($this->input->post('Categoria'));
    		$Precio = trim($this->input->post('Precio'));
    		$Cantidad = trim($this->input->post('Cantidad'));
    		$FechaExpiracion = trim($this->input->post('FechaExpiracion'));
    		$this->crud_model->edit_post_productos($Id,$CodigoBarras,$Nombre,$Marca,$Categoria,$Precio,$Cantidad,$FechaExpiracion);
			redirect(base_url('sistema/productos'));
    	} else {
    		$CodigoBarras = trim($this->input->post('CodigoBarras'));
    		$Nombre = trim($this->input->post('Nombre'));
    		$Marca = trim($this->input->post('Marca'));
    		$Categoria = trim($this->input->post('Categoria'));
    		$Precio = trim($this->input->post('Precio'));
    		$Cantidad = trim($this->input->post('Cantidad'));
    		$FechaExpiracion = trim($this->input->post('FechaExpiracion'));
    		$this->crud_model->add_post_productos($CodigoBarras,$Nombre,$Marca,$Categoria,$Precio,$Cantidad,$FechaExpiracion);
			redirect(base_url('sistema/productos'));
    	}
    	
    }
    
    public function del_producto() {
    	$json = array();
    	$Id = trim($this->input->post('Id'));
    	$this->crud_model->del_post_productos($Id);
    	$json['status'] = 'success';
    	echo json_encode($json);
    }
    
    public function verificar_codigo() {
    	
    	$json = array();
    	$Codigo = trim($this->input->post('Codigo'));
    	$res = $this->crud_model->verificarCodigoBarras($Codigo);
    	if($res >= 1) {
    		$json['status'] = 'existe';
    	} else {
    		$json['status'] = 'success';
    	}
    	echo json_encode($json);
    }
    
    public function reporte() {
    	
    	$Marca = trim($this->input->post('Marca'));
    	$Categoria = trim($this->input->post('Categoria'));
    	if($Marca || $Categoria) {
    		$Result = $this->crud_model->getProductosReporte($Marca,$Categoria);
			$page_data['listaproductos'] = $Result;
			$page_data['encontrado'] = count($Result);
			$page_data['Marca'] = $Marca;
			$page_data['Categoria'] = $Categoria;
    	}
    	$page_data['listacategorias'] = $this->crud_model->get_categorias();
		$page_data['listamarcas'] = $this->crud_model->get_marcas();
    	$page_data['formulario'] = base_url().'sistema/post_reporte';
        $page_data['load_name'] = "reporte";
        $this->load->view('sistema/index', $page_data);
    }
    
    //Función para exportar datos de reporte a Excel
    public function excel() {
    	
	 header("Content-type: application/vnd.ms-excel");
	 header("Content-type: application/force-download");
	 header("Content-Disposition: attachment; filename=reporte.xls");
	 header("Pragma: no-cache");
    
     $Marca = trim($this->input->post('Marca'));
     $Categoria = trim($this->input->post('Categoria'));
    	if($Marca || $Categoria) {
    		$Result = $this->crud_model->getProductosReporte($Marca,$Categoria);
    		
			$Excel = '<table class="table table-striped " id="datatable">
			<thead>
				<th style="text-align: center;">CodigoBarras</th>
				<th style="text-align: center;">Producto</th>
				<th style="text-align: center;">Marca</th>
				<th style="text-align: center;">Categoria</th>
				<th style="text-align: center;">Precio</th>
				<th style="text-align: center;">Cantidad</th>
				<th style="text-align: center;">Fecha Expiracion</th>
			</thead>
			<tbody>';
			foreach($Result as $producto) {
			$Excel .= '<tr>
					<td style="text-align: center;">'.$producto['CodigoBarras'].'</td>
					<td style="text-align: center;">'.$producto['Nombre'].'</td>
					<td style="text-align: center;">'.$producto['NombreMarca'].'</td>
					<td style="text-align: center;">'.$producto['NombreCategoria'].'</td>
					<td style="text-align: center;">$ '.number_format($producto['Precio'],2,',','.').'</td>
					<td style="text-align: center;">'.$producto['Cantidad'].'</td>
					<td style="text-align: center;">'.date("d-m-Y", strtotime($producto['FechaExpiracion'])).'</td>
				</tr>';
			}
			$Excel .= '</tbody></table>';
			echo $Excel;
    	}
    
    	
    }
    
}
