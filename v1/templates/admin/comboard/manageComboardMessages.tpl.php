<? //print_r($out);?>
<? if(input('SID')!='comboard2'){?>
<table cellpadding="0" cellspacing="0">
<form name="getComboard" method="post"> 
	<input type="hidden" name="SID" value="<?=input('SID')?>" /> 
	<tr> 
		<td>
			<input type="button" name="goComboardHome" value="<?=lang('goComboardHome.comboard.tip')?>" onClick="location.replace('<?=setting('url')?>comboard');"/> 
		</td> 
		<td>
			<?	
				$options[0]['id'] = '';
				$options[0]['value'] = lang('PropertyNavigation.property.tip');
				echo getReference('Property.Navigation','PropertyNavigation',$input['PropertyNavigation'],array('code'=>'Y','type'=>'dropdown','options'=>$options,'action'=>'location.replace(\''.setting('url').'\'+this.value);'))
			?> 
		</td> 
	</tr> 
</form>
</table>
<?=boxHeader(array('title'=>'ManageComboardMessages.comboard.title','tabs'=>'manageComboardMessage','tabslink'=>'' ))?> 
<? }else{?>
	<?=boxHeader(array('title'=>'ManageComboardMessages.comboard.title'))?> 
<? }?>
<tr> 
  <td valign="top" bgcolor="#ffffff" class="subtitle" align="center"> <?=(lang('ComboardOf.comboard.subtitle').' '.user('UserName').' '.getFormated(input('chosenDate'),'date'))?> </td> 
</tr> 
<? // =boxHeader(array('title'=>'ManageSections.core.title','tabs'=>'manageSections','formName'=>$formName,'tabslink'=>'SectionID/'.input('SectionID').'/GroupID/'.input('GroupID')))?> 
<form name="sendComboardMessage" method="post"> 
  <input type="hidden" name="SID" value="<?=input('SID')?>" /> 
  <input type="hidden" name="actionMode" value="save" /> 
  <input type="hidden" name="tabLink" value="<?=input('tabLink')?>" /> 
  <input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageParentID" value="<?=input('MessageID')?>" /> 
  <input type="hidden" name='ComboardMessage<?=DTR?>ComboardMessageStartTime' value="<?=getFormated('','date')?>"> 
  <input type="hidden" name='ComboardMessage<?=DTR?>ComboardMessageID' value="<?=input('ComboardMessageID')?>"> 
  <input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageCreatorID" value="<?=input('ComboardMessageCreatorID')?>"> 
  <input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageCreatorCode" value="<?=input('ComboardMessageCreatorCode')?>"> 
  <tr> 
    <td>
		<table> 
			<tr> 
			<?
				foreach ($out['DB']['Users'] as $group=>$users){
					echo '<td valign="top" bgcolor="#ffffff" align="left">';
					echo "<b>$group</b><br />";
					echo getLists(	$users,
									'|'.user('UserID').'|',
									array(	'name'=>'ComboardMessage'.DTR.'ComboardMessageUsers',
											'id'=>'UserID',
											'value'=>'UserName',
											'type'=>'checkboxes')
								);
					echo '</td>';
				}
		
				$selectedRadio=4;
				if($out['DB']['ComboardMessage'][0]['ComboardMessageType']=='calendar')
					$selectedRadio=1;
				elseif($out['DB']['ComboardMessage'][0]['ComboardMessageType']=='task')
					$selectedRadio=2;
				elseif($out['DB']['ComboardMessage'][0]['ComboardMessageType']=='event')
					$selectedRadio=3;
			?> 
			</tr> 
		</table>
	</td> 
 </tr> 
 <? if(!empty($out['DB']['ComboardMessage'][0]['ComboardMessageCreatorID']) && $out['DB']['ComboardMessage'][0]['ComboardMessageCreatorCode']='session'){?>
 <tr> 
    <td valign="top" bgcolor="#ffffff" class="fieldNames" align="left"> 
      <?=lang('ComboardMessage.ComboardMessageCreatorID')?> 
      <br/> 
      <a href="<?=setting('url')?>manageUser/<?=$out['DB']['ComboardMessage'][0]['ComboardMessageCreatorID']?>"><?=lang('ComboardMessageCreatorID.comboard.tip')?></a>
	</td>
  </tr> 
  <? }?>
  <tr> 
    <td valign="top" bgcolor="#ffffff" class="fieldNames" align="left"> <br/> 
      <?=lang('ComboardMessage.ComboardMessageTitle')?> 
      <br/> 
      <input type="text" name="ComboardMessage<?=DTR?>ComboardMessageTitle" value="<?=$out['DB']['ComboardMessage'][0]['ComboardMessageTitle'];?>" size="50"> 
	</td> 
  </tr> 
  <tr> 
    <td valign="top" bgcolor="#ffffff" class="fieldNames" align="left"> <?=lang('ComboardMessage.ComboardMessageContent')?> 
      <br/> 
      <textarea name="ComboardMessage<?=DTR?>ComboardMessageContent" cols="35" rows="10"><?=$out['DB']['ComboardMessage'][0]['ComboardMessageContent']?></textarea>
	</td> 
  </tr> 
  <script language=javascript>
	function select_action_comboard(num){
		var doc=document.forms.sendComboardMessage;
		var active_alarme="";
		if(num==4){				//message
			active_alarme="";
    	}
	
		if(num==1){				//calendar
			var action_1="";
			active_alarme="true";
		}else{
			var action_1="true";
    	}
	
		if(num==2){				//task
			var action_2="";
			active_alarme="true";
		}else{
			var action_2="true";
		}
		
		if(num==3){				//event
			var action_3="";
			active_alarme="true";
		}else{
			var action_3="true";
    	}
	
		doc.ComboardMessage<?=DTR?>ComboardMessageStartTime_calendar.disabled=action_1;
		doc.ComboardMessage<?=DTR?>ComboardMessageDuration.disabled=action_1;
	
		doc.ComboardMessage<?=DTR?>ComboardMessageStartTime_task.disabled=action_2;
	
		doc.ComboardMessage<?=DTR?>ComboardMessageStartTime_event.disabled=action_3;
		doc.ComboardMessage<?=DTR?>ComboardMessageEndTime.disabled=action_3;
	
//		doc.ComboardMessage<?=DTR?>ComboardMessageAlarm.checked="";

		select_alarm_state();
		
		doc.ComboardMessage<?=DTR?>ComboardMessageAlarm.disabled=!active_alarme;
	}

	function select_alarm_state(){
		var doc=document.forms.sendComboardMessage;
		if(doc.ComboardMessage<?=DTR?>ComboardMessageAlarm.checked){
			var action="";
		}else{
			var action="true";
		}
		doc.ComboardMessage<?=DTR?>ComboardMessageAlarmTime.disabled=action;
		doc.ComboardMessage<?=DTR?>ComboardMessageAlarmEmail.disabled=action;	
	}


