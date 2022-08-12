<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('productos_catg')) {
	
	function productos_catg($Id = '') {
		
		$Sistema =&	get_instance();
		$Sistema->load->database();
		
		$Sistema->db->where('Categoria', $Id); 
		$Sistema->db->from('productos');
		echo $Sistema->db->count_all_results();
		
	}
		
}


if (!function_exists('productos_marcas')) {
	
	function productos_marcas($Id = '') {
		
		$Sistema =&	get_instance();
		$Sistema->load->database();
		
		$Sistema->db->where('Marca', $Id); 
		$Sistema->db->from('productos');
		echo $Sistema->db->count_all_results();
		
	}
		
}
