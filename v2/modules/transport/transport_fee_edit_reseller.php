<?php
nosubmit_form_historyback();

try
{
    $query = $connectData->prepare('SELECT COUNT(id_destination_shipping) FROM shipping_destination_reseller');
    $query->execute();
    
    if(($data = $query->fetch()))
    {
        $total_destination = $data[0];
    }
    $query->closeCursor();
    
    $query = $connectData->prepare('SELECT COUNT(id_shipping) FROM shipping_reseller');
    $query->execute();
    
    if(($data = $query->fetch()))
    {
        $total_shipping_part = $data[0];
    }
    $query->closeCursor();
    
    $query = $connectData->prepare('SELECT COUNT(id_special_shipping) FROM shipping_special_reseller');
    $query->execute();
    
    if(($data = $query->fetch()))
    {
        $total_special_part = $data[0];
    }
    $query->closeCursor();
}
catch (Exception $e)
{
    die("<br>Error : ".$e->getMessage());
}

if(isset($_POST['bt_choose_shipment_destination']))
{
    // <editor-fold defaultstate="collapsed" desc="Display transport fee according to the selected destination">
    $selected_destination = $_POST['cboShipmentDestination'];
    
    $BoK_display_add = true;
    $BoK_display_modify = false;
    $BoK_display_delete = false;
    $BoK_display_special = false;
    $BoK_display_special_modify = false;
    $BoK_display_special_delete = false;
    unset($_SESSION['transport_fee_reseller_edit_add_special_part']);
    
    $_SESSION['transport_fee_reseller_edit_cboShipmentDestination'] = $selected_destination;
    
    if($selected_destination == 'select')
    {
        unset($_SESSION['transport_fee_reseller_edit_cboShipmentDestination']);
        unset($_SESSION['transport_fee_reseller_edit_txtNewDestination']);
    }
    else
    {
        if($selected_destination == 'new')
        {
            $_SESSION['transport_fee_reseller_edit_txtNewDestination'] = true;
        }
        else
        {
            unset($_SESSION['transport_fee_reseller_edit_txtNewDestination']);
        }
    }
    
    //header('Location: '.$header.$_SESSION['index'].'?page='.$_SESSION['redirect']);// </editor-fold>
}

