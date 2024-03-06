<?php
/*
######################################################################
# __      __          __         ___                                 #
#/\ \  __/\ \        /\ \      /'___\                                #
#\ \ \/\ \ \ \     __\ \ \____/\ \__/  ___   _ __   ___     __       #
# \ \ \ \ \ \ \  /'__`\ \ '__`\ \ ,__\/ __`\/\`'__\/'___\ /'__`\     #
#  \ \ \_/ \_\ \/\  __/\ \ \L\ \ \ \_/\ \L\ \ \ \//\ \__//\  __/     #
#   \ `\___x___/\ \____\\ \_,__/\ \_\\ \____/\ \_\\ \____\ \____\    #
#    '\/__//__/  \/____/ \/___/  \/_/ \/___/  \/_/ \/____/\/____/    #
#                                                                    #
#     )   ___                                                        #
#    (__/_____)                      Webforce Cart v.1.5             #
#      /       _   __ _/_            (c) 2004-2005 Webforce Ltd, NZ  #
#     /       (_(_/ (_(__            webforce.co.nz/cart             #
#    (______)                        all rights reserved             #
#                                                                    #
#  Session based, Object Oriented Shopping Cart Component for PHP    #
#                                                                    #
######################################################################
# Ver 1.6 - Bugfix // Thanks James
# Ver 1.5 - Demo updated, Licence changed to LGPL
# Ver 1.4 - demo included
# Ver 1.3 - bugfix with total 
# Ver 1.2 - added empty_cart()
# Ver 1.0 - initial release
You are allowed to use this script in websites you create. 
Licence: LGPL - http://www.gnu.org/copyleft/lesser.txt
*** Instructions at http://www.webforce.co.nz/cart/php-cart.php ***
*** READ THEM!                                                 ***

BUGS/PATCHES

Please email eaden@webforce.co.nz with any bugs/fixes/patches/comments etc.
See http://www.webforce.co.nz/cart/ for updates to this script

*/
class wfCart {
	var $total = 0;
	var $subtotal = 0;
	var $itemcount = 0;
	var $items = array();
    var $itemprices = array();
	var $itemqtys = array();
	var $itemnotes = array();
    var $iteminfo = array();
	var $discount =0;
	var $delivery =0;
	var $surcharge=0;

	function cart() {
		if(isset($_SESSION['id_customer'])){
		$this->load_values_DB();
		}
		} // constructor function
function load_values_DB(){
$p_query = tep_db_query("select * from  " . TABLE_CUSTOMERS_BASKET. " where customer_id='".$_SESSION['id_customer']."'");
$items='';


while($prods= tep_db_fetch_array($p_query)){
	$items[]=$prods['product_id'];
	$item_prices[$prods['product_id']]=$prods['price'];
	$item_qtys[$prods['product_id']]=$prods['quantity'];
	$item_notes[$prods['product_id']]=$prods['note'];
	$item_info[$prods['product_id']]=get_model_products($prods['product_id']).' - '.get_name_products($prods['product_id']);		
}	
if(is_array($items)){
	$this->items = $items;
    $this->itemprices = $item_prices;
	$this->itemqtys = $item_qtys;
	$this->itemnotes = $item_notes;
    $this->iteminfo = $item_info;
}
$this->_update_total();
}
	function get_contents()
	{ // gets cart contents
		$items = array();
		foreach($this->items as $tmp_item)
		{
		        $item = FALSE;

			$item['id'] = $tmp_item;
            $item['qty'] = $this->itemqtys[$tmp_item];
			$item['price'] = $this->itemprices[$tmp_item];
			$item['note'] =  $this->itemnotes[$tmp_item];
			$item['info'] = $this->iteminfo[$tmp_item];
			$item['subtotal'] = $item['qty'] * $item['price'];
            $items[] = $item;
			
		}
		return $items;
	} // end of get_contents


	function add_item($itemid,$qty=1,$price = FALSE, $info = FALSE)
	{ // adds an item to cart
                if(!$price)
		{
		        $price = wf_get_price($itemid,$qty);
		}

                if(!$info)
		{
                        $info = wf_get_info($itemid);
		}

		if((isset($this->itemqtys[$itemid]))&&($this->itemqtys[$itemid] > 0))
                { // the item is already in the cart..
		  // so we'll just increase the quantity
			$this->itemqtys[$itemid] = $qty + $this->itemqtys[$itemid];
		

			
		
			$this->_update_total();
		} else {
			$this->items[]=$itemid;
			$this->itemqtys[$itemid] = $qty;
			$this->itemnotes[$itemid] = '';
			$this->itemprices[$itemid] = $price;
			$this->iteminfo[$itemid] = $info;
		}
		
		
			if(isset($_SESSION['id_customer'])){
				$chk_query = tep_db_query("select count(*) as total from  " . TABLE_CUSTOMERS_BASKET. " where product_id='".$itemid."' and customer_id='".$_SESSION['id_customer']."'");
	$chk_prod= tep_db_fetch_array($chk_query);
	if($chk_prod['total']>0){
		tep_db_query("UPDATE `customers_basket` SET `quantity`='".$this->itemqtys[$itemid]."', `price`='".$this->itemprices[$itemid]."',  `date_added`='".get_date('Y-m-d H:i:s')."' WHERE (`customer_id`='".$_SESSION['id_customer']."' and `product_id`='".$itemid."' )");	
	}else{
		tep_db_query("INSERT INTO `customers_basket` (`customer_id`, `product_id`, `quantity`, `price`,  `date_added`) VALUES ('".$_SESSION['id_customer']."', '".$itemid."', '".$this->itemqtys[$itemid]."', '".$this->itemprices[$itemid]."',  '".get_date('Y-m-d H:i:s')."')");
	}
			}
			
			$this->_update_total();
	} // end of add_item


