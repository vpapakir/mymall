<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseSignature<?php echo($main_activatedidlang[$i]); ?>"
<?php
                if(empty($_SESSION['expand_signature'.$main_activatedidlang[$i]]) || $_SESSION['expand_signature'.$main_activatedidlang[$i]] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseSignature<?php echo($main_activatedidlang[$i]); ?>', 'img_expand_collapseSignature<?php echo($main_activatedidlang[$i]); ?>', 'expand_signature<?php echo($main_activatedidlang[$i]); ?>', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseSignature<?php echo($main_activatedidlang[$i]); ?>');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_signature'.$main_activatedidlang[$i]]) || $_SESSION['expand_signature'.$main_activatedidlang[$i]] == 'false')
                        {
?>
                            <img id="img_expand_collapseSignature<?php echo($main_activatedidlang[$i]); ?>" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseSignature<?php echo($main_activatedidlang[$i]); ?>" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation($main_activatedcodelang[$i], '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_signature<?php echo($main_activatedidlang[$i]); ?>" style="display: none;" type="hidden" name="expand_signature<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(empty($_SESSION['expand_signature'.$main_activatedidlang[$i]]) || $_SESSION['expand_signature'.$main_activatedidlang[$i]] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseSignature<?php echo($main_activatedidlang[$i]); ?>"
<?php
        if(empty($_SESSION['expand_signature'.$main_activatedidlang[$i]]) || $_SESSION['expand_signature'.$main_activatedidlang[$i]] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        >
        <td align="left"><table width="100%" cellpadding="0" cellspacing="0">        
<?php
            include('modules/email/signature/content/signature_content.php');
?>
        </table></td>
    </tr>
</table></td>
</tr>
