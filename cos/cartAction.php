<?php 
require_once 'dbConnect.php'; 
 
require_once 'Cart.class.php'; 
$cart = new Cart; 
 
$redirectURL = '/../home.php'; 
 
if(isset($_REQUEST['action']) && !empty($_REQUEST['action']))
{ 
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){ 
        $product_id = $_REQUEST['id']; 
 
        $sqlQ = "SELECT * FROM produse WHERE id=?"; 
        $stmt = $db->prepare($sqlQ); 
        $stmt->bind_param("i", $db_id); 
        $db_id = $product_id; 
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        $productRow = $result->fetch_assoc(); 
 
        $itemData = array( 
            'id' => $productRow['id'], 
            'nume' => $productRow['nume'], 
            'autor' => $productRow['autor'], 
            'pret' => $productRow['pret'], 
            'imagine' => $productRow['imagine'],
            'qty' => 1 
        ); 
         
        $insertItem = $cart->insert($itemData); 
         
        $redirectURL = $insertItem?'../home.php':'../home.php'; 
    }
    elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){ 
        $itemData = array( 
            'rowid' => $_REQUEST['id'], 
            'qty' => $_REQUEST['qty'] 
        ); 
        $updateItem = $cart->update($itemData); 
         
        echo $updateItem?'ok':'err';die; 
    }
    elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){ 
        $deleteItem = $cart->remove($_REQUEST['id']); 
         
        $redirectURL = 'viewCart.php'; 
    }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0){ 
        $redirectURL = 'checkout.php'; 
         
        $_SESSION['postData'] = $_POST; 
     
        $id_client = $_SESSION['id'];
        $nume = strip_tags($_POST['nume']); 
        $prenume = strip_tags($_POST['prenume']); 
        $telefon = strip_tags($_POST['telefon']); 
        $judet = strip_tags($_POST['judet']);
        $oras = strip_tags($_POST['oras']);
        $strada = strip_tags($_POST['strada']);
        $numar = strip_tags($_POST['numar']);
        $apartament = strip_tags($_POST['apartament']);
         
        $errorMsg = ''; 
        if(empty($nume)){ 
            $errorMsg .= 'Introduceți numele.<br/>'; 
        } 
        if(empty($prenume)){ 
            $errorMsg .= 'Introduceți prenumele.<br/>'; 
        } 
        if(empty($telefon)){ 
            $errorMsg .= 'Introduceti numărul de telefon.<br/>'; 
        } 
        if(empty($judet)){ 
            $errorMsg .= 'Introduceți județul.<br/>'; 
        } 
        if(empty($oras)){ 
            $errorMsg .= 'Introduceți orașul.<br/>'; 
        } 
        if(empty($strada)){ 
            $errorMsg .= 'Introduceți strada.<br/>'; 
        } 
        if(empty($numar)){ 
            $errorMsg .= 'Introduceți numarul.<br/>'; 
        } 
        if(empty($apartament)){ 
            $errorMsg .= 'Introduceți apartamentul.<br/>'; 
        } 
         
        if(empty($errorMsg)){ 

            $sql3 = "SELECT * FROM detalii_clienti where id_client = $id_client"; 
            $result = mysqli_query($db,$sql3);
            $rows = mysqli_num_rows($result);

            if($rows < 1){
            
                $sqlQ = "INSERT INTO detalii_clienti (id_client,nume,prenume,telefon,judet,oras,strada,numar,apartament,adaugat) VALUES (?,?,?,?,?,?,?,?,?,NOW())"; 
                $stmt = $db->prepare($sqlQ); 
                $stmt->bind_param("ississsii", $db_id_client, $db_nume, $db_prenume, $db_telefon, $db_judet, $db_oras, $db_strada, $db_numar, $db_apartament); 
                $db_id_client = $id_client; 
                $db_nume = $nume; 
                $db_prenume = $prenume; 
                $db_telefon = $telefon; 
                $db_judet = $judet; 
                $db_oras = $oras; 
                $db_strada = $strada; 
                $db_numar = $numar; 
                $db_apartament = $apartament; 
                $insertCust = $stmt->execute();
                
                if($insertCust){ 
                    $custID = $stmt->insert_id; 
                        
                    $sqlQ = "INSERT INTO comanda (id_client,total,plasata_in,status) VALUES (?,?,NOW(),?)"; 
                    $stmt = $db->prepare($sqlQ); 
                    $stmt->bind_param("ids", $db_id_client, $db_total, $db_status); 
                    $db_customer_id = $custID; 
                    $db_total = $cart->total(); 
                    $db_status = 'În procesare'; 
                    $insertOrder = $stmt->execute(); 
                    
                    if($insertOrder){ 
                        $orderID = $stmt->insert_id; 
                            
                        $cartItems = $cart->contents(); 
                            
                        if(!empty($cartItems)){ 
                            $sqlQ = "INSERT INTO produs_comanda (id, id_comanda, id_produs, cantitate) VALUES (?,?,?,?)"; 
                            
                            $stmt = $db->prepare($sqlQ); 
                            foreach($cartItems as $item){ 
                                $stmt->bind_param("iids", $db_id, $db_id_comanda, $db_id_produs, $db_cantitate); 
                                $db_id_comanda = $orderID; 
                                $db_id = $_SESSION['id'];
                                $db_id_produs = $item['id']; 
                                $db_cantitate = $item['qty']; 

                                $getstock = "SELECT stoc FROM produse WHERE id = $db_id_produs"; 
                                $result2 = mysqli_query($db, $getstock); 
                                $stock = mysqli_fetch_assoc($result2);
                                $stock2 = $stock['stoc'];
                                $updatestock = "UPDATE produse SET stoc = $stock2 - $db_cantitate WHERE id = $db_id_produs"; 
                                $stmt2 = $db->query($updatestock); 
                                $stmt->execute(); 
                            } 

                            $cart->destroy(); 
                                
                            $redirectURL = 'orderSuccess.php?id='.base64_encode($orderID); 
                        }else{ 
                            $sessData['status']['type'] = 'error'; 
                            $sessData['status']['msg'] = 'Something went wrong, please try again.'; 
                        } 
                    }else{ 
                        $sessData['status']['type'] = 'error'; 
                        $sessData['status']['msg'] = 'Something went wrong, please try again.'; 
                    } 
                }
                else{ 
                    $sessData['status']['type'] = 'error'; 
                    $sessData['status']['msg'] = 'Something went wrong, please try again.'; 
                } 
            }
            else
            {
                $sqlQ = "UPDATE detalii_clienti SET nume=?,prenume=?,telefon=?,judet=?,oras=?,strada=?,numar=?,apartament=?,adaugat = NOW() WHERE id_client=?"; 
                $stmt = $db->prepare($sqlQ); 
                $stmt->bind_param("ssisssiii", $db_nume, $db_prenume, $db_telefon, $db_judet, $db_oras, $db_strada, $db_numar, $db_apartament, $db_id_client); 
                $db_id_client = $id_client; 
                $db_nume = $nume; 
                $db_prenume = $prenume; 
                $db_telefon = $telefon; 
                $db_judet = $judet; 
                $db_oras = $oras; 
                $db_strada = $strada; 
                $db_numar = $numar; 
                $db_apartament = $apartament; 
                $insertCust = $stmt->execute();

                if($insertCust){ 
                    $custID = $stmt->insert_id; 
                        
                    $sqlQ = "INSERT INTO comanda (id_client,total,plasata_in,status) VALUES (?,?,NOW(),?)"; 
                    $stmt = $db->prepare($sqlQ); 
                    $stmt->bind_param("ids", $db_id_client, $db_total, $db_status); 
                    $db_customer_id = $custID; 
                    $db_total = $cart->total(); 
                    $db_status = 'În procesare'; 
                    $insertOrder = $stmt->execute(); 
                    
                    if($insertOrder){ 
                        $orderID = $stmt->insert_id; 
                            
                        $cartItems = $cart->contents(); 
                            
                        if(!empty($cartItems)){ 
                            $sqlQ = "INSERT INTO produs_comanda (id, id_comanda, id_produs, cantitate) VALUES (?,?,?,?)"; 
                            
                            $stmt = $db->prepare($sqlQ); 
                            foreach($cartItems as $item){ 
                                $stmt->bind_param("iids", $db_id, $db_id_comanda, $db_id_produs, $db_cantitate); 
                                $db_id_comanda = $orderID; 
                                $db_id = $_SESSION['id'];
                                $db_id_produs = $item['id']; 
                                $db_cantitate = $item['qty']; 

                                $getstock = "SELECT stoc FROM produse WHERE id = $db_id_produs"; 
                                $result2 = mysqli_query($db, $getstock); 
                                $stock = mysqli_fetch_assoc($result2);
                                $stock2 = $stock['stoc'];
                                $updatestock = "UPDATE produse SET stoc = $stock2 - $db_cantitate WHERE id = $db_id_produs"; 
                                $stmt2 = $db->query($updatestock); 
                                $stmt->execute(); 
                            } 

                            $cart->destroy(); 
                                
                            $redirectURL = 'orderSuccess.php?id='.base64_encode($orderID); 
                        }else{ 
                            $sessData['status']['type'] = 'error'; 
                            $sessData['status']['msg'] = 'Something went wrong, please try again.'; 
                        } 
                    }else{ 
                        $sessData['status']['type'] = 'error'; 
                        $sessData['status']['msg'] = 'Something went wrong, please try again.'; 
                    } 
                }
                else{ 
                    $sessData['status']['type'] = 'error'; 
                    $sessData['status']['msg'] = 'Something went wrong, please try again.'; 
                } 
            }
        }
        else{ 
            $sessData['status']['type'] = 'error'; 
            $sessData['status']['msg'] = '<p>Please fill all the mandatory fields.</p>'.$errorMsg;  
        } 
         
        $_SESSION['sessData'] = $sessData; 
    } 
} 
 
header("Location: $redirectURL"); 
exit();