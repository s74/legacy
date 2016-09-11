<?php
//ini_set('display_errors', E_ALL);

//Человек! Ниже представлен редкостный гавнокод! 

require_once($_SERVER['DOCUMENT_ROOT'].'/system/functionality/note_config.php');

$db = new Db();
$tpl = new Tpl();
$_GET = $db->pars_get_query();

lst();

function lst(){
	global $tpl, $db, $_GET;
	$tpl->assign('units', $db->get_units());

	if($db->is($_GET['act']) === 'search'){
		if(intval($_GET['month'])){
			if( ! isset($_GET['year']) || ! intval($_GET['year'])){
				$_GET['year'] = '-';
			}else{
				$tpl->assign('year', $_GET['year']);
			}
			$p1 = (intval($_GET['year']) ? intval($_GET['year']) : 'Y').'-'.sprintf('%02d', intval($_GET['month'])).'-01';
			$_POST['date_from'] = date($p1);
			$p1 = (intval($_GET['year']) ? intval($_GET['year']) : 'Y').'-'.sprintf('%02d', intval($_GET['month'])).'-t';
			$_POST['date_to'] = date($p1, strtotime($_POST['date_from']));
			$db->custom_query('SELECT * FROM 
`'.$db->get_config('table')."` WHERE incom_date >= 
'{$_POST['date_from']}' AND incom_date <= '{$_POST['date_to']}' ORDER BY 
incom_date desc");
		}elseif(isset($_POST['name_unit']) && ($u = $db->get_unit($_POST['name_unit']))){
			$db->custom_query('SELECT * FROM 
`'.$db->get_config('table')."` WHERE name_unit='{$u}' ORDER BY 
incom_date desc LIMIT 25");
		}elseif(!empty($_POST['incom'])){
			$_POST['incom'] = mysql_real_escape_string($_POST['incom']);
			$db->custom_query('SELECT * FROM 
`'.$db->get_config('table')."` WHERE incom LIKE '%{$_POST['incom']}%' 
ORDER BY incom_date desc LIMIT 25");
		}elseif(isset($_POST['date_from']) && isset($_POST['date_to']) && 
			$db->check_input(array('date_from' => '\d{1,2}-\d{1,2}-\d{4}', 'date_to' => '\d{1,2}-\d{1,2}-\d{4}'), $_POST)){
			preg_match('/^(\d{1,2})-(\d{1,2})-(\d{4})$/', $_POST['date_from'], $m);
			$_POST['date_from'] = date("Y-m-d", strtotime("{$m[3]}-{$m[2]}-{$m[1]}"));
			preg_match('/^(\d{1,2})-(\d{1,2})-(\d{4})$/', $_POST['date_to'], $m);
			$_POST['date_to'] = date("Y-m-d", strtotime("{$m[3]}-{$m[2]}-{$m[1]}"));
			$db->custom_query('SELECT * FROM 
`'.$db->get_config('table')."` WHERE incom_date >= 
'{$_POST['date_from']}' AND incom_date <= '{$_POST['date_to']}' ORDER BY 
incom_date desc LIMIT 50");
		}else{
			$db->custom_query('SELECT * FROM 
`'.$db->get_config('table').'` ORDER BY incom_date desc LIMIT 25');
		}
	}else{
		$db->custom_query('SELECT * FROM 
`'.$db->get_config('table').'` ORDER BY incom_date desc LIMIT 25');
	}
	
	$r = $db->st();
	if($r !== FALSE && !empty($r[0])){
		for($i=0; $i < count($r); $i++){
			foreach ($r[$i] as $key => $val){
				if(preg_match('/date/', $key)){
					$r[$i][$key] = implode('-', array_reverse(explode('-', array_shift(explode(' ', $r[$i][$key])))));
					if(preg_match('/0{4}/', $r[$i][$key])){
						$r[$i][$key] = '-';
					}
					if($r[$i]['date_exec'] == '-' && $r[$i]['date_recv'] != '-' && strtotime('-2 week')-strtotime($r[$i]['date_recv']) > 0){
						$r[$i]['overdue'] = TRUE;
					}
				}
			}
			list($r[$i]['incom_n'], $r[$i]['incom_d']) = explode('&', $r[$i]['incom']);
		}
		$tpl->assign('lst', $r);
		$tpl->assign('lst_len', count($r)+1);
	}
	$tpl->show('list');
}

?>