	function edit_item($itemid,$qty)
	{ // changes an items quantity

		if($qty < 1) {
			$this->del_item($itemid);
		} else {
			$this->itemqtys[$itemid] = $qty;
			// uncomment this line if using 
			// the wf_get_price function
			// $this->itemprices[$itemid] = wf_get_price($itemid,$qty);
		}
		if(isset($_SESSION['id_customer'])){
				$chk_query = tep_db_query("select count(*) as total from  " . TABLE_CUSTOMERS_BASKET. " where product_id='".$itemid."' and customer_id='".$_SESSION['id_customer']."'");
	$chk_prod= tep_db_fetch_array($chk_query);
	if($chk_prod['total']>0){
		tep_db_query("UPDATE `customers_basket` SET `quantity`='".$this->itemqtys[$itemid]."', `price`='".$this->itemprices[$itemid]."',  `date_added`='".get_date('Y-m-d H:i:s')."' WHERE (`customer_id`='".$_SESSION['id_customer']."' and `product_id`='".$itemid."' )");	
	}
			}
		$this->_update_total();
	} // end of edit_item


	function attach_note($itemid,$note)
	{ // changes an items quantity

		//if(!empty($note)) {
			$this->itemnotes[$itemid] = $note;
			// uncomment this line if using 
			// the wf_get_price function
			// $this->itemprices[$itemid] = wf_get_price($itemid,$qty);
		//}
	if(isset($_SESSION['id_customer'])){
				$chk_query = tep_db_query("select count(*) as total from  " . TABLE_CUSTOMERS_BASKET. " where product_id='".$itemid."' and customer_id='".$_SESSION['id_customer']."'");
	$chk_prod= tep_db_fetch_array($chk_query);
	if($chk_prod['total']>0){
		tep_db_query("UPDATE `customers_basket` SET  `note`='".$this->itemnotes[$itemid]."',  `date_added`='".get_date('Y-m-d H:i:s')."' WHERE (`customer_id`='".$_SESSION['id_customer']."' and `product_id`='".$itemid."' )");	
	}
			}
		$this->_update_total();
	} // end of edit_item



	function del_item($itemid)
	{ // removes an item from cart
		$ti = array();
		$this->itemqtys[$itemid] = 0;
		foreach($this->items as $item)
		{
			if($item != $itemid)
			{
				$ti[] = $item;
			}
		}
		$this->items = $ti;
			if(isset($_SESSION['id_customer'])){

		tep_db_query("DELETE FROM `customers_basket` WHERE (`customer_id`='".$_SESSION['id_customer']."' and `product_id`='".$itemid."' )");	
	
			}
		$this->_update_total();
	} //end of del_item


        function empty_cart()
	{ // empties / resets the cart
            $this->subtotal = 0;
	        $this->itemcount = 0;
	        $this->items = array();
            $this->itemprices = array();
            $this->itemnotes = array();
	        $this->itemqtys = array();
            $this->iteminfo = array();
			$this->total = 0;

	$this->discount =0;
	$this->delivery =0;
	$this->surcharge=0;
	if(isset($_SESSION['id_customer'])){

		tep_db_query("DELETE FROM `customers_basket` WHERE (`customer_id`='".$_SESSION['id_customer']."' )");	
	
			}
			$this->_update_total();
			
	} // end of empty cart


	function _update_total()
	{ // internal function to update the total in the cart
	        $this->itemcount = 0;
		$this->subtotal = 0;
                if(sizeof($this->items > 0))
		{
                        foreach($this->items as $item) {
                                $this->subtotal = $this->subtotal + ($this->itemprices[$item] * $this->itemqtys[$item]);
				$this->itemcount++;
			}
		}

		$this->delivery=get_delivery_charge($this->subtotal);
		$this->total=$this->delivery+$this->subtotal+$this->surcharge-$this->discount;		
	} // end of update_total

}
?>
