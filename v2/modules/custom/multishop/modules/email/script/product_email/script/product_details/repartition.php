<?php
#floor, cellar, loft
if(($customgetinfo_displayvalue[13] == 1 && $customgetinfo_numfloor > 0) 
        || ($customgetinfo_displayvalue[11] == 1 && $customgetinfo_surfacecellar > 0)
        || ($customgetinfo_displayvalue[12] == 1 && $customgetinfo_surfaceloft > 0)
        || ($customgetinfo_displayvalue[15] == 1 && $customgetinfo_numsleeps > 0)
        || ($customgetinfo_displayvalue[16] == 1 && $customgetinfo_numbath > 0)
        || ($customgetinfo_displayvalue[17] == 1 && $customgetinfo_numwc > 0)
        || ($customgetinfo_displayvalue[14] == 1 && ($count_totalrooms > 0 || $customgetinfo_numrooms > 0))
        || ($customgetinfo_displayvalue[18] == 1 && ($count_totalouthouses > 0 || $customgetinfo_numouthouses > 0)))
{
    $count_totalrooms_bok_knownroom = false;
    $count_totalrooms_bok_knownouthouses = false;
    #rooms
    if($customgetinfo_displayvalue[14] == 1)
    {
        $count_totalrooms = null;
        $details_totalrooms = null;
        $countdoublon_piecesin_interior = split_string($customgetinfo_piecesin_interior, '#');
        $customgetinfo_piecesin_interior = split_string($customgetinfo_piecesin_interior, '#');

        for($i = 0, $count = count($customgetinfo_piecesin_interior); $i < $count; $i++)
        {
            $customgetinfo_piecesin_interior[$i] = split_string($customgetinfo_piecesin_interior[$i], '$');

            if($customgetinfo_piecesin_interior[$i][2] != 'select' && !empty($customgetinfo_piecesin_interior[$i][2]))
            {
                $count_totalrooms_bok_knownroom = true;
                $count_totalrooms += 1;
            }
            else
            {
                $count_totalrooms += 1;
            }

        }

        //$countdoublon_piecesin_interior = array_count_values($countdoublon_piecesin_interior);
    }
    
    #outhouses
    if($customgetinfo_displayvalue[18] == 1)
    {
        $count_totalouthouses = null;
        $details_totalouthouses = null;
        $countdoublon_piecesout_exterior = split_string($customgetinfo_piecesout_exterior, '#');
        $customgetinfo_piecesout_exterior = split_string($customgetinfo_piecesout_exterior, '#');

        for($i = 0, $count = count($customgetinfo_piecesout_exterior); $i < $count; $i++)
        {
            $customgetinfo_piecesout_exterior[$i] = split_string($customgetinfo_piecesout_exterior[$i], '$');

            if($customgetinfo_piecesout_exterior[$i][2] != 'select' && !empty($customgetinfo_piecesout_exterior[$i][2]))
            {
                $count_totalrooms_bok_knownouthouses = true;
                $count_totalouthouses += 1;
            }
            else
            {
                $count_totalouthouses += 1;
            }

        }
    
        //$countdoublon_piecesout_exterior = array_count_values($countdoublon_piecesout_exterior);
    }
    
    $message .= '<tr>    
                         <td  class="font_subtitle" align="left" width="'.$custom_1column_width.'" style="vertical-align: top;" colspan="2">
                            '.give_translation('displayvalueimmo.repartition_product_immo', 'false', $config_showtranslationcode).'
                         </td>
                         </tr>
                         <tr>
                         <td align="left" class="font_main" colspan="2">';

    if($customgetinfo_displayvalue[14] == 1 && ($count_totalrooms > 0 || $customgetinfo_numrooms > 0))
    {
        $message .= $count_totalrooms.' '; 
        $message .= give_translation('displayvalueimmo.piecesnb_product_immo', 'false', $config_showtranslationcode); 
        $message .= ', ';
    }

    if($customgetinfo_displayvalue[18] == 1 && ($count_totalouthouses > 0 || $customgetinfo_numouthouses > 0))
    {
        $message .= $count_totalouthouses.' '; 
        $message .= give_translation('displayvalueimmo.outhousesnb_product_immo', 'false', $config_showtranslationcode); 
        $message .= ', ';
    }

    if($customgetinfo_displayvalue[15] == 1 && $customgetinfo_numsleeps > 0)
    {
        $message .= $customgetinfo_numsleeps.' '; 
        $message .= give_translation('displayvalueimmo.numsleep_product_immo', 'false', $config_showtranslationcode);
        $message .= ', ';
    }

    if($customgetinfo_displayvalue[16] == 1 && $customgetinfo_numbath > 0)
    {
        $message .= $customgetinfo_numbath.' '; 
        $message .= give_translation('displayvalueimmo.numbath_product_immo', 'false', $config_showtranslationcode); 
        $message .= ', ';
    }

    if($customgetinfo_displayvalue[17] == 1 && $customgetinfo_numwc > 0)
    {
        $message .= $customgetinfo_numwc.' '; 
        $message .= give_translation('displayvalueimmo.numwc_product_immo', 'false', $config_showtranslationcode); 
        $message .= ', ';
    }

    if($customgetinfo_displayvalue[13] == 1 && $customgetinfo_numfloor > 0)
    {
        $message .= $customgetinfo_numfloor.' '; 

        if($customgetinfo_numfloor > 1)
        {
            $message .= give_translation('displayvalueimmo.levelnb_product_immo', 'false', $config_showtranslationcode);
        }
        else
        {
            $message .= give_translation('displayvalueimmo.Slevelnb_product_immo', 'false', $config_showtranslationcode);
        } 

        if(($customgetinfo_displayvalue[11] == 1 && $customgetinfo_surfacecellar > 0)
                || ($customgetinfo_displayvalue[12] == 1 && $customgetinfo_surfaceloft > 0))
        {
            $message .= ', ';
        }

    }

    if($customgetinfo_displayvalue[11] == 1 && $customgetinfo_surfacecellar > 0)
    {
        $message .= give_translation('displayvalueimmo.cellar_product_immo', 'false', $config_showtranslationcode);
        $message .= '&nbsp;('.$customgetinfo_surfacecellar.'m²)';

        if($customgetinfo_displayvalue[12] == 1 && $customgetinfo_surfaceloft > 0)
        {
            $message .= ', ';
        }
    }

    if($customgetinfo_displayvalue[12] == 1 && $customgetinfo_surfaceloft > 0)
    {
        $message .= give_translation('displayvalueimmo.loft_product_immo', 'false', $config_showtranslationcode);
        $message .= '&nbsp;('.$customgetinfo_surfaceloft.'m²)'; 
    }
    
    $message .=  '</td>
                </tr>
                <tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                </tr>';           
}
?>
