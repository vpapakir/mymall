<td class="font_subtitle">
    <?php give_translation('edit_structure.main_intro_font', '', $config_showtranslationcode); ?> <?php give_translation('edit_structure.subtitle_font_font', '', $config_showtranslationcode); ?>
</td>
<td class="font_main">
    <select name="cboIntroFamilyFont">
<?php
    try
    {
        $prepared_query = 'SELECT * FROM fonts
                           ORDER BY name_fonts';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();

        while($data = $query->fetch())
        {
?>
                <option style="font-family: <?php echo('\''.$data['name_fonts'].'\''); ?>;" value="<?php echo($data['family_fonts']); ?>"
                        <?php if($intro_font[5] == $data['family_fonts']){ echo('selected'); }else{ echo(null); } ?>
                        ><?php echo($data['name_fonts'].' - AaBbCcIi0123'); ?></option>
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
            die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
        } 
    }
?>                
    </select>
</td>

<tr></tr>         

<td class="font_subtitle">
    <?php give_translation('edit_structure.main_intro_font', '', $config_showtranslationcode); ?> <?php give_translation('edit_structure.subtitle_size_font', '', $config_showtranslationcode); ?>
</td>
<td class="font_main">
    <input type="text" name="txtIntroSizeFont" value="<?php echo($intro_font[0]); ?>"></input>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_structure.main_intro_font', '', $config_showtranslationcode); ?> <?php give_translation('edit_structure.subtitle_weight_font', '', $config_showtranslationcode); ?>
</td>
<td class="font_main">
    <select name="cboIntroWeightFont">
        <option style="font-weight: normal;" value="normal" <?php if($intro_font[1] == 'normal'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_weight_normal', '', $config_showtranslationcode); ?></option>
        <option style="font-weight: bold;" value="bold" <?php if($intro_font[1] == 'bold'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_weight_bold', '', $config_showtranslationcode); ?></option>
    </select>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_structure.main_intro_font', '', $config_showtranslationcode); ?> <?php give_translation('edit_structure.subtitle_color_font', '', $config_showtranslationcode); ?>
</td>
<td class="font_main" onchange="onchange_color('cboIntroColorFont', 'IntroColorFont');">
    <?php dropdown_color('cboIntroColorFont', $intro_font[2], 'IntroColorFont'); ?>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_structure.main_intro_font', '', $config_showtranslationcode); ?> <?php give_translation('edit_structure.subtitle_underline_font', '', $config_showtranslationcode); ?>
</td>
<td class="font_main">
    <select name="cboIntroDecorationFont">
        <option style="text-decoration: none;" value="none" <?php if($intro_font[3] == 'none'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_no', '', $config_showtranslationcode); ?></option>
        <option style="text-decoration: underline;" value="underline" <?php if($intro_font[3] == 'underline'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_yes', '', $config_showtranslationcode); ?></option>
    </select>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_structure.main_intro_font', '', $config_showtranslationcode); ?> <?php give_translation('edit_structure.subtitle_align_font', '', $config_showtranslationcode); ?>
</td>
<td class="font_main">
    <select name="cboIntroAlignFont">
        <option style="text-align: left;" value="left" <?php if($intro_font[4] == 'left'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_left', '', $config_showtranslationcode); ?></option>
        <option style="text-align: center;" value="center" <?php if($intro_font[4] == 'center'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_center', '', $config_showtranslationcode); ?></option>
        <option style="text-align: right;" value="right" <?php if($intro_font[4] == 'right'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_right', '', $config_showtranslationcode); ?></option>
        <option style="text-align: justify;" value="justify" <?php if($intro_font[4] == 'justify'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_justify', '', $config_showtranslationcode); ?></option>
    </select>
</td>

<tr><td colspan="2"><hr style="color: lightgray;"></hr></td></tr>
