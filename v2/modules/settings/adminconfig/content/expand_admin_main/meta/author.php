<tr>
    <td align="left">
        <span class="font_main">
            <?php give_translation('adminconfig_edit.admin_main_subtitle_author', $echo, $config_showtranslationcode); ?>
        </span>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
        <input type="text" name="txtAdminconfigAdminMainMetaAuthor" style="width: 80%;" value="<?php if(!empty($adminconfig_main_meta_author)){ echo($adminconfig_main_meta_author); } ?>" />
    </td>
</tr>