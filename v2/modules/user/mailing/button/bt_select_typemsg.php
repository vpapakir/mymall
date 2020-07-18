<?php
if(isset($_POST['bt_select_typemsg']))
{
    unset($_SESSION['mailing_chkall']);
    
    unset($_SESSION['usermailing_txtTestemailUserMailing'],
            $_SESSION['usermailing_txtNameUserMailing'],
            $_SESSION['usermailing_txtEmailUserMailing'],
            $_SESSION['usermailing_txtTitleSubjectUserMailing'],
            $_SESSION['usermailing_txtDescSubjectUserMailing'],
            $_SESSION['usermailing_areaReceiverUserMailing'],
            $_SESSION['usermailing_radTypeMsgUserMailing']);
    
    #msg
    $usermailing_typemsg = (htmlspecialchars($_POST['radTypeMsgUserMailing'], ENT_QUOTES));
    
    if($usermailing_typemsg == 'existing')
    {
        $_SESSION['usermailing_radTypeMsgUserMailing'] = $usermailing_typemsg;
        $_SESSION['usermailing_areaMsgUserMailing'] = trim($_POST['areaMsgUserMailing']);
        $_SESSION['usermailing_cboSignatureUserMailing'] = htmlspecialchars($_POST['cboSignatureUserMailing'], ENT_QUOTES);
    }
    else
    {
        $_SESSION['usermailing_cboTemplateUserMailing'] = trim($_POST['cboTemplateUserMailing']);
    }
    
    #listing
    $_SESSION['expand_mailing_listing'] = trim(htmlspecialchars($_POST['expand_mailing_listing'], ENT_QUOTES));
    
    unset($usermailing_listing_chk,$usermailing_listing_temp_iduser);
    for($i = 0, $count = count($usermailing_listing_iduser); $i < $count; $i++)
    {
        $usermailing_listing_temp_iduser = split_string($usermailing_listing_iduser[$i], '$');
        $usermailing_listing_chk = htmlspecialchars($_POST['chk_mailing'.$usermailing_listing_temp_iduser[3]], ENT_QUOTES);
        if($usermailing_listing_chk == 1)
        {
            $_SESSION['usermailing_chk'.$usermailing_listing_temp_iduser[3]] = 1;
        }
        else
        {
            $_SESSION['mailing_chkall'] = 'false';
            $_SESSION['usermailing_chk'.$usermailing_listing_temp_iduser[3]] = 9;
        }
        unset($usermailing_listing_chk,$usermailing_listing_temp_iduser);
    }
    
    #info
    $_SESSION['usermailing_txtTestemailUserMailing'] = trim(htmlspecialchars($_POST['txtTestemailUserMailing'], ENT_QUOTES));
    $_SESSION['usermailing_txtNameUserMailing'] = trim(htmlspecialchars($_POST['txtNameUserMailing'], ENT_QUOTES));
    $_SESSION['usermailing_txtEmailUserMailing'] = trim(htmlspecialchars($_POST['txtEmailUserMailing'], ENT_QUOTES));
    $_SESSION['usermailing_txtTitleSubjectUserMailing'] = trim(htmlspecialchars($_POST['txtTitleSubjectUserMailing'], ENT_QUOTES));
    $_SESSION['usermailing_txtDescSubjectUserMailing'] = trim(htmlspecialchars($_POST['txtDescSubjectUserMailing'], ENT_QUOTES));
    $_SESSION['usermailing_areaReceiverUserMailing'] = trim(htmlspecialchars($_POST['areaReceiverUserMailing'], ENT_QUOTES));
    
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