</script> 
  <tr> 
    <td><table> 
        <!-------------- Message ----------------> 
        <tr> 
          <td width=20><input type="radio" name="ComboardMessage<?=DTR?>ComboardMessageType" value="message" onclick="select_action_comboard(4)" <?=(!$out['DB']['ComboardMessage'][0]['ComboardMessageType']?'checked':'disabled')?>></td> 
          <td colspan=2 valign="bottom"><?=lang('ComboardMessage.Message.ComboardMessageType')?></td> 
        </tr> 
        <!-------------- Calendar ----------------> 
        <tr> 
          <td width=20><input type="radio" name="ComboardMessage<?=DTR?>ComboardMessageType" value='calendar' onclick='select_action_comboard(1)' <?=($out['DB']['ComboardMessage'][0]['ComboardMessageType']=='calendar'?'checked':($out['DB']['ComboardMessage'][0]['ComboardMessageType']?'disabled':''))?>></td> 
          <td colspan=2 valign="bottom"><?=lang('ComboardMessage.Calendar.ComboardMessageType')?></td> 
        </tr> 
        <tr> 
          <td /> 
          <td><?=lang('DateMeeting.comboard.tip')?></td> 
          <td> <?//=GetFormated(input('ComboardMessageStartTime'),'DateTime','form',array('fieldName'=>'ComboardMessage'.DTR.'ComboardMessageStartTime_calendar','formName'=>'sendComboardMessage'));?> 
            <?=GetFormated($out['DB']['ComboardMessage'][0]['ComboardMessageStartTime'],'DateTime','form',array('fieldName'=>'ComboardMessage'.DTR.'ComboardMessageStartTime_calendar','formName'=>'sendComboardMessage'));?> </td> 
        </tr> 
        <tr> 
          <td /> 
        </tr> 
        <tr> 
          <td /> 
          <td><?=lang('ComboardMessage.ComboardMessageDuration')?></td> 
          <td><input type=text name="ComboardMessage<?=DTR?>ComboardMessageDuration" value='15' size=2 maxlength=3 disabled></td> 
        </tr> 
        <!-------------- TODOLIST ----------------> 
        <tr> 
          <td width=20><input type="radio" name="ComboardMessage<?=DTR?>ComboardMessageType" value='task' onclick='select_action_comboard(2)' <?=($out['DB']['ComboardMessage'][0]['ComboardMessageType']=='task'?'checked':($out['DB']['ComboardMessage'][0]['ComboardMessageType']?'disabled':''))?> /></td> 
          <td colspan=2 valign=bottom><?=lang('ComboardMessage.Task.ComboardMessageType')?></td> 
        </tr> 
        <tr> 
          <td /> 
          <td><?=lang('Deadline.comboard.tip')?></td> 
          <td> <?=GetFormated($out['DB']['ComboardMessage'][0]['ComboardMessageStartTime'],'DateTime','form',array('fieldName'=>'ComboardMessage'.DTR.'ComboardMessageStartTime_task','formName'=>'sendComboardMessage'));?> </td> 
        </tr> 
        <!-------------- Event ----------------> 
        <tr> 
          <td width=20><input type="radio" name="ComboardMessage<?=DTR?>ComboardMessageType" value='event' onclick='select_action_comboard(3)' <?=($out['DB']['ComboardMessage'][0]['ComboardMessageType']=='event'?'checked':($out['DB']['ComboardMessage'][0]['ComboardMessageType']?'disabled':''))?>></td> 
          <td colspan=2 valign=bottom><?=lang('ComboardMessage.Event.ComboardMessageType')?></td> 
        </tr> 
        <tr> 
          <td /> 
          <td><?=lang('DateBegin.comboard.tip')?></td> 
          <td> <?=GetFormated($out['DB']['ComboardMessage'][0]['ComboardMessageStartTime'],'DateTime','form',array('fieldName'=>'ComboardMessage'.DTR.'ComboardMessageStartTime_event','formName'=>'sendComboardMessage'));?> </td> 
        </tr> 
        <tr> 
          <td /> 
        </tr> 
        <tr> 
          <td /> 
          <td><?=lang('DateEnd.comboard.tip')?></td> 
          <td> <?=GetFormated($out['DB']['ComboardMessage'][0]['ComboardMessageEndTime'],'DateTime','form',array('fieldName'=>'ComboardMessage'.DTR.'ComboardMessageEndTime','formName'=>'sendComboardMessage'));?> </td> 
        </tr> 
        <!-------------- ALARM ----------------> 
        <tr> 
          <td colspan=3 valign=bottom><?=lang('ComboardMessage.ComboardMessageAlarm')?></td> 
        </tr> 
        <tr> 
          <td width=20><input type="checkbox" name="ComboardMessage<?=DTR?>ComboardMessageAlarm" onclick='select_alarm_state()' value=1 <?=($out['DB']['ComboardMessage'][0]['ComboardMessageAlarm']?'checked':(!$out['DB']['ComboardMessage'][0]['ComboardMessageType']?'disabled':''))?> /></td> 
          <td><?=lang('ComboardMessage.ComboardMessageAlarmTime')?></td> 
          <td> <input type=text name='ComboardMessage<?=DTR?>ComboardMessageAlarmTime' value='<?=$out['DB']['ComboardMessage'][0]['ComboardMessageAlarmTime']?$out['DB']['ComboardMessage'][0]['ComboardMessageAlarmTime']:'24'?>' size=2 maxlength=3 disabled> </td> 
        </tr> 
        <tr> 
          <td /> 
          <td><?=lang('ComboardMessage.ComboardMessageAlarmEmail')?></td> 
          <td> <input type=text name="ComboardMessage<?=DTR?>ComboardMessageAlarmEmail" value='<?=$out['DB']['ComboardMessage'][0]['ComboardMessageAlarmEmail']?>' size=40 disabled> </td> 
        </tr> 
      </table></td> 
  </tr> 
  <script language=javascript>
	select_action_comboard(<?=$selectedRadio?>);
</script> 
  <tr> 
    <td valign="top" bgcolor="#ffffff" class="fieldNames" align="left"> <?if($out['DB']['ComboardMessage'][0]['ComboardMessageID']){?> 
      <input type="submit" value="<?=lang("-save")?>"> 
      <input type="button" onclick='document.forms.sendComboardMessage.actionMode.value="delete";document.forms.sendComboardMessage.submit();' value="<?=lang("-delete")?>"> 
      <? }else{?> 
      <input type="submit" value="<?=lang("-send")?>"> 
      <? }?> </td> 
  </tr> 
</form>
<tr>
	<td>
		<table>
		<? foreach($out['DB']['AnswerComboardMessages'] as $value){?>
			<? if($out['DB']['ComboardMessage'][0]['ComboardMessageID']==$value['ComboardMessageParentID']){?>
			<tr>
				<td>
					<span class="subtitle"><?=getFormated($value['TimeCreated'],'DateTime');?> <?=$value['ComboardMessageTitle']?></span>
					<br>
					<?=$value['ComboardMessageContent']?>
				</td>
			</tr>
		<? }}?>
		</table>
	</td>
</tr>
<?=boxFooter()?>