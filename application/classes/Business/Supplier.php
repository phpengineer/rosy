<?php
/*
 * Created on 2016
 * 商家信息逻辑层
 */
 class Business_Supplier extends Business { 

 	public function getSupplierBySupplierId($supplierId) {
 		return Dao::factory('Supplier')->getSupplierBySupplierId($supplierId);
 	}
 }
?>
