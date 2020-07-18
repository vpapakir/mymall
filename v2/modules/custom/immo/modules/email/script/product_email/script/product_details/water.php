<?php
#water
if($customgetinfo_displayvalue[26] == 1)
{
    if(!empty($customgetinfo_water_other))
    {
        $customgetinfo_water_other = split_string($customgetinfo_water_other, '$');
    }
    
    if(!empty($customgetinfo_water_other))
    {
        $message .= '<tr>    
                         <td  class="font_subtitle" align="left" width="'.$custom_1column_width.'" style="vertical-align: top;">
                            '.give_translation('displayvalueimmo.water_immo_product', 'false', $config_showtranslationcode).'
                         </td>
                         <td align="left" class="font_main">';
 
        for($i = 0, $count = count($customgetinfo_water_other); $i < $count; $i++)
        {
            $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                               WHERE id_cdreditor = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $customgetinfo_water_other[$i]);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $message .= $data[0];
            }
            $query->closeCursor();

            if($i < ($count - 1))
            {
                $message .= ', ';
            }
        }
        $message .=  '</td>
                  </tr>';
    }
}
?>
