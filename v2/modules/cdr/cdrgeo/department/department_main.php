<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseCDRgeoDepartment"
<?php
                if(empty($_SESSION['expand_collapseCDRgeoDepartment']) || $_SESSION['expand_collapseCDRgeoDepartment'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseCDRgeoDepartment', 'img_expand_collapseCDRgeoDepartment', 'expand_collapseCDRgeoDepartment', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseCDRgeoDepartment');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_collapseCDRgeoDepartment']) || $_SESSION['expand_collapseCDRgeoDepartment'] == 'false')
                        {
?>
                            <img id="img_expand_collapseCDRgeoDepartment" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseCDRgeoDepartment" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        Département
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_collapseCDRgeoDepartment" style="display: none;" type="hidden" name="expand_collapseCDRgeoDepartment" value="<?php if(empty($_SESSION['expand_collapseCDRgeoDepartment']) || $_SESSION['expand_collapseCDRgeoDepartment'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseCDRgeoDepartment"
<?php
        if(empty($_SESSION['expand_collapseCDRgeoDepartment']) || $_SESSION['expand_collapseCDRgeoDepartment'] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        > 
        <td align="left"><table width="100%" border="0">
                <tr>
                    <td align="left">
                        <span class="font_subtitle">Recherche - Département</span>
                    </td>
                    <td align="left" width="<?php echo($right_column_width); ?>">
                        <input id="txtSearchCDRgeoDepartment" type="text" name="txtSearchCDRgeoDepartment" onKeyUp="requestGEOEDITDepartment();"/>
                        <span id="ajaxloaderCDRgeoDepartment" style="display: none;">
                            <img src="<?php echo($config_customheader); ?>graphics/ajaxloader/loader003.gif" alt="loader001.gif" />
                        </span>
                        <!--[if lte IE 7]>
                        <div id="SearchDIVCDRgeoDepartment" style="position: relative; z-index: 100; display: none; width: 200px; border: 1px solid lightgrey; padding: 1px; background-color: white; overflow: auto; -overflow-y: scroll;
                                                             -overflow-x:hidden; height: 100px;">
                            <span id="SearchResultCDRgeoDepartment" style="list-style-type: none;"></span>
                        </div>
                        <![endif]-->
                        <!--[if !IE]><!-->
                        <div id="SearchDIVCDRgeoDepartment" style="position: absolute; z-index: 100; display: none; width: 200px; border: 1px solid lightgrey; padding: 1px; background-color: white; overflow: auto; -overflow-y: scroll;
                                                             -overflow-x:hidden; height: 100px;">
                            <span id="SearchResultCDRgeoDepartment" style="list-style-type: none;"></span>
                        </div>
                         <!--<![endif]-->
                         <!--[if gte IE 8]>
                        <div id="SearchDIVCDRgeoDepartment" style="position: absolute; z-index: 100; display: none; width: 200px; border: 1px solid lightgrey; padding: 1px; background-color: white; overflow: auto; -overflow-y: scroll;
                                                             -overflow-x:hidden; height: 100px;">
                            <span id="SearchResultCDRgeoDepartment" style="list-style-type: none;"></span>
                        </div>
                        <![endif]-->
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                </tr>
<?php
            for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
            {
?>
                <tr>
                    <td align="left">
                        <span class="font_subtitle"><?php give_translation($main_activatedcodelang[$i]); ?></span>
                    </td>
                    <td align="left">
                        <input type="text" name="txtNameCDRgeoDepartment<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['cdrgeo_txtNameCDRgeoDepartment'.$main_activatedidlang[$i]])){ echo($_SESSION['cdrgeo_txtNameCDRgeoDepartment'.$main_activatedidlang[$i]]); } ?>"/>
                    </td>
                </tr>              
<?php
            }
?>
                <tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                </tr>
                <tr>
                    <td class="font_subtitle">
                       Image - Département
                    </td>
                    <td>
                       <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" />
                       <input type="file" name="upload_cdrgeo_department"></input>
                       <br clear="left">
                       <div class="font_info1">
        <?php 
                        if(!empty($_SESSION['msg_cdrgeo_upload_department']))
                        { 
                            echo(check_session_input($_SESSION['msg_cdrgeo_upload_department'])); 
                        } 
        ?>
                        </div>
                    </td>
                </tr>

        <?php
                try
                {
                    $prepared_query = 'SELECT * FROM cdrgeo_image
                                       WHERE id_cdrgeo = :id
                                       ORDER BY date_image DESC';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('id', $_SESSION['cdrgeo_hiddenidCDRgeoDepartment']);
                    $query->execute(); 

                    if(($data = $query->fetch()) != false)
                    {
                        $query->execute();
                        
                        while($data = $query->fetch())
                        {
        ?>
                            <tr>
                            <td colspan="2"><table width="100%">
                                <tr>
                                    <td><table width="100%">
                                        <tr>    
                                        <td>

                                        </td>
                                        <td>
                                            <a class="highslide" href="<?php echo($config_customheader.$data['path_image']); ?>" onclick="return hs.expand(this);"><img src="<?php echo($config_customheader.$data['paththumb_image']); ?>" style="border: none;"></img></a>
                                        </td>
                                        </tr>
                                    </table></td>
                                
                                    <td width="<?php echo($right_column_width); ?>" style="vertical-align: top;"><table width="100%">
                                        <tr>
                                            <td class="font_main" width="30%">
                                                Nom
                                            </td>
                                            <td class="font_main">
                                                <input style="width: 100%;" type="text" name="txtActNameImageCDRgeoDepartment" value="<?php echo($data['name_image']); ?>"></input>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font_main">
                                                Alt 
                                            </td>
                                            <td class="font_main">
                                                <input style="width: 100%;" type="text" name="txtActAltImageCDRgeoDepartment" value="<?php echo($data['alt_image']); ?>"></input>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="submit" name="bt_delete_image_department" value="Supprimer"/>
                                            </td>
                                        </tr>
                                    </table></td>
                                </tr>

                            </table></td>
                            </tr>
        <?php                
                        }
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
                        die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
                    }
                }
?>  
                <tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                </tr>
                <tr>
                    <td align="left">
                        <span class="font_subtitle">Attribuer à la région</span>
                    </td>
                    <td align="left">
                        <select name="cboRegionCDRgeoDepartment">
                            <option value="select" 
                                <?php if(empty($_SESSION['cdrgeo_cboRegionCDRgeoDepartment']) || $_SESSION['cdrgeo_cboRegionCDRgeoDepartment'] == 'select'){ echo('selected="selected"'); }else{ echo(null); } ?>
                                    >--- sélectionner ---</option>
<?php
                    try
                        {
                            $prepared_query = 'SELECT cdrgeo.id_cdrgeo, cdrgeo.L'.$main_id_language.', geo_country.L'.$main_id_language.' FROM cdrgeo
                                               INNER JOIN cdrgeo AS geo_country
                                               ON cdrgeo.parentcountry_cdrgeo = geo_country.id_cdrgeo
                                               WHERE cdrgeo.statusobject_cdrgeo = 1
                                               AND cdrgeo.parentcountry_cdrgeo > 0
                                               ORDER BY cdrgeo.L'.$main_id_language;
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->execute();

                            while($data = $query->fetch())
                            {
?>
                                <option value="<?php echo($data[0]); ?>"
                                    <?php if(!empty($_SESSION['cdrgeo_cboRegionCDRgeoDepartment']) && $_SESSION['cdrgeo_cboRegionCDRgeoDepartment'] == $data[0]){ echo('selected="selected"'); }else{ echo(null); } ?>    
                                        ><?php echo($data[1].' ('.$data[2].')'); ?></option>
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
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <span class="font_subtitle">Statut</span>
                    </td>
                    <td align="left">
                        <select name="cboStatusCDRgeoDepartment">
                            <option value="1"
                                <?php if(empty($_SESSION['cdrgeo_cboStatusCDRgeoDepartment']) || $_SESSION['cdrgeo_cboStatusCDRgeoDepartment'] == 1){ echo('selected="selected"'); }else{ echo(null); } ?>
                                    >Activé</option>
                            <option value="9"
                                <?php if(!empty($_SESSION['cdrgeo_cboStatusCDRgeoDepartment']) && $_SESSION['cdrgeo_cboStatusCDRgeoDepartment'] == 9){ echo('selected="selected"'); }else{ echo(null); } ?>
                                    >Désactivé</option>
                        </select>
                        <input type="hidden" name="hiddenidCDRgeoDepartment" value="<?php if(!empty($_SESSION['cdrgeo_hiddenidCDRgeoDepartment'])){ echo($_SESSION['cdrgeo_hiddenidCDRgeoDepartment']); } ?>"/>
                    </td>
                </tr>
                <tr>
                    <td><div style="height: 4px;"></div></td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top: 1px solid lightgrey;" align="center">
                        <table width="100%" cellpadding="1" cellspacing="1" style="margin: 4px 0px 4px 0px;">
                            <tr>
                                <td align="center">
<?php
                                if(empty($_SESSION['cdrgeo_edit_button_department']))
                                {
?>
                                    <input type="submit" name="bt_add_department_geo" value="Ajouter"/>
<?php
                                }
                                else
                                {
?>
                                    <input type="submit" name="bt_edit_department_geo" value="Sauvegarder"/>
<?php
                                }
?>
                                    
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
        </table></td>
    </tr>
</table></td>
</tr>
            
            
