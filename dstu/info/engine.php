<?php
//SG DSTU Doc Manager  
$Version='1.1';
define("DDMEngine",true); 
include_once('resources/settings/directories.php');
include_once('resources/settings/config.php');    
include_once('resources/libraries/corelibrary.php');
/******************************************************************************************************************************/
session_start();
#ob_start();
/******************************************************************************************************************************/

$ACTION=Infiltrate('action');
$LOGIN=Infiltrate('login');
$PASSWORD=Infiltrate('password');
#var_dump($_SESSION);

if (!$LOGIN&&!$PASSWORD&&!isset($_SESSION['login']))
{
$LOGIN='student';
$PASSWORD='student';
}
if (strtolower($ACTION)=='editor')
{
	AAuthentification("Пожалуйста введите логин и пароль редактора."); 	
}

$INCLUDE=$DirectoryAdmin.'functionality/';
$TITLE="ДГТУ";
/******************************************************************************************************************************/
if (strtolower($ACTION)=='exit')
{
	foreach ($_SESSION as $k=>$v)
	{
		unset($_SESSION[$k]);
	}
	unset($_SESSION);
	$ACTION='';
	header('Location:'.$RootMain);
}
/******************************************************************************************************************************/
if ($LOGIN&&$PASSWORD)
{
	AdminCheck($LOGIN,$PASSWORD);
}

#var_dump($_SESSION);

if (!isset($_SESSION['login']))
{
	AAuthentification("Пожалуйста введите ваш логин и пароль."); 
}
switch (strtolower($ACTION))
{
case 'navigate18':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p18/";
				$ROOT="Отдел кадров";
				break;
			}
case 'navigate16':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p16/";
				$ROOT="Нормативно-справочная информация";
				break;
			}
case 'navigate15':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p15/";
				$ROOT="Делопроизводство";
				break;
			}
case 'navigate14':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p14/";
				$ROOT="Учёный совет";
				break;
			}
case 'navigate7':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p7/";
				$ROOT="Приказы ДГТУ";
				break;
			}
case 'navigate8':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p8/";
				$ROOT="Распоряжения ДГТУ";
				break;
			}
case 'navigate9':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p9/";
				$ROOT="Структура ДГТУ";
				break;
			}
	case 'navigate1':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p1/";
				$ROOT="Положения об УМУ";
				break;
			}
	case 'navigate2':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p2/";
				$ROOT="Основные нормативные документы по организации учебного процесса";
				break;
			}
	case 'navigate3':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p3/";
				$ROOT="Приказы и указания по вопросам учебного процесса";
				break;
			}
	case 'navigate4':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p4/";
				$ROOT="Мониторинг качества образовательного процесса";
				break;
			}
	case 'navigate5':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p5/";
				$ROOT="Учебно-методическая документация";
				break;
			}
	case 'navigate6':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p6/";
				$ROOT="Аккредитация ВУЗа";
				break;
			}
	case 'navigate20':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p20/";
				$ROOT="Информация для пользователей ЛВС";
				break;
			}
	case 'news':
			{
				$TITLE='Новости';
				$INCLUDE.='news.php';
				break;
			}
case 'moderators':
			{
				$INCLUDE.='moderators.php';
				$ROOT="Модераторы";
				break;
			}
	case 'navigate10':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p10/";
				$ROOT="Дополнительное образование";
				break;
			}
case 'navigate11':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p11/";
				$ROOT="Научная и инновационная деятельность";
				break;
			}
case 'navigate17':
	{
		$INCLUDE.='filemanager.php';
		$POSTFIX='p17/';
		$ROOT='Информационная служ';
		break;
	}
case 'navigate12':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p12/";
				$ROOT="Научно-техническая библиотека";
				break;
			}
	case 'admin/users':
			{
				if  (CheckAdminPermissions('users'))
                                {
					$TITLE='Администрирование';
					$INCLUDE.='ausers.php';
					break;
				}
				echo 'access denied';
                                return;
			}
	case 'admin/news':
			{
				if  (CheckAdminPermissions('news'))
				{
					$TITLE='Администрирование';
					$INCLUDE.='anews.php';
					break;
				}
				echo 'access denied';
				return;
			}
			
	case 'admin/note_adm':
			{
				if  (CheckAdminPermissions('note_adm'))
                                {
					$TITLE='Администрирование';
					$INCLUDE.='note_adm.php';
					break;
				}
				echo 'access denied';
                                return;
			}
			
	case 'about':
			{
				$TITLE='О программе';
				$INCLUDE.='about.php';
				break;
			}
	case 'navigate13':
			{
				$INCLUDE.='filemanager.php';
				$POSTFIX="p13/";
				$ROOT="Свободно распостраняемое ПО (Freeware)";
				break;
			}
	case 'lastfiles':
			{
				$TITLE='Последние пятнадцать документов';
				$INCLUDE.='lastfiles.php';
				break;
			}
	case 'note':
			{
				$TITLE='Реестр принятых к исполнению ВЦ служебных записок';
				$INCLUDE.='note.php';
				break;
			}


	case 'search':
			{
				$TITLE='Поиск';
				$INCLUDE.='search.php';
break;
				}

			
	default : 
			{
				$INCLUDE.='starter.php';
				$TITLE='Система предоставления информации ЦИТ ДГТУ';
				break;
			}
}
/******************************************************************************************************************************/
require_once($DirectoryAdmin.'design/eskin/components/upperaview.php');
?>
<body  bgcolor="#ffffff">
<table style="width:100%;height:100%" cellpadding="0" cellspacing="0" border="0">
	<tr width="100%">
		<td colspan="100" width="100%">
			<?php include_once($DirectoryAdmin.'design/eskin/components/head.php');?>
		</td>
	</tr>
	<tr height="100%">
		<td valign="top" height="100%">
			<?php include_once($DirectoryAdmin.'design/eskin/components/menu.php');?>
		</td>
		<td  height="100%" width="100%"  style="font-size:14px;padding-left:20px;padding:10px" valign="top">
<?
	include($INCLUDE);
?>
		</td>
	</tr>
	<tr >
		<td colspan="100">
			<?php include_once($DirectoryAdmin.'design/eskin/components/foot.php');?>
		</td>
	</tr>
	<tr height="100%">
	<tr>
</table>
<?php
require_once($DirectoryAdmin.'design/eskin/components/loweraview.php');
/******************************************************************************************************************************/
#ob_end_flush();
#echo session_id ();
#var_dump($_SESSION);
#phpinfo();
#session_commit();
/******************************************************************************************************************************/
?>
