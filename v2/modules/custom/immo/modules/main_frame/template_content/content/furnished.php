<?php
#furnished
if($customgetinfo_displayvalue[31] == 1 && $customgetinfo_furnished_other != 'select')
{
?>
    <tr>    
        <td align="left" class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;">
<?php
        give_translation('displayvalueimmo.furnished_product_immo');
?>
        </td>
        <td align="left" class="font_main">
<?php  

            $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                               WHERE id_cdreditor = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $customgetinfo_furnished_other);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                echo($data[0]);
            }
            $query->closeCursor();         
?>
        </td>
    </tr>
<?php            
}
?>
