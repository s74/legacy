<?php if ($_SESSION['M']) { ?>
<?php
 if (!defined('DDMEngine'))
{
	exit;
}
/*************Delete Admin************************************************************************************************/
if (isset($_REQUEST['SMode'])&& $_REQUEST['SMode']=='D') 
{
	SQL_DELETE('ddm_admins',"id='".InfiltrateM('ParameterID')."'");
}
/*************Edit admin************************************************************************************************/
if (isset($_REQUEST['EditAdmin'])) 
{
echo $_REQUEST['EditAdmin'];
	$Query['name']=InfiltrateM('name');
	$Query['surname']=InfiltrateM('surname');
	$Query['mail']=InfiltrateM('mail');
	$Query['login']=InfiltrateM('alogin');
	$Query['mail']=InfiltrateM('mail');
	$Query['V']=isset($_REQUEST['V'])?1:0;
	$Query['U']=isset($_REQUEST['U'])?1:0;
	$Query['D']=isset($_REQUEST['D'])?1:0;
	$Query['C']=isset($_REQUEST['C'])?1:0;
	$Query['M']=isset($_REQUEST['M'])?1:0;
	SQL_UPDATE('ddm_admins',$Query,"id='".$_REQUEST['EditAdmin']."'");
	SQL_UPDATE('ddm_permissions',array("permissions"=>$_REQUEST['permissions']),"owner='".$_REQUEST['EditAdmin']."'");
}
/*************Save Admin************************************************************************************************/
if (isset($_REQUEST['SaveAdmin'])) 
{
	$Query['name']=InfiltrateM('name');
	$Query['surname']=InfiltrateM('surname');
	$Query['mail']=InfiltrateM('mail');
	$Query['login']=InfiltrateM('alogin');
	$Query['pass']=md5(InfiltrateM('apassword'));
	$Query['mail']=InfiltrateM('mail');
	$Query['V']=isset($_REQUEST['V'])?1:0;
	$Query['U']=isset($_REQUEST['U'])?1:0;
	$Query['D']=isset($_REQUEST['D'])?1:0;
	$Query['C']=isset($_REQUEST['C'])?1:0;
	$Query['M']=isset($_REQUEST['M'])?1:0;
	SQL_INSERT('ddm_admins',$Query);
	$id=SQL_SELECT('ddm_admins','max(id) as max',"1");
	$id=$id[0]['max'];
	SQL_permissions_INSERT($id,InfiltrateM('permissions'));
}
/********** New Admin***************************************************************************************************************/
if (isset($_REQUEST['SMode'])&& ($_REQUEST['SMode']=='NA'||strpos($_REQUEST['SMode'],"EA")!==false))
{
$id=0;
if (strpos($_REQUEST['SMode'],"EA")!==false)
{
	$id=str_replace('EA&id=','',$_REQUEST['SMode']);
	$admin=SQL_SELECT('ddm_admins','*',"id='".$id."'");
	$admin=$admin[0];
	$permissions=SQL_SELECT('ddm_permissions','permissions',"owner='".$id."'");
	$permissions=$permissions[0]['permissions'];
}

?>
<table width="100%" >
	<tr>
		<td>
			Новый пользователь
			<br><br>
			<form method="post"  action="<?php echo $RootMain.'admin/users';?>">
			Имя/Псевдоним
			<br>
			<input type="text" <?php if ($id) {echo 'value="'.$admin['name'].'"';}; ?> name="name"  style="width:200px">
			<br>
			Фамилия
			<br>
			<input type="text" name="surname" <?php if ($id) {echo 'value="'.$admin['surname'].'"';}; ?> style="width:200px">
			<br>
			Почта 
			<br>
			<input type="text" name="mail" <?php if ($id) {echo 'value="'.$admin['mail'].'"';}; ?> style="width:200px">
			<br>
			Логин
			<br>
			<input type="text" <?php if ($id) {echo 'value="'.$admin['login'].'"';}; ?> name="alogin" style="width:200px"><br>
<?php if (!$id) {?>
Пароль
			<br>
			<input type="text" name="apassword"  style="width:200px">
			<br>
<?php }; ?>
			Каталоги
			<br>
			<input type="text" name="permissions" <?php if ($id) {echo 'value="'.$permissions.'"';}; ?> style="width:200px">
			<br>	
			<input type="checkbox" <?php if ($id) {echo $admin['V']?'checked':'';}; ?> name="V">Просмотр<br>
			<input type="checkbox" <?php if ($id) {echo $admin['U']?'checked':'';}; ?> name="U">Загрузка файлов<br>
			<input type="checkbox" <?php if ($id) {echo $admin['C']?'checked':'';}; ?> name="C">Cоздание папок<br>
			<input type="checkbox" <?php if ($id) {echo $admin['D']?'checked':'';}; ?> name="D">Удаление файлов и папок<br>
			<input type="checkbox" <?php if ($id) {echo $admin['M']?'checked':'';}; ?> name="M">Администрирование<br>
			<input type="submit" value="<?php if ($id) {echo 'Изменить';} else {echo 'Создать';}; ?>" style="width:200px">
<?php 
	if ($id) 
	{
		echo '<input type="hidden" value="'.$id.'" name="EditAdmin">';
	} 
	else 
	{
		echo '<input type="hidden" name="SaveAdmin">';
	}
?>
			
			</form>
		</td>
	</tr>
</table>
<?php
$Trigger=1;
}
else
{
$admins=SQL_SELECT('ddm_admins','*','1 ORDER BY id DESC');
?>
<script language="javascript" type="text/javascript" src="<?php echo $RootAdmin?>functionality/base/changebackground.js"></script>
<script language="javascript" type="text/javascript">
	function Delete(C)
	{
		document.Admins.SMode.value='D';
		document.Admins.ParameterID.value=C;
		if (confirm('Вы действительно хотите удалить пользователя?'))
		{
			document.Admins.submit();
		}
	}
	function NewAdmin()
	{
		document.Admins.SMode.value='NA';
		document.Admins.submit();
	}
	function EditAdmin(C)
	{
		document.Admins.SMode.value='EA&id='+C;
		document.Admins.submit();
	}
</script>
<form method="post" name="Admins" action="<?php echo $RootMain.'admin/users'?>">
<input type="hidden" name="SMode" value="0">
<input type="hidden" name="ParameterID" value="0">
<table width="100%" cellpadding="0" cellspacing="0">
	<tr class="itable_head">
		<td>
			Номер	
		</td>
		<td>
			Логин	
		</td>
		<td>
			Фамилия
		</td>
		<td>
			Имя
		</td>
		<td>
			Почта
		</td>
		<td>
			Каталоги
		</td>
		<td>V</td>
		<td>U</td>
		<td>C</td>
		<td>D</td>
		<td>M</td>
		<td></td>
	</tr>
	<tr class="trspacer">
		<td>
		</td>
	</tr>
<?php
$i="";
for ($i=0;$i<count($admins);$i++)
{
?>
	<tr class="vmtable" onclick="EditAdmin(<?php echo $admins[$i]['id']; ?>);" bgcolor="<?php echo ($i%2? '#eeeeee':'#dddddd');?>" id="R<?php echo $i; ?>" onmouseover="FBA('R<?php echo $i; ?>');" onmouseout="FBP('R<?php echo $i; ?>');">
		<td>
				<?php echo $i+1;?>
		</td>
		<td>
			<b>
				[<?php echo $admins[$i]['login'];?>]
			</b>
		</td>
		<td >
			<?php echo $admins[$i]['surname'];?>
		</td>
		<td >
			<?php echo $admins[$i]['name'];?>
		</td>
		<td >
			<?php echo $admins[$i]['mail'];?>
		</td>
		<td >
			<?php 
			$permissions=SQL_SELECT('ddm_permissions','permissions',"owner='".$admins[$i]['id']."'");
			$permissions=$permissions[0]['permissions'];
			echo $permissions;
			?>
		</td>
		<td><?php echo $admins[$i]['V'];?></td>
		<td><?php echo $admins[$i]['U'];?></td>
		<td><?php echo $admins[$i]['C'];?></td>
		<td><?php echo $admins[$i]['D'];?></td>
		<td><?php echo $admins[$i]['M'];?></td>	
		<td>
			<a href="javascript:Delete(<?php echo $admins[$i]['id'];?>);">
				<img src="<?php echo $RootAdmin.'design/iskin/images/delete.gif';?>">
			</a>
		</td>
	</tr>
	<tr class="trspacer">
		<td>
		</td>
	</tr>
<?php  	
}
?>
<tr  bgcolor="<?php echo (($i)%2? '#eeeeee':'#dddddd');?>" id="R<?php echo $i; ?>"  onmouseover="FBA('R<?php echo $i; ?>');" onmouseout="FBP('R<?php echo $i; ?>');">
		<td colspan="15"  align="center" valign="middle" onclick="NewAdmin();">
			<table>
				<tr>
					<td>
						<img onclick="NewAdmin();" src="<?php echo $RootAdmin.'design/iskin/images/new.gif';?>">
					</td>
					<td>
						<span style="font-size:11;color:#777777"> <b>Новый администратор</b></span>
					</td>
				</tr>
			</table>
		</td>	
	</tr>
</table>
<?php
}
}
?>