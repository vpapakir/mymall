<?php
if(isset($_POST['bt_delete_image_city']))
{
    try
    {
        $cdrgeo_id_city = htmlspecialchars($_POST['hiddenidCDRgeoCity'], ENT_QUOTES);

        $prepared_query = 'SELECT * FROM cdrgeo_image
                           WHERE id_cdrgeo = :id
                           ORDER BY date_image DESC';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $cdrgeo_id_city);
        $query->execute();

        $i = 0;

        if(($data = $query->fetch()) != false)
        {
            $cdrgeo_id_image_city = $data[0];
            $cdrgeo_name_image_city = $data['name_image'];
            $cdrgeo_path_image_city = $data['path_image'];
            $cdrgeo_paththumb_image_city = $data['paththumb_image'];
            $cdrgeo_pathsearch_image_city = $data['pathsearch_image'];
            $i++;
        }
        $query->closeCursor();
        
        $_SESSION['msg_cdrgeo_upload_city'] = destroy_image($cdrgeo_path_image_city, $cdrgeo_paththumb_image_city, $cdrgeo_pathsearch_image_city, $cdrgeo_name_image_city);

        $prepared_query = 'DELETE FROM cdrgeo_image
                           WHERE id_image = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $cdrgeo_id_image_city);
        $query->execute();
        $query->closeCursor();

        reallocate_table_id('id_image', 'cdrgeo_image');
        
        $prepared_query = 'UPDATE cdrgeo
                           SET id_image = (id_image - 1)
                           WHERE id_image > '.$cdrgeo_id_image_city;
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        $query->closeCursor();
        
        $prepared_query = 'UPDATE cdrgeo
                           SET id_image = 0
                           WHERE id_cdrgeo = '.$cdrgeo_id_city;
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        $query->closeCursor();
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
