<?php
if(isset($_POST['bt_add_city_geo']))
{
    unset($_SESSION['msg_cdrgeo_done']);
    
    unset($_SESSION['msg_cdrgeo_cboDistrictCDRgeoCity'],
            $_SESSION['msg_cdrgeo_txtNameCDRgeoCity'],
            $_SESSION['msg_cdrgeo_upload_city']);
    
    unset($_SESSION['cdrgeo_hiddenidCDRgeoCity'],
            $_SESSION['cdrgeo_txtZipCDRgeoCity']);

    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
       unset($_SESSION['cdrgeo_txtNameCDRgeoCity'.$main_activatedidlang[$i]]); 
    }

    unset($_SESSION['cdrgeo_cboDistrictCDRgeoCity'],
            $_SESSION['cdrgeo_txtLatitudeCDRgeoCity'],
            $_SESSION['cdrgeo_txtLongitudeCDRgeoCity'],
            $_SESSION['cdrgeo_txtINSEECDRgeoCity'],
            $_SESSION['cdrgeo_txtPopulationCDRgeoCity'],
            $_SESSION['cdrgeo_txtTaxhabCDRgeoCity'],
            $_SESSION['cdrgeo_cdreditor_typecity_cdrgeo'],
            $_SESSION['cdrgeo_areaRemarkCDRgeoCity'],
            $_SESSION['cdrgeo_cboStatusCDRgeoCity']);
    
    
    $Bok_cdrgeo_insert = true;
    
    $cdrgeo_zip_city = trim(htmlspecialchars($_POST['txtZipCDRgeoCity'], ENT_QUOTES));
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $cdrgeo_name_city[$i] = trim(htmlspecialchars(addslashes($_POST['txtNameCDRgeoCity'.$main_activatedidlang[$i]]), ENT_QUOTES));
    }
    
    $cdrgeo_parent_city = htmlspecialchars($_POST['cboDistrictCDRgeoCity'], ENT_QUOTES);
    $cdrgeo_latitude_city = trim(htmlspecialchars($_POST['txtLatitudeCDRgeoCity'], ENT_QUOTES));
    $cdrgeo_longitude_city = trim(htmlspecialchars($_POST['txtLongitudeCDRgeoCity'], ENT_QUOTES));
    $cdrgeo_insee_city = trim(htmlspecialchars($_POST['txtINSEECDRgeoCity'], ENT_QUOTES));
    $cdrgeo_population_city = trim(htmlspecialchars($_POST['txtPopulationCDRgeoCity'], ENT_QUOTES));
    $cdrgeo_taxhab_city = trim(htmlspecialchars($_POST['txtTaxhabCDRgeoCity'], ENT_QUOTES));
    $cdrgeo_type_city = htmlspecialchars($_POST['cdreditor_typecity_cdrgeo'], ENT_QUOTES);
    $cdrgeo_remarks_city = trim(htmlspecialchars($_POST['areaRemarkCDRgeoCity'], ENT_QUOTES));
    $cdrgeo_status_city = htmlspecialchars($_POST['cboStatusCDRgeoCity'], ENT_QUOTES);
    $cdrgeo_id_city = htmlspecialchars($_POST['hiddenidCDRgeoCity'], ENT_QUOTES);
    
    $upload_city = $_FILES['upload_cdrgeo_city']['name'];
    
    $cdrgeo_latitude_city = str_replace(',', '.', $cdrgeo_latitude_city);
    $cdrgeo_longitude_city = str_replace(',', '.', $cdrgeo_longitude_city);
    $cdrgeo_zip_city = preg_replace('#[ ]{1,}#', '', $cdrgeo_zip_city);
    
    if($cdrgeo_parent_city == 'select')
    {
        $Bok_cdrgeo_insert = false;
        $_SESSION['msg_cdrgeo_cboDistrictCDRgeoCity'] = 'sélectionnez un arrondissement, si ce dernier n\'est pas dans la liste, veuillez en créer un';
    }
    
    for($i = 0, $count = count($cdrgeo_name_city); $i < $count; $i++)
    {
        if(empty($cdrgeo_name_city[0]))
        {
            $Bok_cdrgeo_insert = false;
            $_SESSION['msg_cdrgeo_txtNameCDRgeoCity'] = 'veuillez indiquer un nom pour cette langue';
            $i = $count;
        }
        
        if($i > 0)
        {
            if(empty($cdrgeo_name_city[$i]))
            {
                $cdrgeo_name_city[$i] = $cdrgeo_name_city[0];
            }
        }
    }
    
    if($Bok_cdrgeo_insert === true)
    {
        try
        {
            $prepared_query = 'SELECT MAX(id_cdrgeo) FROM cdrgeo';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $cdrgeo_id_city = $data[0];
            }

            $cdrgeo_id_city++;
        }
        catch(Exception $e)
        {
            $_SESSION['error400_message'] = $e->getMessage();
            if($_SESSION['index'] == 'index.php')
            {
                die(header('Location: '.$config_customheader.'Error/400'));
            }
            else
            {
                die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
            } 
        }
        
        if(!empty($upload_city))
        {   
            $_SESSION['msg_cdrgeo_upload_city'] = 
            upload_file('upload_cdrgeo_city',
                        $cdrgeo_id_city.'city', 
                        5242880, 
                        1400, 
                        800, 
                        180, 
                        360,
                        100,
                        200,
                        'images/cdrgeo/original/', 
                        'images/cdrgeo/thumb/',
                        'images/cdrgeo/search/',
                        'id_cdrgeo', 
                        $cdrgeo_id_city,
                        'cdrgeo_image',
                        null,
                        'false');
        }
        
        try
        {
            if(!empty($upload_city))
            {
                $prepared_query = 'SELECT id_image FROM cdrgeo_image
                                   WHERE id_cdrgeo = :id';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('id', $cdrgeo_id_city);
                $query->execute();
                
                if(($data = $query->fetch()) != false)
                {
                    $id_image_city = $data[0];
                }
                else
                {
                    $id_image_city = 0;
                }
            }
            
            $prepared_query = 'INSERT INTO cdrgeo
                               (type_cdrgeo, code_cdrgeo, position_cdrgeo, status_cdrgeo,
                                statusobject_cdrgeo, parentdistrict_cdrgeo, zip_cdrgeo,
                                latitude_cdrgeo, longitude_cdrgeo, population_cdrgeo,
                                insee_cdrgeo, taxhab_cdrgeo, typecity_cdrgeo,
                                remarks_cdrgeo, id_image, ';
            
            for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
            {
                if($i == ($count - 1))
                {
                    $prepared_query .= 'L'.$main_activatedidlang[$i].')';
                }
                else
                {
                    $prepared_query .= 'L'.$main_activatedidlang[$i].', ';
                }
            }
            
            $prepared_query .= 'VALUES
                                (:type, :code, :position, :status, :statusobject,
                                 :parent, :zip, :lat, :long, :pop, :insee,
                                 :taxhab, :typecity, :remarks, :image, ';
            
            for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
            {
                if($i == ($count - 1))
                {
                    $prepared_query .= '"'.$cdrgeo_name_city[$i].'")';
                }
                else
                {
                    $prepared_query .= '"'.$cdrgeo_name_city[$i].'", ';
                }
                
                if($main_activatedidlang[$i] == $main_id_language)
                {
                    $cdrgeo_selected_lang = $i;
                }
            }
                                
                               
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'type' => 'dropdown',
                                  'code' => 'cdrgeo_city_situation',
                                  'position' => '1010',
                                  'status' => 1,
                                  'statusobject' => $cdrgeo_status_city,
                                  'parent' => $cdrgeo_parent_city,
                                  'zip' => $cdrgeo_zip_city,
                                  'lat' => $cdrgeo_latitude_city,
                                  'long' => $cdrgeo_longitude_city,
                                  'pop' => $cdrgeo_population_city,
                                  'insee' => $cdrgeo_insee_city,
                                  'taxhab' => $cdrgeo_taxhab_city,
                                  'typecity' => $cdrgeo_type_city,
                                  'remarks' => $cdrgeo_remarks_city,
                                  'image' => $id_image_city
                                  )); 
            $query->closeCursor();
            
            $_SESSION['msg_cdrgeo_done'] = 'La ville "'.$cdrgeo_name_city[$cdrgeo_selected_lang].'" a été ajoutée';
        }
        catch(Exception $e)
        {
            $_SESSION['error400_message'] = $e->getMessage();
            if($_SESSION['index'] == 'index.php')
            {
                die(header('Location: '.$config_customheader.'Error/400'));
            }
            else
            {
                die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
            } 
        }
    }
    else
    {
        $_SESSION['cdrgeo_hiddenidCDRgeoCity'] = $cdrgeo_id_city;
        $_SESSION['cdrgeo_txtZipCDRgeoCity'] = $cdrgeo_zip_city;

        for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
        {
           $_SESSION['cdrgeo_txtNameCDRgeoCity'.$main_activatedidlang[$i]] = $cdrgeo_name_city[$i]; 
        }

        $_SESSION['cdrgeo_cboDistrictCDRgeoCity'] = $cdrgeo_parent_city;
        $_SESSION['cdrgeo_txtLatitudeCDRgeoCity'] = $cdrgeo_latitude_city;
        $_SESSION['cdrgeo_txtLongitudeCDRgeoCity'] = $cdrgeo_longitude_city;
        $_SESSION['cdrgeo_txtINSEECDRgeoCity'] = $cdrgeo_insee_city;
        $_SESSION['cdrgeo_txtPopulationCDRgeoCity'] = $cdrgeo_population_city;
        $_SESSION['cdrgeo_txtTaxhabCDRgeoCity'] = $cdrgeo_taxhab_city;
        $_SESSION['cdrgeo_cdreditor_typecity_cdrgeo'] = $cdrgeo_type_city;
        $_SESSION['cdrgeo_areaRemarkCDRgeoCity'] = $cdrgeo_remarks_city;
        $_SESSION['cdrgeo_cboStatusCDRgeoCity'] = $cdrgeo_status_city;
    }
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
}
?>
