<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
    
    public function get_productos() {
    	$this->db->order_by('Id','desc');
        $res = $this->db->get('productos')->result_array();
        return $res;
    }
    
    public function get_marcas(){
    	$this->db->order_by('Marca','asc');
    	$res = $this->db->get('marcas')->result_array();
    	return $res;
    } 
    
    public function get_categorias(){
    	$this->db->order_by('Categoria','asc');
    	$res = $this->db->get('categorias')->result_array();
    	return $res;
    }
    
    // Verificación de codigo de barras registrado
    public function verificarCodigoBarras($Codigo = '') {
    	$this->db->where('CodigoBarras', $Codigo); 
		$this->db->from('productos');
		return $this->db->count_all_results();
    }
    
    // Obeteniendo cantidad de productos caducados por categoria
    public function verificarExpiracionCategoria($Categoria = '') {
    	$Fecha = date('Y-m-d');
    	$this->db->where('Categoria', $Categoria); 
    	$this->db->where('FechaExpiracion <=', $Fecha); 
		$this->db->from('productos');
		return $this->db->count_all_results();
    }
    
    // Obteniendo cantidad de productos caducados por marca
    public function verificarExpiracionMarca($Marca = '') {
    	$Fecha = date('Y-m-d');
    	$this->db->where('Marca', $Marca); 
    	$this->db->where('FechaExpiracion <=', $Fecha); 
		$this->db->from('productos');
		return $this->db->count_all_results();
    }
    
    // Obteniendo cantidad de productos caducados por marca y categoria
    public function verificarExpiracion($Marca = '') {
    	$Fecha = date('Y-m-d');
    	$this->db->where('Marca', $Marca); 
    	$this->db->where('Categoria', $Categoria);
    	$this->db->where('FechaExpiracion <=', $Fecha); 
		$this->db->from('productos');
		return $this->db->count_all_results();
    }
    
    //Obteniendo productos con su marca y categoria 
    public function getProductosInnerJoin($CodigoBarras = '') {
    	
    	$Where = '';
    	if($CodigoBarras) {
    		$Where .= "AND productos.CodigoBarras = '$CodigoBarras'";
    	}
    	
    	$res = $this->db->query("SELECT productos.*, categorias.Categoria as NombreCategoria, marcas.Marca as NombreMarca FROM productos LEFT JOIN categorias ON categorias.id = productos.categoria LEFT JOIN marcas ON marcas.id = productos.marca WHERE 1=1 $Where order by Id Desc")->result_array();
    	
    	return $res;
    	
    }
    
    // Reporte 
    public function getProductosReporte($Marca = '', $Categoria = '') {
    	
    	$Where = '';
    	if($Marca) {
    		$Where .= "AND productos.Marca = '$Marca'";
    	}
    	if($Categoria) {
    		$Where .= "AND productos.Categoria = '$Categoria'";
    	}
    	
    	$res = $this->db->query("SELECT productos.*, categorias.Categoria as NombreCategoria, marcas.Marca as NombreMarca FROM productos LEFT JOIN categorias ON categorias.id = productos.categoria LEFT JOIN marcas ON marcas.id = productos.marca WHERE 1=1 $Where order by FechaExpiracion Asc")->result_array();
    	
    	return $res;
    	
    }
    
    public function getProductoscaducados() {
    	
    	$Fecha = date('Y-m-d');
    	
    	$res = $this->db->query("SELECT productos.*, categorias.Categoria as NombreCategoria, marcas.Marca as NombreMarca FROM productos LEFT JOIN categorias ON categorias.id = productos.categoria LEFT JOIN marcas ON marcas.id = productos.marca WHERE FechaExpiracion <= '$Fecha' order by Id Desc")->result_array();
    	return $res;
    }
    
    //Verifica si el código de barras está registrado  antes de insertar
    public function registrarProducto($Nombre = '', $CodigoBarras = '', $Marca = '', $Categoria = '', $Precio = '', $Cantidad = '', $Imagen = '', $FechaExpiracion = '') {
    	
    	$noValido = 0;
    	
    	if($this->verificarCodigoBarras($CodigoBarras) >= 1) {
    	return $noValido;
    	} else {
    	
    	$Params['Nombre'] = $Nombre;
    	$Params['CodigoBarras'] = $CodigoBarras;
    	$Params['Marca'] = $Marca;
    	$Params['Categoria'] = $Categoria;
    	$Params['Precio'] = $Precio;
    	$Params['Cantidad'] = $Cantidad;
    	$Params['Imagen'] = $Imagen;
    	$Params['FechaExpiracion'] = $FechaExpiracion;
		$this->db->insert('productos',$Params);
		return $this->db->insert_id();
    	}
    }
    
    // CRUD MARCAS
    public function get_marca_byid($Id = '') {
    	$res = $this->db->get_where('marcas',array('Id' => $Id))->row_array();
    	return $res;
    }
        
    public function edit_post_marcas($Id = '',$Marca = '') {
    	$Params['Marca'] = $Marca;
		$this->db->where('Id',$Id);
		$update = $this->db->update('marcas',$Params);
    }
    
    public function add_post_marcas($Marca = '') {
    	$Params['Marca'] = $Marca;
		$this->db->insert('marcas',$Params);
		return $this->db->insert_id();
    }
    
    public function del_post_marcas($Id) {
    	return $this->db->delete('marcas',array('Id'=>$Id));
    }
    
    // CRUD CATEGORIAS
    public function get_categoria_byid($Id = '') {
    	$res = $this->db->get_where('categorias',array('Id' => $Id))->row_array();
    	return $res;
    }
    
    public function edit_post_categorias($Id = '',$Categoria = '') {
    	$Params['Categoria'] = $Categoria;
		$this->db->where('Id',$Id);
		$update = $this->db->update('categorias',$Params);
    }
    
    public function add_post_categorias($Categoria = '') {
    	$Params['Categoria'] = $Categoria;
		$this->db->insert('categorias',$Params);
		return $this->db->insert_id();
    }
    
    public function del_post_categorias($Id) {
    	return $this->db->delete('categorias',array('Id'=>$Id));
    }
    
    // CRUD PRODUCTOS
    public function get_producto_byid($Id = '') {
    	$res = $this->db->get_where('productos',array('Id' => $Id))->row_array();
    	return $res;
    }
    
    public function edit_post_productos($Id = '',$CodigoBarras = '',$Nombre = '',$Marca = '',$Categoria = '',$Precio = '',$Cantidad = '',$FechaExpiracion = '') {
    	$Params['CodigoBarras'] = $CodigoBarras;
    	$Params['Nombre'] = $Nombre;
    	$Params['Marca'] = $Marca;
    	$Params['Categoria'] = $Categoria;
    	$Params['Precio'] = $Precio;
    	$Params['Cantidad'] = $Cantidad;
    	$Params['FechaExpiracion'] = $FechaExpiracion;
		$this->db->where('Id',$Id);
		$update = $this->db->update('productos',$Params);
    }
    
    public function add_post_productos($CodigoBarras = '',$Nombre = '',$Marca = '',$Categoria = '',$Precio = '',$Cantidad = '',$FechaExpiracion = '') {
    	$Params['CodigoBarras'] = $CodigoBarras;
    	$Params['Nombre'] = $Nombre;
    	$Params['Marca'] = $Marca;
    	$Params['Categoria'] = $Categoria;
    	$Params['Precio'] = $Precio;
    	$Params['Cantidad'] = $Cantidad;
    	$Params['FechaExpiracion'] = $FechaExpiracion;
		$this->db->insert('productos',$Params);
		return $this->db->insert_id();
    }
    
    public function del_post_productos($Id) {
    	return $this->db->delete('productos',array('Id'=>$Id));
    }
}
