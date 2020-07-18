<?php
    try
    {
        unset($name_frame_pageproperty);
        
        $prepared_query = 'SELECT id_frame FROM structure_template
                           WHERE status_template = 1';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $id_frame_pageproperty = $data[0];
        }
        $query->closeCursor();
        
        $id_frame_pageproperty = split_string($id_frame_pageproperty, ',');
        
        for($i = 0, $count = count($id_frame_pageproperty); $i < $count; $i++)
        {
            $prepared_query = 'SELECT name_frame FROM structure_frame
                               WHERE id_frame = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $id_frame_pageproperty[$i]);
            $query->execute();
            
            if(($data = $query->fetch()) != false)
            {
                $name_frame_pageproperty[$i] = $data[0];
            }
            $query->closeCursor();
        }
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
?>

<tr>
    <td>
        <div class="font_subtitle">Insérer dans le menu</div>
    </td>
    <td></td>
    <td>
        <select name="cboPageSitemap">
            <option value="no">Non</option>
<?php
            for($i = 0, $count = count($id_frame_pageproperty); $i < $count; $i++)
            {
?>
                <optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="<?php echo($name_frame_pageproperty[$i]); ?>">
<?php            
                try
                {
                    $prepared_query = 'SELECT * FROM hierarchy_box
                                       WHERE id_frame = :id';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('id', $id_frame_pageproperty[$i]);
                    $query->execute();
                    while($data = $query->fetch())
                    {
?>
                        <option value="<?php echo($data[0]); ?>" style="background-color: white;"><?php echo($data['L'.$main_id_language]); ?></option>
<?php                    
                    }
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
?>
                </optgroup>
<?php
            }
?>
        </select>
    </td>
</tr>
