<?php 
if(!session_id()){ 
    session_start(); 
} 
/** 
 * @package        PHP Library 
 * @category    Shopping Cart 
 * @author        CodexWorld Dev Team 
 * @link        https://www.codexworld.com 
 */ 
class Cart { 
    protected $cart_contents = array(); 
     
    public function __construct(){ 
        $this->cart_contents = !empty($_SESSION['cart_contents'])?$_SESSION['cart_contents']:NULL; 
        if ($this->cart_contents === NULL){ 
            $this->cart_contents = array('cart_total' => 0, 'total_items' => 0); 
        } 
    } 
     
    /** 
     * @param    bool 
     * @return    array 
     */ 
    public function contents(){ 
        $cart = array_reverse($this->cart_contents); 
 
        unset($cart['total_items']); 
        unset($cart['cart_total']); 
 
        return $cart; 
    } 
     
    /** 
     * @param    string    $row_id 
     * @return    array 
     */ 
    public function get_item($row_id){ 
        return (in_array($row_id, array('total_items', 'cart_total'), TRUE) OR ! isset($this->cart_contents[$row_id])) 
            ? FALSE 
            : $this->cart_contents[$row_id]; 
    } 
     
    /** 
     * @return    int 
     */ 
    public function total_items(){ 
        return $this->cart_contents['total_items']; 
    } 
     
    /** 
     * @return    int 
     */ 
    public function total(){ 
        return $this->cart_contents['cart_total']; 
    } 
     
    /** 
     * @param    array 
     * @return    bool 
     */ 
    public function insert($item = array()){ 
        if(!is_array($item) OR count($item) === 0){ 
            return FALSE; 
        }else{ 
            if(!isset($item['id'], $item['nume'], $item['autor'],$item['pret'], $item['qty'])){ 
                return FALSE; 
            }else{ 
                /* 
                 * Insert Item 
                 */ 
                $item['qty'] = (float) $item['qty']; 
                if($item['qty'] == 0){ 
                    return FALSE; 
                } 
                $item['price'] = (float) $item['price']; 
                $rowid = md5($item['id']); 
                $old_qty = isset($this->cart_contents[$rowid]['qty']) ? (int) $this->cart_contents[$rowid]['qty'] : 0; 
                $item['rowid'] = $rowid; 
                $item['qty'] += $old_qty; 
                $this->cart_contents[$rowid] = $item; 
                 
                if($this->save_cart()){ 
                    return isset($rowid) ? $rowid : TRUE; 
                }else{ 
                    return FALSE; 
                } 
            } 
        } 
    } 
     
    /** 
     * @param    array 
     * @return    bool 
     */ 
    public function update($item = array()){ 
        if (!is_array($item) OR count($item) === 0){ 
            return FALSE; 
        }else{ 
            if (!isset($item['rowid'], $this->cart_contents[$item['rowid']])){ 
                return FALSE; 
            }else{ 
                if(isset($item['qty'])){ 
                    $item['qty'] = (float) $item['qty']; 
                    if ($item['qty'] == 0){ 
                        unset($this->cart_contents[$item['rowid']]); 
                        return TRUE; 
                    } 
                } 
                 
                $keys = array_intersect(array_keys($this->cart_contents[$item['rowid']]), array_keys($item)); 
                if(isset($item['pret'])){ 
                    $item['pret'] = (float) $item['pret']; 
                } 
                foreach(array_diff($keys, array('id', 'nume')) as $key){ 
                    $this->cart_contents[$item['rowid']][$key] = $item[$key]; 
                } 
                $this->save_cart(); 
                return TRUE; 
            } 
        } 
    } 
     
    /** 
     * @return    bool 
     */ 
    protected function save_cart(){ 
        $this->cart_contents['total_items'] = $this->cart_contents['cart_total'] = 0; 
        foreach ($this->cart_contents as $key => $val){ 
            if(!is_array($val) OR !isset($val['pret'], $val['qty'])){ 
                continue; 
            } 
      
            $this->cart_contents['cart_total'] += ($val['pret'] * $val['qty']); 
            $this->cart_contents['total_items'] += $val['qty']; 
            $this->cart_contents[$key]['subtotal'] = ($this->cart_contents[$key]['pret'] * $this->cart_contents[$key]['qty']); 
        } 
         
        if(count($this->cart_contents) <= 2){ 
            unset($_SESSION['cart_contents']); 
            return FALSE; 
        }else{ 
            $_SESSION['cart_contents'] = $this->cart_contents; 
            return TRUE; 
        } 
    } 
     
    /** 
     * @param    int 
     * @return    bool 
     */ 
     public function remove($row_id){ 
        unset($this->cart_contents[$row_id]); 
        $this->save_cart(); 
        return TRUE; 
     } 
      
    /** 
     * @return    void 
     */ 
    public function destroy(){ 
        $this->cart_contents = array('cart_total' => 0, 'total_items' => 0); 
        unset($_SESSION['cart_contents']); 
    } 
}