<?php if ($_SESSION['M']) { 
if (!defined('DDMEngine'))
{
	exit;
}

$Parameters=InfiltrateM('ParameterID');
$PS=explode('|',$Parameters);
?>
<br>
<br>


<form action="<?php echo $_SERVER['REQUEST_URI'].rtrim($Parameters[2],'/');?>" method="POST" name="Files" enctype="multipart/form-data" >
Новое название <b>'<?php echo $PS[3];?>'</b> <br>
<input type="text" value="<?php echo $PS[3];?>" style="width:300px" name="path" /><br>
<input type="submit" style="width:300px" />
</form>
<?php
}	
?>