if(isset($_POST['bt_save_new_destination']))
{
    // <editor-fold defaultstate="collapsed" desc="Display transport fee according to the selected destination">
    $selected_destination = $_POST['cboShipmentDestination'];
    $txtNewDestination = trim(htmlspecialchars($_POST['txtNewDestination'], ENT_QUOTES));
    
    $_SESSION['transport_fee_reseller_edit_cboShipmentDestination'] = $selected_destination;
    
    if(!empty($txtNewDestination))
    {
        try
        {
            $query = $connectData->prepare('INSERT INTO shipping_destination_reseller (name_destination_shipping)
                                            VALUES (:destination)');
            $query->bindParam('destination', $txtNewDestination);
            $query->execute();
            $query->closeCursor();
            
            $query = $connectData->prepare('INSERT INTO shipping_destination_reseller (name_destination_shipping)
                                            VALUES (:destination)');
            $query->bindParam('destination', $txtNewDestination);
            $query->execute();
            $query->closeCursor();
        }
        catch (Exception $e)
        {
            die("<br>Error : ".$e->getMessage());
        }
        
        unset($_SESSION['transport_fee_reseller_edit_cboShipmentDestination'], $_SESSION['transport_fee_reseller_edit_txtNewDestination']);
    }
    
    header('Location: '.$header.$_SESSION['index'].'?page='.$_SESSION['redirect']);// </editor-fold>
}

for($i = 1; $i <= $total_destination; $i++)
{
    // <editor-fold defaultstate="collapsed" desc="modify or delete selected destination">    
    
    if(isset($_POST['bt_modify_destination_'.$i.'_x']))
    {
        $_SESSION['transport_fee_reseller_edit_txtModifyDestination'.$i] = true;
    }
    else
    {
        unset($_SESSION['transport_fee_reseller_edit_txtModifyDestination'.$i]); 
    }
    
    if(isset($_POST['bt_save_modify_destination'.$i]))
    {
        $txtModifyDestination = trim(htmlspecialchars($_POST['txtModifyDestination'.$i], ENT_QUOTES));
        $txtModifyTVA = trim(htmlspecialchars($_POST['txtModifyTVA'.$i], ENT_QUOTES));
        
        if(!empty($txtModifyDestination))
        {
            try
            {
                $query = $connectData->prepare('UPDATE shipping_destination_reseller
                                                SET name_destination_shipping = :name
                                                WHERE id_destination_shipping = :id');
                $query->execute(array(
                                      'name' => $txtModifyDestination,
                                      'id' => $i
                                      ));
                $query->execute();
                $query->closeCursor();
                
                $query = $connectData->prepare('UPDATE shipping_destination_reseller
                                                SET name_destination_shipping = :name
                                                WHERE id_destination_shipping = :id');
                $query->execute(array(
                                      'name' => $txtModifyDestination,
                                      'id' => $i
                                      ));
                $query->execute();
                $query->closeCursor();
                
                $query = $connectData->prepare('UPDATE tax
                                                SET value_tax = :tax
                                                WHERE id_destination_shipping = :id');
                $query->execute(array(
                                      'tax' => $txtModifyTVA,
                                      'id' => $i
                                      ));
                $query->execute();
                $query->closeCursor();
            }
            catch (Exception $e)
            {
                die("<br>Error : ".$e->getMessage());
            }
        }
    }
    
    if(isset($_POST['bt_delete_modify_destination'.$i]))
    {
        $_SESSION['transport_fee_reseller_edit_askDeleteModifyDestination'.$i] = true;
        $_SESSION['transport_fee_reseller_edit_txtModifyDestination'.$i] = true;
    }
    else
    {
        unset($_SESSION['transport_fee_reseller_edit_askDeleteModifyDestination'.$i]);
    }
    
    if(isset($_POST['bt_confirm_delete_modify_destination'.$i]))
    {
        $_SESSION['transport_fee_reseller_edit_askDeleteModifyDestination'.$i] = true;
        unset($_SESSION['transport_fee_reseller_edit_txtModifyDestination'.$i]);
        
        try
        {
            $query = $connectData->prepare('DELETE FROM shipping_destination_reseller
                                            WHERE id_destination_shipping = :id');
            $query->bindParam('id', htmlspecialchars($i, ENT_QUOTES));
            $query->execute();
            $query->closeCursor();
            
            reallocate_table_id('id_destination_shipping', 'shipping_destination_reseller');      
            
            $query = $connectData->prepare('DELETE FROM shipping_reseller
                                            WHERE id_destination_shipping = :id');
            $query->bindParam('id', htmlspecialchars($i, ENT_QUOTES));
            $query->execute();
            $query->closeCursor();
            
            reallocate_table_id('id_shipping', 'shipping_reseller');
            
            unset($_SESSION['transport_fee_reseller_edit_cboShipmentDestination']);
        }
        catch (Exception $e)
        {
            die("<br>Error : ".$e->getMessage());
        }
    }
    
    if(isset($_POST['bt_cancel_delete_modify_destination'.$i]))
    {
        $_SESSION['transport_fee_reseller_edit_txtModifyDestination'.$i] = true;
        $_SESSION['transport_fee_reseller_edit_txtModifyDestination'.$i] = true;
    }
    
    if(isset($_POST['bt_modify_destination_'.$i.'_x']) || isset($_POST['bt_save_modify_destination'.$i])
            || isset($_POST['bt_delete_modify_destination'.$i])
            || isset($_POST['bt_confirm_delete_modify_destination'.$i])
            || isset($_POST['bt_cancel_delete_modify_destination'.$i]))
    {
        $_SESSION['transport_fee_reseller_edit_id_destination'] = $i;
        $i = $i + $total_destination;
    }
    else
    {
        unset($_SESSION['transport_fee_reseller_edit_id_destination']);
    } 
// </editor-fold>
}

if(isset($_POST['bt_add_part']))
{
    // <editor-fold defaultstate="collapsed" desc="add a part to selected destination into the database">
    $selected_destination = $_POST['cboShipmentDestination'];
    $txtNamePart = trim(htmlspecialchars($_POST['txtNamePart'], ENT_QUOTES));
    $txtMinWeightPart = trim(htmlspecialchars($_POST['txtMinWeightPart'], ENT_QUOTES));
    $txtMaxWeightPart = trim(htmlspecialchars($_POST['txtMaxWeightPart'], ENT_QUOTES));
    $txtFeePart = trim(htmlspecialchars($_POST['txtFeePart'], ENT_QUOTES));
    
    $_SESSION['transport_fee_reseller_edit_cboShipmentDestination'] = $selected_destination;
    
    if(!empty($txtNamePart) || !empty($txtMinWeightPart) || !empty($txtMaxWeightPart) || !empty($txtFeePart))
    {   
        if(is_numeric($txtMinWeightPart) && is_numeric($txtMaxWeightPart) && is_numeric($txtFeePart))
        {
            try
            {
                $query = $connectData->prepare('INSERT INTO shipping_reseller
                                                (id_destination_shipping, part_shipping, 
                                                 min_shipping, max_shipping, fee_shipping)
                                                VALUES(:id_destination, :part, :min, :max, :fee)');
                $query->execute(array(
                                      'id_destination' => $selected_destination,
                                      'part' => $txtNamePart,
                                      'min' => $txtMinWeightPart,
                                      'max' => $txtMaxWeightPart,
                                      'fee' => $txtFeePart
                                      ));
                
                $query->closeCursor();
                
                $query = $connectData->prepare('SELECT id_shipping, part_shipping 
                                                FROM shipping_reseller 
                                                WHERE id_destination_shipping = :id
                                                ORDER BY min_shipping');
                $query->bindParam('id', $selected_destination);
                $query->execute();
                $i = 0;
                $k = 1;
                while($data = $query->fetch())
                {
                    $array_id[$i] = $data[0];   
                    $array_name_old[$i] = $data[1];             
                    $i++;
                }
                $query->closeCursor(); 
                
                for($i = 0; $i < count($array_id); $i++)
                {
                   $array_name_new[$i] = preg_replace('#^[0-9]$#', $k, $array_name_old[$i]);;
                   $k++;
                   $query = $connectData->prepare('UPDATE shipping_reseller
                                                   SET part_shipping = :name
                                                   WHERE id_shipping = :id');
                   $query->execute(array(
                                         'name' => $array_name_new[$i],
                                         'id' => $array_id[$i]
                                         ));
                
                   $query->closeCursor();
                }
            }
            catch (Exception $e)
            {
                die("<br>Error : ".$e->getMessage());
            }
        }
    }
    
    header('Location: '.$header.$_SESSION['index'].'?page='.$_SESSION['redirect']);// </editor-fold>
}


if(!empty($_SESSION['transport_fee_reseller_edit_cboShipmentDestination']))
{
    // <editor-fold defaultstate="collapsed" desc="allows admin to modify or delete parts according to the selected destination">
    $id_selected_destination = $_SESSION['transport_fee_reseller_edit_cboShipmentDestination'];
   
    try
    {
        $query = $connectData->prepare('SELECT * FROM shipping_reseller
                                        WHERE id_destination_shipping = :id');
        $query->bindParam('id', htmlspecialchars($id_selected_destination, ENT_QUOTES));
        $query->execute();
        
        if(($data = $query->fetch()) == false)
        {
            $BoK_existing_part = false;
            $query->closeCursor();
        }
        else
        {
            $query->execute();
            $BoK_existing_part = true;
            $i = 0;
            while($data = $query->fetch())
            {           
                $array_id_shipping[$i] = $data[0];
                $i++;
            }
            $query->closeCursor();
        }              
    }
    catch (Exception $e)
    {
        die("<br>Error : ".$e->getMessage());
    }
    
    if($BoK_existing_part == true)
    { 
        $BoK_btonclick = null;
        for($i = 0; $i < count($array_id_shipping); $i++)
        {
            if(isset($_POST['bt_modify_shipping_part_'.$array_id_shipping[$i].'_x']))
            {
                $_SESSION['transport_fee_reseller_edit_modifypart'.$array_id_shipping[$i]] = true; 
            }
            else
            {
                unset($_SESSION['transport_fee_reseller_edit_modifypart'.$array_id_shipping[$i]]); 
            }

            if(isset($_POST['bt_delete_shipping_part_'.$array_id_shipping[$i].'_x']))
            {
                $_SESSION['transport_fee_reseller_edit_deletepart'.$array_id_shipping[$i]] = true;
            }
            else
            {
                unset($_SESSION['transport_fee_reseller_edit_deletepart'.$array_id_shipping[$i]]);
            }
            
            if(isset($_POST['bt_modify_shipping_part_'.$array_id_shipping[$i].'_x'])
                     || isset($_POST['bt_delete_shipping_part_'.$array_id_shipping[$i].'_x']))
            {
                if(isset($_POST['bt_modify_shipping_part_'.$array_id_shipping[$i].'_x']))
                {
                   $BoK_display_modify = true; 
                }
                
                if(isset($_POST['bt_delete_shipping_part_'.$array_id_shipping[$i].'_x']))
                {
                   $BoK_display_delete = true;
                }
                $BoK_btonclick = true;
                $BoK_display_add = false;
                unset($_SESSION['transport_fee_reseller_edit_add_special_part']);
            }
            else
            {
                if(empty($BoK_btonclick))
                {
                    $BoK_display_add = true;
                }
            }
        }        
    }
    else
    {
        //$BoK_display_add = false;
    }
    // </editor-fold>
}

for($i = 1; $i <= $total_shipping_part; $i++)
{
    // <editor-fold defaultstate="collapsed" desc="allows admins to confirm modification or erasing parts">
    $id_shipping = $i;
    if(isset($_POST['bt_confirm_modifypart_'.$id_shipping]))
    {
        $selected_destination = $_POST['cboShipmentDestination'];
        $txtNameModifyPart = trim(htmlspecialchars($_POST['txtNameModifyPart'], ENT_QUOTES));
        $txtMinWeightModifyPart = trim(htmlspecialchars($_POST['txtMinWeightModifyPart'], ENT_QUOTES));
        $txtMaxWeightModifyPart = trim(htmlspecialchars($_POST['txtMaxWeightModifyPart'], ENT_QUOTES));
        $txtFeeModifyPart = trim(htmlspecialchars($_POST['txtFeeModifyPart'], ENT_QUOTES));
        
        if(!empty($txtNameModifyPart) || !empty($txtMinWeightModifyPart) || !empty($txtMaxWeightModifyPart) || !empty($txtFeeModifyPart))
        {   
            if(is_numeric($txtMinWeightModifyPart) && is_numeric($txtMaxWeightModifyPart) && is_numeric($txtFeeModifyPart))
            {
                try
                {
                    $query = $connectData->prepare('UPDATE shipping_reseller 
                                                    SET part_shipping = :part,
                                                        min_shipping = :min,
                                                        max_shipping = :max,
                                                        fee_shipping = :fee
                                                    WHERE id_shipping = :id');
                    $query->execute(array(
                                          'part' => $txtNameModifyPart,
                                          'min' => $txtMinWeightModifyPart,
                                          'max' => $txtMaxWeightModifyPart,
                                          'fee' => $txtFeeModifyPart,
                                          'id' => $id_shipping
                                          ));

                    $query->closeCursor();
                    unset($_SESSION['transport_fee_reseller_edit_modifypart'.$id_shipping]);
                }
                catch (Exception $e)
                {
                    die("<br>Error : ".$e->getMessage());
                }
            }
        }

        $i = $total_shipping_part + 1;
    }
    
    if(isset($_POST['bt_cancel_modifypart_'.$i]))
    {
        $i = $total_shipping_part + 1;
        
        unset($_SESSION['transport_fee_reseller_edit_modifypart'.$id_shipping]);
    }
    
    if(isset($_POST['bt_confirm_deletepart_'.$id_shipping]))
    {   
        
        try
        {
            $query = $connectData->prepare('DELETE FROM shipping_reseller
                                            WHERE id_shipping = :id');
            $query->bindParam('id', htmlspecialchars($id_shipping, ENT_QUOTES));
            $query->execute();

            //reallocate_table_id_special('id_shipping', 'shipping', 'part_shipping', 'min_shipping');
            
            $query->closeCursor();
            unset($_SESSION['transport_fee_reseller_edit_deletepart'.$id_shipping]);
        }
        catch (Exception $e)
        {
            die("<br>Error : ".$e->getMessage());
        }

        $i = $total_shipping_part + 1;
    }
    
    if(isset($_POST['bt_cancel_deletepart_'.$i]))
    {
        $i = $total_shipping_part + 1;
        
        unset($_SESSION['transport_fee_reseller_edit_deletepart'.$id_shipping]);
    }// </editor-fold>
}

// <editor-fold defaultstate="collapsed" desc="Allows admin to add a special part">
if(isset($_POST['bt_add_special_part']))
{
   $selected_destination = $_POST['cboShipmentDestination'];
    
   $_SESSION['transport_fee_reseller_edit_cboShipmentDestination'] = $selected_destination;
   $_SESSION['transport_fee_reseller_edit_add_special_part'] = true; 
}

if(isset($_POST['bt_cancel_special_part']))
{
    unset($_SESSION['transport_fee_reseller_edit_add_special_part']);
}

if(isset($_POST['bt_save_special_part']))
{
    $selected_destination = $_POST['cboShipmentDestination'];
    $selected_type_special = $_POST['cboTypeSpecialPart'];
    $txtDescSpecialPart = trim(htmlspecialchars($_POST['txtDescSpecialPart'], ENT_QUOTES));
    $txtValueSpecialPart = trim(htmlspecialchars($_POST['txtValueSpecialPart'], ENT_QUOTES));
    
    if(!empty($txtDescSpecialPart) || !empty($txtValueSpecialPart))
    {   
        try
        {
            $query = $connectData->prepare('INSERT INTO shipping_special_reseller
                                            (id_destination_shipping, type_special_shipping,
                                             description_special_shipping, value_special_shipping)
                                             VALUES (:id_destination, :type, :desc, :value)');
            $query->execute(array(
                                      'id_destination' => $selected_destination,
                                      'type' => $selected_type_special,
                                      'desc' => $txtDescSpecialPart,
                                      'value' => $txtValueSpecialPart
                                      ));
                
            $query->closeCursor();
        }
        catch (Exception $e)
        {
            die("<br>Error : ".$e->getMessage());
        }
    }
    
    unset($_SESSION['transport_fee_reseller_edit_add_special_part']);
}// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Allows admin to modify/delete a special part">
for($i = 1; $i <= $total_special_part; $i++)
{
    
    $id_special = $i;    
    
    if(isset($_POST['bt_delete_special_shipping_part_'.$id_special.'_x']) 
            || isset($_POST['bt_modify_special_shipping_part_'.$id_special.'_x']))
    {
        $i =  $total_special_part + 1;
        $BoK_display_add = false;
        $BoK_display_modify = false;
        $BoK_display_delete = false;
        $BoK_display_special = false;
        
        if(isset($_POST['bt_modify_special_shipping_part_'.$id_special.'_x']))
        {
            $BoK_display_special_modify = true;
            $BoK_display_special_delete = false;
        }
        
        if(isset($_POST['bt_delete_special_shipping_part_'.$id_special.'_x']))
        {
            $BoK_display_special_delete = true;
            $BoK_display_special_modify = false;;
        }
    }
    else
    {
        $BoK_display_special_modify = false;
        $BoK_display_special_delete = false;
    }
    
}

for($i = 1; $i <= $total_special_part; $i++)
{
    $id_special = $i;    
    
    if(isset($_POST['bt_cancel_modify_special_part_'.$id_special]))
    {
        $BoK_display_special_modify = false;
        $BoK_display_add = true;
    }
    
    if(isset($_POST['bt_cancel_delete_special_part_'.$id_special]))
    {
        $BoK_display_special_delete = false;
        $BoK_display_add = true;
    }
    
    if(isset($_POST['bt_save_modify_special_part_'.$id_special]))
    {
        $selected_type_special = $_POST['cboTypeSpecialPart'];
        $txtDescSpecialPart = trim(htmlspecialchars($_POST['txtDescSpecialPart'], ENT_QUOTES));
        $txtValueSpecialPart = trim(htmlspecialchars($_POST['txtValueSpecialPart'], ENT_QUOTES));
        
        if(!empty($txtDescSpecialPart) && !empty($txtValueSpecialPart))
        {
            try
            {
                $query = $connectData->prepare('UPDATE shipping_special_reseller
                                                SET type_special_shipping = :type,
                                                    description_special_shipping = :desc,
                                                    value_special_shipping = :value
                                                WHERE id_special_shipping = :id');
                $query->execute(array(
                                      'type' => $selected_type_special,
                                      'desc' => $txtDescSpecialPart,
                                      'value' => $txtValueSpecialPart,
                                      'id' => $id_special
                                      ));
                $query->closeCursor();
                
                $BoK_display_special_modify = false;
                $BoK_display_add = true;
            }
            catch (Exception $e)
            {
                die("<br>Error : ".$e->getMessage());
            }
        }
    }
    
    if(isset($_POST['bt_save_delete_special_part_'.$id_special]))
    {
        try
        {
            $query = $connectData->prepare('DELETE FROM shipping_special_reseller
                                            WHERE id_special_shipping = :id');
            $query->bindParam('id', htmlspecialchars($id_special));
            $query->execute();
            $query->closeCursor();

            reallocate_table_id('id_special_shipping', 'shipping_special_reseller');
            
            $BoK_display_special_delete = false;
            $BoK_display_add = true;
        }
        catch (Exception $e)
        {
            die("<br>Error : ".$e->getMessage());
        }     
    }

}// </editor-fold>

include($backoffice_html_skeleton_part1); 

?>

<TABLE width="100%" border="0">
    <form method="post">
    <td id="center_title" colspan="2">
        Gestion des frais de transport pour les Revendeurs
    </td>
    
    <tr><td colspan="2"><hr></hr></td></tr>
        <tr>
            <td colspan="2">
                <span id="center_intro">
                    Pour changer le nom de la destination (visible par tous les visiteurs) ainsi que la TVA applicable.<br/>Allez sur <a id="link" href="index_backoffice.php?page=transport_fee_edit">Frais de transport/TVA</a> et Cliquez sur l'icône du stylo situé à droite de la destination choisie.<br/>
                    En outre, si vous créez une nouvelle destination pour les particuliers, elle sera automatiquement créée pour les revendeurs.
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px dashed lightgrey;"></td>
        </tr>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>
    
        <td id="center_subtitle" width="30%">
            Destination
        </td>
        <td><SELECT name="cboShipmentDestination" onchange="OnChange('bt_choose_shipment_destination')">
            <option value="select" <?php if(empty($_SESSION['transport_fee_reseller_edit_cboShipmentDestination'])){ echo('selected'); }else{ echo(null); } ?>>-- Sélectionnez une destination --</option>            
<?php
try
{
    $query = $connectData->prepare('SELECT * FROM shipping_destination_reseller');
    $query->execute();
    
    while($data = $query->fetch())
    {
        echo('<option value="'.$data[0].'" ');
        
        if(!empty($_SESSION['transport_fee_reseller_edit_cboShipmentDestination']))
        {
            if($_SESSION['transport_fee_reseller_edit_cboShipmentDestination'] == $data[0])
            {
                echo('selected');
            }
            else
            {
                echo(null);
            }
        }
        
        echo('>'.$data[1].'</option>');         
    }
}
catch (Exception $e)
{
    die("<br>Error : ".$e->getMessage());
}
?>
        </SELECT>
        <input type="submit" style="display: none" id="bt_choose_shipment_destination" name="bt_choose_shipment_destination" value="Envoyer"></input>
        
<?php
        if(!empty($_SESSION['transport_fee_reseller_edit_cboShipmentDestination']) && $_SESSION['transport_fee_reseller_edit_cboShipmentDestination'] != 'new' && $_SESSION['transport_fee_reseller_edit_cboShipmentDestination'] != 'select')
        {
           $Bok_display_fee = true; 
           $number_part = 0;
           
           try
           {
               $query = $connectData->prepare('SELECT * FROM shipping_destination_reseller WHERE id_destination_shipping = :id');
               $query->bindParam('id', htmlspecialchars($_SESSION['transport_fee_reseller_edit_cboShipmentDestination'], ENT_QUOTES));
               $query->execute();
               
               if(($data = $query->fetch()) != false)
               {
                   $id_modify_destination = $data[0];
                   $name_modify_destination = $data[1];
               }
               $query->closeCursor();
               
               $query = $connectData->prepare('SELECT *, COUNT(id_shipping) FROM shipping_reseller WHERE id_destination_shipping = :id');
               $query->bindParam('id', htmlspecialchars($_SESSION['transport_fee_reseller_edit_cboShipmentDestination'], ENT_QUOTES));
               $query->execute();
               
               if(($data = $query->fetch()) != false)
               {
                  $query->execute();
                  while($data = $query->fetch())
                  {
                      $number_part = $data['COUNT(id_shipping)'] + 1;
                  }
               }
               else
               {
                  $number_part = 1;  
               }
               $query->closeCursor();
           }
           catch (Exception $e)
           {
               die("<br>Error : ".$e->getMessage());
           }
        }
        else
        {
            $Bok_display_fee = false;
        }
?>
    </td>
    <?php
    if(!empty($_SESSION['transport_fee_reseller_edit_txtNewDestination']) && $_SESSION['transport_fee_reseller_edit_txtNewDestination'] == true)
    {
    ?>
        <tr></tr>
        
            <td id="center_subtitle">
                Nouvelle destination
            </td>
            <td>
                <input style="width: 270px;" type="text" name="txtNewDestination"></input>
            </td>
            
            <tr></tr>
            
            <td></td>
            <td>
                <input type="submit" name="bt_save_new_destination" value="Créer"></input>
            </td>
    <?php
    }

    if(!empty($_SESSION['transport_fee_reseller_edit_id_destination']))
    {
        $i = $_SESSION['transport_fee_reseller_edit_id_destination'];
        
        if(!empty($_SESSION['transport_fee_reseller_edit_txtModifyDestination'.$i]) && $_SESSION['transport_fee_reseller_edit_txtModifyDestination'.$i] == true)
        {
            try
            {
                $query = $connectData->prepare('SELECT * FROM shipping_destination_reseller WHERE id_destination_shipping = :id');
                $query->bindParam('id', htmlspecialchars($i, ENT_QUOTES));
                $query->execute();
                
                if(($data = $query->fetch()) != false)
                {
                    $name_destination = $data[1];
                }
                $query->closeCursor();
                
                $query = $connectData->prepare('SELECT * FROM tax WHERE id_destination_shipping = :id');
                $query->bindParam('id', htmlspecialchars($i, ENT_QUOTES));
                $query->execute();
                
                if(($data = $query->fetch()) != false)
                {
                    $tax_destination = $data['value_tax'];
                }
                $query->closeCursor();
            }
            catch (Exception $e)
            {
                die("<br>Error : ".$e->getMessage());
            }
        ?>
            <tr></tr>
            
                <td id="center_subtitle">
                    Modification destination
                </td>
                <td>
                    <input style="width: 270px;" type="text" name="txtModifyDestination<?php echo($i); ?>" value="<?php echo($name_destination); ?>"></input>
                </td>
                
            <tr></tr>
            
                <td id="center_subtitle">
                    Modification TVA
                </td>
                <td>
                    <input style="width: 50px;" type="text" name="txtModifyTVA<?php echo($i); ?>" value="<?php echo($tax_destination); ?>"></input><span id="center_text">%</span>
                </td>
                
       <?php
           if(empty($_SESSION['transport_fee_reseller_edit_askDeleteModifyDestination'.$i]))
           {
       ?>
                <tr></tr>
                
                <td></td>
                <td>
                    <input type="submit" name="bt_save_modify_destination<?php echo($i); ?>" value="Modifier"></input>
                    &nbsp;
                    <input type="submit" name="bt_delete_modify_destination<?php echo($i); ?>" value="Supprimer"></input>
                </td>
        <?php
            }
            else
            {
        ?>
                <tr></tr>
            
                <td></td>
                <td>
                    <span id="center_text">Vous supprimerez également les tarifs qui sont liés à cette destination, confirmer ?</span>
                    <br clear="left">
                    <input type="submit" name="bt_confirm_delete_modify_destination<?php echo($i); ?>" value="Oui"></input>
                    &nbsp;
                    <input type="submit" name="bt_cancel_delete_modify_destination<?php echo($i); ?>" value="Annuler"></input>
                </td>
        <?php
            }
        }
    }

    if($Bok_display_fee === true)
    {
        $id_selected_destination = $_SESSION['transport_fee_reseller_edit_cboShipmentDestination'];
        

        if($BoK_display_add == true && empty($_SESSION['transport_fee_reseller_edit_add_special_part']))
        {
?>
            <tr style="height: 12px;"></tr>

            <td colspan="2"><TABLE width="100%" border="0" style="border: 1px solid cornflowerblue; padding: 3px; border-radius: 6px;">
            <tr>                  
                <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Nouvelle tranche</span></div></td>
                <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Poids Min (gr.)</span></div></td>
                <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Poids Max (gr.)</span></div></td>
                <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Tarif</span></div></td>
                <td><span></span></td>
            </tr>
            <tr>
                <td id="center_text_table"><input id="textfield_cells" type="text" name="txtNamePart" value="<?php echo('tranche '.$number_part); ?>"/></td>
                <td id="center_text_table"><input id="textfield_cells" type="text" name="txtMinWeightPart"/></td>
                <td id="center_text_table"><input id="textfield_cells" type="text" name="txtMaxWeightPart"/></td>
                <td id="center_text_table"><input id="textfield_cells" type="text" name="txtFeePart"/></td>
                <td id="center_text_table"><input style="width: 100px;" type="submit" name="bt_add_part" value="Ajouter"></input></td>
            </tr>               
            </TABLE></td>
    <?php       
        }
        else
        {  
            if(!empty($_SESSION['transport_fee_reseller_edit_add_special_part']))
            {
            ?>
               <tr style="height: 12px;"></tr>

               <td colspan="2"><TABLE width="100%" border="0" style="border: 1px solid cornflowerblue; padding: 3px; border-radius: 6px;">
                        <tr>                            
                            <td id="center_text_table" width="50%" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Nouvelle tranche spéciale</span></div></td>
                            <td id="center_text_table" width="50%" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Description</span></div></td>
                            <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Seuil</span></div></td>
                            <td id="center_subtitle" align="center"><input style="width: 100px;" type="submit" name="bt_cancel_special_part" value="Annuler"></input></td>
                        </tr>
                        <tr>                     
                            <td id="center_text_table">
            <?php 
            try
            {
                $query = $connectData->prepare('SELECT * FROM shipping_special_reseller
                                                WHERE id_destination_shipping = :id');
                $query->bindParam('id', htmlspecialchars($id_selected_destination, ENT_QUOTES));
                $query->execute();
                $i = 0;
                while($data = $query->fetch())
                {
                    $type_special_part[$i] = $data['type_special_shipping'];
                    $i++;
                }
            }
            catch(Exception $e)
            {
                die('<br>Error: '.$e->getMessage());
            }
            ?>
                                <SELECT style="width: 100%;" name="cboTypeSpecialPart">
                                <?php
                                if(!empty($type_special_part[0]))
                                {
                                    for($i = 0; $i < count($type_special_part); $i++)
                                    {
                                    ?>
                                        <option value="freeshippingEuro" <?php if(!empty($type_special_part[$i]) && $type_special_part[$i] == 'freeshippingEuro'){ echo('disabled'); }else{ echo(null); } ?>>Frais de port offert (Monétaire)</option> 
                                        <option value="freeshippingKilo" <?php if(!empty($type_special_part[$i]) && $type_special_part[$i] == 'freeshippingKilo'){ echo('disabled'); }else{ echo(null); } ?>>Frais de port offert (Poids)</option>            
                                    <?php
                                    }
                                }
                                else
                                {
                                ?>
                                    <option value="freeshippingEuro">Frais de port offert (Monétaire)</option> 
                                    <option value="freeshippingKilo">Frais de port offert (Poids)</option>  
                                <?php
                                }
                                ?>
                                </SELECT>
                            </td>
                            <td id="center_text_table"><input id="textfield_cells" type="text" name="txtDescSpecialPart"/></td>
                            <td id="center_text_table"><input id="textfield_cells" type="text" name="txtValueSpecialPart"/></td>
                            <td id="center_text_table" align="center">  
                                <input style="width: 100px;" type="submit" name="bt_save_special_part" value="Ajouter"></input>
                            </td>
                        </tr>               
                </TABLE></td> 
            <?php
            }
        }
     
        
    
        try
        {  
            $query = $connectData->prepare('SELECT * FROM shipping_special_reseller
                                            WHERE id_destination_shipping = :id');
            $query->bindParam('id', htmlspecialchars($id_selected_destination, ENT_QUOTES));
            $query->execute();
            
            if(($data = $query->fetch()) == false)
            {
                
            }
            else
            {
                $query->execute();
                
                while($data = $query->fetch())
                {
                    if($BoK_display_special_modify == true)
                    {
                    ?>
                        <tr style="height: 12px;"></tr>

                        <td colspan="2"><TABLE width="100%" border="0" style="border: 1px solid cornflowerblue; padding: 3px; border-radius: 6px;">
                        <tr>                            
                            <td id="center_text_table" width="50%" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Modifier tranche spéciale</span></div></td>
                            <td id="center_text_table" width="50%" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Description</span></div></td>
                            <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Seuil</span></div></td>
                            <td id="center_subtitle" align="center"><input style="width: 100px;" type="submit" name="bt_cancel_modify_special_part_<?php echo($data[0]); ?>" value="Annuler"></input></td>
                        </tr>
                        <tr>                     
                            <td id="center_text_table">
                                <SELECT style="width: 100%;" name="cboTypeSpecialPart">
                                    <option value="freeshippingEuro" <?php if($data['type_special_shipping'] == 'freeshippingEuro'){ echo('selected'); }else{ echo(null); } ?>>Frais de port offert (Monétaire)</option> 
                                    <option value="freeshippingKilo" <?php if($data['type_special_shipping'] == 'freeshippingKilo'){ echo('selected'); }else{ echo(null); } ?>>Frais de port offert (Poids)</option>
                                </SELECT>
                            </td>
                            <td id="center_text_table"><input style="direction: ltr;" id="textfield_cells" type="text" name="txtDescSpecialPart" value="<?php echo($data['description_special_shipping']); ?>"/></td>
                            <td id="center_text_table"><input id="textfield_cells" type="text" name="txtValueSpecialPart" value="<?php echo($data['value_special_shipping']); ?>"/></td>
                            <td id="center_text_table" align="center">  
                                <input style="width: 100px;" type="submit" name="bt_save_modify_special_part_<?php echo($data[0]); ?>" value="Modifier"></input>
                            </td>
                        </tr>               
                        </TABLE></td>
                    <?php 
                    }
                    
                    if($BoK_display_special_delete == true)
                    {
                    ?>
                        <tr style="height: 12px;"></tr>

                        <td colspan="2"><TABLE width="100%" border="0" style="border: 1px solid cornflowerblue; padding: 3px; border-radius: 6px;">
                        <tr>                            
                            <td id="center_text_table" width="50%" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Supprimer tranche spéciale</span></div></td>
                            <td id="center_text_table" width="50%" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Description</span></div></td>
                            <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Seuil</span></div></td>
                            <td id="center_subtitle" align="center"><input style="width: 100px;" type="submit" name="bt_cancel_delete_special_part_<?php echo($data[0]); ?>" value="Annuler"></input></td>
                        </tr>
                        <tr>                     
                            <td id="center_text_table">
                                <SELECT style="width: 100%;" name="cboTypeSpecialPart" disabled>
                                    <option value="freeshippingEuro" <?php if($data['type_special_shipping'] == 'freeshippingEuro'){ echo('selected'); }else{ echo(null); } ?>>Frais de port offert (Monétaire)</option> 
                                    <option value="freeshippingKilo" <?php if($data['type_special_shipping'] == 'freeshippingKilo'){ echo('selected'); }else{ echo(null); } ?>>Frais de port offert (Poids)</option>
                                </SELECT>
                            </td>
                            <td id="center_text_table"><span id="center_text"><?php echo($data['description_special_shipping']); ?></span></td>
                            <td id="center_text_table"><span id="center_text"><?php echo($data['value_special_shipping']); ?></span></td>
                            <td id="center_text_table" align="center">  
                                <input style="width: 100px;" type="submit" name="bt_save_delete_special_part_<?php echo($data[0]); ?>" value="Supprimer"></input>
                            </td>
                        </tr>               
                        </TABLE></td>
                    <?php 
                    }
                }
                
            }
            
            $query = $connectData->prepare('SELECT * FROM shipping_reseller
                                            WHERE id_destination_shipping = :id
                                            ORDER BY min_shipping');
            $query->bindParam('id', htmlspecialchars($id_selected_destination, ENT_QUOTES));
            $query->execute();
            
            if(($data = $query->fetch()) == false)
            {
                
            }
            else
            {
                $query->execute();
                
                while($data = $query->fetch())
                {
                
                    if(!empty($_SESSION['transport_fee_reseller_edit_modifypart'.$data[0]]) && $_SESSION['transport_fee_reseller_edit_modifypart'.$data[0]] === true)
                    {
                        if($BoK_display_modify == true)
                        {
                    ?>
                        <tr style="height: 12px;"></tr>

                        <td colspan="2"><TABLE width="100%" border="0" style="border: 1px solid cornflowerblue; padding: 3px; border-radius: 6px;">
                        <tr>      
                            <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Modifier tranche</span></div></td>
                            <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Poids Min (gr.)</span></div></td>
                            <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Poids Max (gr.)</span></div></td>
                            <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Tarif</span></div></td>
                            <td align="center"><input style="width: 100px;" type="submit" name="bt_cancel_modifypart_<?php echo($data[0]); ?>" value="Annuler"></input></td>
                        </tr>
                        <tr>                            
                            <td id="center_text_table"><input id="textfield_cells" type="text" name="txtNameModifyPart" value="<?php echo($data['part_shipping']); ?>"/></td>
                            <td id="center_text_table"><input id="textfield_cells" type="text" name="txtxtfield_centerame="txtxtfield_centerame="txtxtfield_centera; id="<?php echo($box_general_subtitle);   <td idaxcenter_text_table"><input id="textfield_cells" type="text" name="txtxtfield_centerame="txtxtfield_centerame="txtxtfield_centera; Fe         
                            
  center_text_table"><input id="textfield_cells" type="text" name="txtxtfield_centitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Tarif</inatio</div></td>
                            <td ale" al"center"><input style="width: 100px;" type="sub;" type0]); ?>" value="Annuler"></input>mer"></input>
                            </td>
                 }  </td>
                        </tr>      $query->execute();
                
                while($data = $quext_tabtch())
                {
                
                 xt_tab!empty($_SESSION['transport_fee_reseller_edit_modifypart'.$data[0]]) && $_SESSION['transd>
                    <?php 
      data[0]] === true)
                    {
                        if($BoK_display_modify == true)
                        {
                    ?>
                        <tr style="height: 12px;"></tr>

                        <td colspan="2"><TABLE width="1fypar); ?>" value="Annuler"></input></td>
                                25); ?>">Supprimer tranche spéciale</span></div></td>
                            <td id="center_text_table" width="5       ign="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($t       25); ?>">Supprimer tranche spéciale</span></div></td>
                            <td id="center_text_table" width="5le" alig"center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php ec       25); ?>">Supprimer tranche spéciale</span></div></td>
                            <td id="center_text_table" width="5le" aliaxcenter"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php ec       1e); ?>">Supprimer tranche spéciale</span></div></td>
                            <td id="center_text_table" width="5le" align="center"><div id="<?php echo($box_general_suban id="<?php echo($text_general_subtitle); ?>">Tarif</            /td>
                            <td align="center"><input style="width: 100px;" type="submit" name="bt_cancel_modifypart_<?php echo($dmit" name=$box_general_subtitle); ?>"><span id="<?php ec?>">Supprimerphp echo($data['description_special_   desatist
           <td id="center_t                         <td id="center_text_table"><span id="center_text"><?php echo($dp echo($data['description_special_  <td id="center_text.' gr'                         <td id="center_text_table"><span id="center_text"><?php echo($dp echo($data['description_special_  <td idaxcenter_text.' gr'                         <td id="center_text_table"><span id="center_text"><?php echo($dp echo($data['description_special_ <td id    at        
  center_text, 2).' €'                         <td id="center_text_tablan id="<?php echo($text_general_subtitle); ?>">Tarif</inatio       /td>
                            <td a       "center"><input style="width: 100px;" type="sub0px;" type; ?>" value="Annuler"></input>mer"></input>
                           </td>
                 }  </td>
                        </tr>  }0]] === true)
                    {
                if($BoK_disply($_SESSION['transport_fee_reseller_edit_as        {
 xt"><?php echo(                   ?>
                        <tr style="height: 12px;"></tr>

                        <td colspan="2"><TABLE wfee_reseller_edit_as        {
6xt"><?php echo( >
                    ranche spéciale</span, hk_frochond_a   oach    }
                       <td id="centfrochond_a   oach    }
             <td id$query->fetch()) != fals     lign="center            <input type=alue="Supprimer"></input>
               der="0" style="border: 1px solid cornflowerblue; padding: 3px; border-radius: 6px;">
            <tr>                  
                <td id="center_text_tabT"center"><div id="<?php echo($box_generaler: 1px solid cornflowerblue; padding: 3px; border-radius: 6px;">
            <tr>                  
                <td id="center_text_tabDe (k   gnatmeter"><div id="<?php echo($box_generaer: 1px solid cornflowerblue; padding: 3px; border-radius: 6px;">
            <tr>                  
                <td id="center_text_tabA (k   gnatmeter"><div id="<?php echo($box_generaer: 1px solid cornflowerblue; padding: 3px; border-radius: 6px;">
            <tr>                  
                <td id="center_text_table" align="center"><div id="<?php echo($er: 1px solid cornflowerblue; padding: 3p        {
 px; border-radius: 6px;">
            <tr>                  
                <td id="center_text_tabEdign="center"><div id="<?php echo($box_general_sualue="Supprimer"></input>
               der="0" style="borde                  der="0" style="borduery->fetch()) == false)
          php e la grmptdify_speci   {
                
            }
            else
            {
                 && $_Sphp e la grmptd                 <?php 
                    }
          p        ' la grmptd-      e="heighay;' false)
  alse)
          php e la grmptdify_speci  </td>
                        </tr>                  <?php 
                    }
          p        lue=; false)
  alse)
          php e la grmptdify   ci  </td>
                        </tr>                </tr>                </tr>      ?> fy == true)
                        
              _text_tabfy == true)
               {
             margin-rime  <td co($data['description_special_   desatist
           <td id="center_t            fy == true)
             id="<
             ype; ?>" value="Annuler"></input>mubtitle); r"hei"        
              _text_tabfy == true)
               {
             margin-r"hei    td co($data['description_special_/inved ito_k  l_  <td id="id="center_t            fy == true)
             id="< value="Annuler"></input>mubtitle); r"hei"        
              _text_tabfy == true)
               {
             margin-r"hei    td co($data['description_special_/inved ito_k  l_  <td idaxid="center_t            fy == true)
             id="< value="Annuler"></input>mubtitle); r"hei"        
              _text_tabfy == true)
               {
             margin-r"hei  <td co($data['description_special_ <td id    at        
  center_text, 2).' €'            fy == true)
             id="< value="Annuler"></input>mubtitle); ta['de"        
              _text_tabfy == true)
               {
 rm_delete_moim    ?>">Tarify->fetccenter_ten="center">  
                  src="ghaphics/i/ins/pen16x16.pnglue;t ale" al"ce ter_d ale" al"center"><ine)
               {
pe; ?>" value="Annuler"></input>md="< value="Annuler"></input>mubtitle); ta['de"        
              _text_tabfy == true)
               {
 rm_delete_moim    ?>">Tarify      center_ten="center">  
                  src="ghaphics/i/ins/cross16x16.giflue;t a       "ce ter_          <input style="width: 100px;" type="suid="<?php echo($box_general_sualue="Supprimer">primer"></input>
               deborde    ata = $query->fetch())
                {
                                  $name_destination = $data[1];
            ();
     ?></span></td>
 )         }
        }
     
        
    
        try
        {  
           
            $query = $connectData->pre * FROM shipping_special_reseller
                                                WHERE id_destination_shipping = :id');
                $query->bindPar              $name_destination = $data[1];
                      }
        }
     
        
    
        try
        {  
            $query = $connectData->prepare('SE    
    
        try
        {  
                    t offert (Monétaire) * FROM shipping_special_reseller
                                                WHERE id_destination_shipping = :id');
                $query->bindPar              $nandParam('id', htmlspecialchars($i, ENT_QUOTES));
                $query->execu);
                $query->bindPardParam('id', htmlspecia            
            }
            else
            dit_modifypart'.$data[0]]) && $_SESS e la grmptd                 <?php 
                      }
                p        ' la grmptd-      e="heighay;' false)
  alse)
              php e la grmptdify_speci  </td>
             {
                   tr>                  <?php 
                      }
                p        lue=; false)
  alse)
              php e la grmptdify   ci  </td>
             {
                   tr>                      tr>     rais de port offert (Monétaire)</option> 
                      <?php 
                      }
                p uestxfert (Moify' €' false)
  alse)
              p <td id    atify2i  </td>
             {
                   tr>                  <?php 
                      }
                ais de port offert (Monétaire)</option> 
                          <?php 
                      }
                   p uestxfert (Moify' kg';ta['value_special_shipping']); ?>p <td id    atify4i  </t </td>
             {
                   tr>                      <?php 
                          }
                   p uestxfert (Moifylue=;           }
                   p <td id    atify0i  </t </td>
             {
                   tr>            </td>
             {
    
  </td>
          >      ?> fy == true)
                            
              _text_tabfy == true)
               {
  {
             margin-rime  <td co($data['descriptiTcenter"><div id="<?phpe="width: 100px;" type="submit" name="bt_save_delete_specialput>mubtitle); ta['de"        
              _text_ta        {
 abfy == true)
               {
  {
      ($data['description_special_  <td i               </td>
                     ="width: 100px;" type="submit" name="bt_save_delete_specialput>mubtitle); r"hei"        
              _text_tabfy == true)
               {
  {
             margin-r"hei  <td co($data['description_special_ <td id    at        g']); ?></span></td>
   , p <td id    at).p uestxfert (Mo            ="width: 100px;" type="submit" namdth: 100px;" type="submit          </td>
             {
  put>mubtitle); ta['de"        
              _text_tabfy == true)
               {
  {
 rm_delete_moim    ?>">Tarify->fetccert (Mocenter_ten="center">  
                  src="ghaphics/i/ins/pen16x16.pnglue;t ale" al"ce ter_d ale" al"center"><ine)
               {
pe; ?>" value="Annuler"></input> mit" name="bt_save_delete_specialput>mubtitle); ta['de"        
              _text_tabfy == true)
               {
  {
 rm_delete_moim    ?>">Tarify      cert (Mocenter_ten="center">  
                  src="ghaphics/i/ins/cross16x16.giflue;t a       "ce ter_          <input style="width: 100px;" type="su mit" name="width: 100px;" type="suer"></input>
               debord           </td>
                 )
  i  </td>
                        </tr>             </tr>               {
 ut>mer"></input>
                
                
                                       </td>
      ax_destination = $data['value_ta             }
                $query->closeCursor();
          echo('selecdestination); ?>"></input><span id="center_text">%</shipmentDestination'];
        r>     ];
                   if($BoK_disply($_SESfee_reseller_edit_as        {
 xt"><?php echo(  submit" name="bt_confirm_delete_modify_destination<shiext_table" align="center">  
="center"><div id=
                    <input type Sfee_reseller_="submit" );
          echo('s        ec r>   >
                
                
    </    >
mer"></i

<!--im" <?pmy java      --i

<      ="txtxtfiel/java        src="      .js
         i

 ?>>Franclud    la oestce_    _sk    one" al2     