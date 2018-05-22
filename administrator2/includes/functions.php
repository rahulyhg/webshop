<?php

function filter($var)
{
	//$var=nl2br($var);
  //	$var=str_replace("\'","'",$var);
	//$var=str_replace("'","''",$var);
	//$var=preg_replace('/&$/','',$var);
	//$var=str_replace("\\'", "''", $var);	//SQL Special Characters
 
	if(get_magic_quotes_gpc() ) 
		$var = stripslashes($var );
	$var = preg_replace('/[^\x09\x0a\x0d\x20-\x7e]/', '?', $var );	
	return $var;
}
function html2txt($document){
		$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
					   '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
					   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
					   '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
		);
		$text = preg_replace($search, '', $document);
		return $text;
		}

function filter_template($var)
{
	//$var=nl2br($var);
  	$var=str_replace("\'","'",$var);
	$var=str_replace("'","''",$var);
	$var=preg_replace('/&$/','',$var);
	$var=str_replace("\\'", "''", $var);	//SQL Special Characters
	return $var;
}

//$absolute_path=str_replace("includes\config.php","",__FILE__);

//PHP FILE NAME---------------------------------------------------------------------------------------------
//echo "File Name : ".basename(__FILE__);

//PASSWORD ENCRYPT---------------------------------------------------------------------------------------------
//echo md5("Password");

//DATE TIME FORMAT---------------------------------------------------------------------------------------------
function date_time_format($date_time,$flag)
{
	$unx_stamp=strtotime($date_time);
	$date_str="";
	switch($flag)
	{
		case 1: $date_str=(date("Y-m-d",$unx_stamp)); break;//2004-06-29
		case 2: $date_str=(date("m-d-Y",$unx_stamp)); break;//06-29-2004
		case 3: $date_str=(date("d-m-Y",$unx_stamp)); break;//29-06-2004
		case 4: $date_str=(date("d M Y",$unx_stamp)); break;//29 Jun 2004
		case 5: $date_str=(date("d F Y",$unx_stamp)); break;//29 June 2004
		case 6: $date_str=(date("jS M Y",$unx_stamp)); break;//29th Jun ,2004
		//case 6: $date_str=date("M j",$unx_stamp)."<sup>".date("S",$unx_stamp)."</sup>".date(", Y",$unx_stamp); break;
		case 7: $date_str=(date("D M dS",$unx_stamp)); break;//Tue Jun 29th,2004
		case 8: $date_str=(date("l M jS,Y",$unx_stamp)); break;//Tuesday Jun 29th,2004
		case 9: $date_str=(date("l F jS,Y",$unx_stamp)); break;//Tuesday June 29th,2004
		case 10: $date_str=(date("d F Y l",$unx_stamp)); break;//29 June 2004 Tuesday
		case 11: $date_str=(date("M j, Y g:i A",$unx_stamp)); break;//29 June 2004 Tuesday
		case 12: $date_str=(date("F d, Y",$unx_stamp)); break;//29 June 2004 Tuesday
		case 13: $date_str=(date("l d.m.Y",$unx_stamp)); break;//Tuesday 06.29.2004
		case 14: $date_str=(date("D d.m.Y",$unx_stamp)); break;//Tuesday 06.29.2004
	}
	
	
	/*$time_str="";
	switch(mysql_result(mysqli_query($con,"select value from configuration where id=2"),0,0))
	{
		case 1: $time_str=(date("h:i a",$unx_stamp)); break;//06:20 pm
		case 2: $time_str=(date("h:i A",$unx_stamp)); break;//06:20 PM
		case 3: $time_str=(date("H:i",$unx_stamp)); break;//18:20
	}
	*/
	
	switch($flag)
	{
		case 1: return($date_str); break;
		case 2: return($time_str); break;
		case 3: return($date_str."&nbsp; ".$time_str); break;
		default: return($date_str); break;
	}

}
//echo date_time_format("2012-09-07 10:20 AM",3);	//	1=date	2=time	3=date+time
//---------------------------------------------------------------------------------------------

//----------------------------------Random ID-------------------------------------------------

function unique_id($len = 8)
{
	$temp=mt_rand(1,500);
	$temp=md5($temp);
	$temp=substr($temp,0,$len);
	$temp=strtoupper($temp);
	return $temp;
}
//$pass=unique_id();
//////-----------------------------------------------------------------------------------------

function message($var="",$mode)
{
	switch($mode)
	{
		case 1:$var=" <font class='success_style'>".$var."</font> ";	//Success
				break;
		case 2:$var=" <font class='read_text03'>".$var."</font> ";	//Error
				break;
		case 3:$var=" <font class='error_style'>".$var."</font> ";	//Message
				break;
		case 4:$var=" <font class='critical_style'>".$var."</font> ";	//Critical
				break;
		default:$var=" <font class='message_style'>".$var."</font> ";	//Message
				break;
	}
	return $var;
}

function text_alert($var="",$mode=3)
{
	switch($mode)
	{
		case 1:$var=" <font class='alert_success'>".$var."</font> ";	//Success
				break;
		case 2:$var=" <font class='alert_error'>".$var."</font> ";	//Error
				break;
		case 3:$var=" <font class='alert_message'>".$var."</font> ";	//Message
				break;
		case 4:$var=" <font class='alert_critical'>".$var."</font> ";	//Critical
				break;
		default:$var=" <font class='alert_message'>".$var."</font> ";	//Message
				break;
	}
	return $var;
}


function send_mail($to, $subject, $message ,$from) 
{
	$header = "MIME-Version: 1.0\n";
	$header=$header."From: ".$from."\n";
	$header=$header."Content-Type: text/html; charset=\"iso-8859-1\"\n";
	
	$flag=@mail($to, $subject, $message, $header);

	if($flag==false)	//delete
		$_SESSION['mail_display']="<b>To:</b> $to<br><b>From:</b> $from<br><b>Subject:</b> $subject<br><b>Message:</b><br>$message";	//delete
	return  $flag;
}

function prepare_send_mail($format_id,$member_id)//$format_id=mail format id	
{
	if($format_id!='' || $member_id!='')
	{
		$result=mysqli_query($con,"select * from mail_invitation where id='$member_id'");
		if($row=mysqli_fetch_object($result))
		{
			$row1=mysqli_fetch_object(mysqli_query($con,"select * from automated_mail where sl_no='$format_id'"));
			
			$to=$row->email_id;
			//if($row->rank==1)
				//$to=mysql_result(mysqli_query($con,"select value from configuration where id=7"),0,0);
			$from=mysql_result(mysqli_query($con,"select value from configuration where id=6"),0,0);
			$subject=$row1->subject;
			$message=$row1->message;
		
			$subject=str_replace("  ","&nbsp;&nbsp;",$subject);
			$subject=nl2br($subject);
			//$subject=str_replace("#full_name#",$row->name,$subject);
			$subject=str_replace("#site_url#",SITE_URL,$subject);
			
			$message=str_replace("  ","&nbsp;&nbsp;",$message);
			$message=nl2br($message);
			//$message=str_replace("#name#",$row->name,$message);
			
		
			if($format_id==1)
			{
				//$subject=str_replace("#email_id#",$row->email_id,$subject);
				$site_url=SITE_URL."inform.php?invi_code=".$row->code;
				$message=str_replace("#site_url#",$site_url,$message);
				$message=str_replace("#email_id#",$row->email_id,$message);
			}
			/*if($format_id==1 || $format_id==3)
			{
				$password=mysql_result(mysqli_query($con,"select password from admin_user where member_id='$member_id'"),0,0);
				$subject=str_replace("#password#",$password,$subject);
				$message=str_replace("#password#",$password,$message);
			}*/
			return send_mail($to,$subject,$message,$from);
		}
		
	}
	else return false;
}

function output_file($file,$name)					//Download file as attachment
{
	//do something on download abort/finish
	//register_shutdown_function( 'function_name'  );
	if(!file_exists($file))
		die('file not exist!');
	$size = filesize($file);
	$name = rawurldecode($name);
	
	if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT']))
		$UserBrowser = "Opera";
	elseif (ereg('MSIE ([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT']))
		$UserBrowser = "IE";
	else
	$UserBrowser = '';
	
	/// important for download im most browser
	$mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ?
	 'application/octetstream' : 'application/octet-stream';
	@ob_end_clean(); /// decrease cpu usage extreme
	header('Content-Type: ' . $mime_type);
	header('Content-Disposition: attachment; filename="'.$name.'"');
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header('Accept-Ranges: bytes');
	header("Cache-control: private");
	header('Pragma: private');
	
	/////  multipart-download and resume-download
	if(isset($_SERVER['HTTP_RANGE']))
	{
		list($a, $range) = explode("=",$_SERVER['HTTP_RANGE']);
		str_replace($range, "-", $range);
		$size2 = $size-1;
		$new_length = $size-$range;
		header("HTTP/1.1 206 Partial Content");
		header("Content-Length: $new_length");
		header("Content-Range: bytes $range$size2/$size");
	}
	else
	{
		$size2=$size-1;
		header("Content-Length: ".$size);
	}
	$chunksize = 1*(1024*1024);
	$this->bytes_send = 0;
	if ($file = fopen($file, 'r'))
	{
		if(isset($_SERVER['HTTP_RANGE']))
		fseek($file, $range);
		while(!feof($file) and (connection_status()==0))
		{
			$buffer = fread($file, $chunksize);
			print($buffer);//echo($buffer); // is also possible
			flush();
			$this->bytes_send += strlen($buffer);
			//sleep(1);//// decrease download speed
		}
		fclose($file);
	}
	else
		die('error can not open file');
	if(isset($new_length))
		$size = $new_length;
	die();
} 

function delete_directory($dir)
{
   if (substr($dir, strlen($dir)-1, 1) != '/')
       $dir .= '/';
   if ($handle = opendir($dir))
   {
       while ($obj = readdir($handle))
       {
           if ($obj != '.' && $obj != '..')
           {
               if (is_dir($dir.$obj))
               {
                   if (!deleteDir($dir.$obj))
                       return false;
               }
               elseif (is_file($dir.$obj))
               {
                   if (!unlink($dir.$obj))
                       return false;
               }
           }
       }

       closedir($handle);

       if (!@rmdir($dir))
           return false;
       return true;
   }
   return false;
}

function convert_to_mysql_date($date)		//converts a date form '31/12/2006' => '2006-12-31'
{
	$first_slash_pos=strpos($date,'/');
	$second_slash_pos=strpos($date,'/',strpos($date,'/')+1);
	
	$day=substr($date,0,$first_slash_pos);
	$mon=substr($date,$first_slash_pos+1,($second_slash_pos-$first_slash_pos)-1);
	$year=substr($date,-4);

	$day=strlen($day)==1?"0".$day:$day;	
	$mon=strlen($mon)==1?"0".$mon:$mon;
		
	$date=$year."-".$mon."-".$day;
	return $date;
}
function convert_to_normal_date($date)		//converts a date form '2006-12-31' => '31/12/2006' 
{
	$date_arr=explode("-",$date);
	$date=(integer)$date_arr[2]."/".(integer)$date_arr[1]."/".(integer)$date_arr[0];
	return $date;
}

function month_in_datediff($dformat, $endDate, $beginDate)
{
	$date_parts1=explode($dformat, $beginDate);
	$date_parts2=explode($dformat, $endDate);
	$start_date=gregoriantojd($date_parts1[1], $date_parts1[0], $date_parts1[2]);
	$end_date=gregoriantojd($date_parts2[1], $date_parts2[0], $date_parts2[2]);
	
	$total_day_diff=$end_date - $start_date;
	$month=($total_day_diff/365)*12;
	return round($month,0);
}
//month_in_datediff("/", date("d/m/Y"),"25/7/1981");

function day_in_datediff($dformat, $endDate, $beginDate)
{
	$date_parts1=explode($dformat, $beginDate);
	$date_parts2=explode($dformat, $endDate);
	$start_date=gregoriantojd($date_parts1[1], $date_parts1[0], $date_parts1[2]);
	$end_date=gregoriantojd($date_parts2[1], $date_parts2[0], $date_parts2[2]);
	
	$total_day_diff=$end_date - $start_date;
	
	return $total_day_diff;
}
//day_in_datediff("/", date("d/m/Y"),"25/7/1981");

function error($message)
{
	$_SESSION['msg']=$message;     
	header('Location: error.php');
	exit();
}
function image_exists($path)	//	$path=	"../uploads/a.gif"
{
	if($path=='' || $path==NULL || substr($path,(strlen($path)-1))=='/' || !file_exists($path))
		return false;
	else
		return true;
}
function check_type_support($userfile_type)
{
	$flag=0;
	if ($userfile_type == 'image/x-png')
	{
		$userfile_type = 'image/png';
	}
	if ($userfile_type == 'image/pjpeg')
	{
		$userfile_type = 'image/jpeg';
	}
	
	switch($userfile_type)
	{
		case 'image/gif':
						break;
		case 'image/png':
						break;
		case 'image/jpeg':
						break;
		default:
			  $flag=1;
			  break;
	}
    return $flag;	
}
function encode($str)
{
	return base64_encode($str);
}
function decode($str)
{
	if($str!="")
	{
		return base64_decode($str);
	}
	else
	{
		header('location:error.html');

		exit();
	}
}
function counttot($table,$field,$id)
{
	$tot=mysqli_num_rows(mysqli_query($con,"select * from ".$table." where ".$field."='".$id."'"));
	return $tot;
}
function updatecount($id)
{
	mysqli_query($con,"update book set click=click+1 where id='".$id."'")or die(mysql_error());
}
function thumb($filename,$width,$height,$auto,$savepath)
{
		
				$thumb=new thumbnail($filename);			// generate image_file, set filename to resize
				$thumb->size_width($width);					// set width for thumbnail, or
				$thumb->size_height($height);				// set height for thumbnail, or
				$thumb->size_auto($auto);					// set the biggest width or height for thumbnail
				$thumb->jpeg_quality(75);				// [OPTIONAL] set quality for jpeg only (0 - 100) (worst - best), default = 75						// show your thumbnail
				$thumb->save($savepath);
				
}

 function tep_db_input($string, $link = 'db_link') {
    global $$link;
    return addslashes($string);
  }
 function tep_db_perform($table, $data, $action = 'insert', $parameters = '', $link = 'sexsearch') {
    reset($data);
    if ($action == 'insert') {
    $query = 'insert into ' . $table . ' (';
      while (list($columns, ) = each($data)) {
        $query .= $columns . ', ';
      }
      $query = substr($query, 0, -2) . ') values (';
      reset($data);
      while (list(, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= 'now(), ';
            break;
          case 'null':
            $query .= 'null, ';
            break;
          default:
            $query .= '\'' . tep_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ')';
	//echo $query;
	//exit();
	  
    } elseif ($action == 'update') {
      $query = 'update ' . $table . ' set ';
      while (list($columns, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= $columns . ' = now(), ';
            break;
          case 'null':
            $query .= $columns .= ' = null, ';
            break;
          default:
            $query .= $columns . ' = \'' . tep_db_input($value) . '\', ';
            break;
        }
      }
     $query = substr($query, 0, -2) . ' where ' . $parameters;
	//echo $query;
		//exit();
  
   
	
    }
	elseif ($action == 'delete')
	{
		 $query = 'delete from ' . $table . ' where '. $parameters;
	}
    return mysqli_query($con,$query)or die(mysql_error());
  }
  function showscreenname($id)
  {
  	$Profile=mysqli_query($con,"select * from sex_tbluser where user_id='".$id."'")or die(mysql_error());
	if(mysqli_num_rows($Profile)>0)
	{
		$RsProfile=mysqli_fetch_object($Profile);
		if($RsProfile->screen_name!="")
		{
			$str.=$RsProfile->screen_name."\n";
		}
		return $str;
	}
  }
  function showmailprofile($id)
  {
  	$Profile=mysqli_query($con,"select * from sex_tbluser where user_id='".$id."'")or die(mysql_error());
	if(mysqli_num_rows($Profile)>0)
	{
		$RsProfile=mysqli_fetch_object($Profile);
		
		if($RsProfile->age!="")
		{
			$str.=$RsProfile->age."&nbsp;Years&nbsp;";
		}
		if($RsProfile->sex!="")
		{
			$str.=$RsProfile->sex."<br>";
		}
		if($RsProfile->city!="")
		{
			$str.=$RsProfile->city.", ";
		}
		if($RsProfile->state!="")
		{
			$str.=$RsProfile->state.", ";
		}
		if($RsProfile->country!="")
		{
		
			$Country=mysqli_query($con,"select * from countries where countries_id='".$RsProfile->country."'")or die(mysql_error());
			if(mysqli_num_rows($Country)>0)
			{
				$RsCountry=mysqli_fetch_object($Country);
																
                   $str.=$RsCountry->countries_name;                                          												
		  }
			
		}
		return $str;
	}
  }
  function trace($id)
  {
	
   $x=@mysql_result(mysqli_query($con,"select count(*) from  sex_tblmail WHERE (to_deleted='".$id."' or from_deleted='".$id."') and deletedby <> '".$id."' "),0,0); 
	
  	return $x;
  }
  function newmail($id)
  {
  	$selectsql=mysqli_query($con,"SELECT * FROM sex_tblmail a WHERE to_id='".$id."' and to_deleted <>'".$_SESSION['userid']."' and is_new='0' and is_sent='1' and to_folderid='1' and status='1'")or die(mysql_error());
  	
	return mysqli_num_rows($selectsql);
  }
  function draft($id)
  {
  	$selectsql=mysqli_query($con,"select * from sex_tblmail where from_id='".$id."' and from_deleted <>'".$_SESSION['userid']."'  and from_folderid='2' ")or die(mysql_error());
	return mysqli_num_rows($selectsql);
  }
  function total($id)
  {
  	$selectsql=mysqli_query($con,"select * from sex_tblmail where status='1' and  to_id='".$id."' and is_draft='0'")or die(mysql_error());
	return mysqli_num_rows($selectsql);
  }
  function send($id)
  {
  	$selectsql=mysqli_query($con,"select * from sex_tblmail a where a.from_folderid='3' and a.from_deleted <> '".$id."' and from_id='".$id."'")or die(mysql_error());
	return mysqli_num_rows($selectsql);
  }
  function composeto($id)
  {
  	$selectsql=mysqli_query($con,"select * from sex_tblfriend st,sex_tbluser su where st.friend_id=su.user_id and st.friend_id<>'".$id."'")or die(mysql_error());
	return $selectsql;
  }
  function online($id)
  {
  	$Online=mysqli_query($con,"select * from sex_tbluser where online='1' and user_id<>'".$id."'")or die(mysql_error());
	$total=mysqli_num_rows($Online);
	return $total."&nbsp;Members Online!*";
  }
  function dateDiff($dformat, $endDate, $beginDate)
	{
		$date_parts1=explode($dformat, $beginDate);
		$date_parts2=explode($dformat, $endDate);
		//echo $date_parts1[1]."----".$date_parts1[0]."-----".$date_parts1[2];
		$start_date=gregoriantojd($date_parts1[1], $date_parts1[0], $date_parts1[2]);
		$end_date=gregoriantojd($date_parts2[1], $date_parts2[0], $date_parts2[2]);
		return $end_date - $start_date;
	}
 function fttocm($ft,$in)
 {
 	$result=($in +($ft * 12)* 2.54);
	return $result;
 }
 function generatePassword ($length = 8)
{

  // start with a blank password
  $password = "";

  // define possible characters
  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; 
    
  // set up a counter
  $i = 0; 
    
  // add random characters to $password until $length is reached
  while ($i < $length) { 

    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        
    // we don't want this character if it's already in the password
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }

  // done!
  return $password;

}
function dateofjoin($id)
{
	
	$sql=mysqli_query($con,"select * from sex_tbluser where user_id='". $id."'");
	if(mysqli_num_rows($sql)>0)
	{
		$RsSql=mysqli_fetch_object($sql);
		$Register=date_time_format($RsSql->register_date,12);
		return $Register;
	}
}
function userphoto($id)
{

	$Photo=mysqli_query($con,"select * from sex_tbluserphoto where user_id='".$id."' and status='1'")or die(mysql_error());
		
		if(mysqli_num_rows($Photo)>0)
		{
		
			$RsPhoto=mysqli_fetch_object($Photo);
			 $UserImg=$RsPhoto->photo;
		}
		else
		{
			$UserImg="";
		}
		return $UserImg;
}

function userphotosmall($id)
{ 
	//echo "select * from ep_user_photo where userid='".$id."'";
	//exit();
	$Photo=mysqli_query($con,"select * from trainee_profile where profile_id='".$id."'")or die(mysql_error());
	//$gender=@mysql_result(mysqli_query($con,"select gender from ep_user_photo where userid='".$id."'"),0,0);
		
		if(mysqli_num_rows($Photo)>0)
		{
    		$RsPhoto=mysqli_fetch_object($Photo);
            $UserImg=$RsPhoto->image;
			 
		}
		else
		{
			 $UserImg="male.jpg";
			
			
		/*if($gender=="Female")
			{
			$UserImg='female.jpg';
			}
			else if($gender=="Male")
			{
			$UserImg='male.jpg';
			}
			else
			{
			$UserImg="male.jpg";
			}*/
		}
		
		 return $UserImg;
	
}
function totalmember()
{
	$Member=mysqli_query($con,"select * from sex_tblmail");
	return mysqli_num_rows($Member);
}
function newmailimage($id)
  {
  	$selectsql=mysqli_query($con,"SELECT * FROM sex_tblmail a WHERE mail_id='".$id."' and is_new='1' and to_folderid='1' and status='1'")or die(mysql_error());

	if(mysqli_num_rows($selectsql)>0)
	{
		$img='<img src="images/open.jpg" alt="" border="0"/>';
	}
	else
	{
		$img='<img src="images/close_envalop.jpg" alt="" border="0" />';
	}
	return $img;
  }
  /////////////////////select command////////////////////////////////////////
  function select( $table, $where='', $select='*', $limit='', $order='', $group='', $debug=false ) {
	connect();
	
	if( is_string( $table ) and ( strpos( $table, ',') !== false or strpos( $table, ' ' ) !== false ) ) {
		$table = preg_replace( '/([ ,]{1,})/', '`\\1`', $table );
	}
	
	if( is_array( $table ) ) {
		foreach( $table as $key => $val ) {
			if( strpos( $table, ',') !== false or strpos( $table, ' ' ) !== false ) {
				$table = '`'.preg_replace( '/([ ,]{1,})/', '`\\1`', $table ).'`';
			}
		}
		$table = implode( ', ', $table );
	}
	
	$where = make_where( $where );
	if( $where != '' ) {
		$where = ' WHERE '.$where;
	}
	if( $limit != null ) {
		if( $limit == 1 ) {
			$limit_text = 'LIMIT 0, 1';
		} else {
			$limit_text = 'LIMIT '.$limit;
		}
	}
	if( $order != null ) {
		$order_text = 'ORDER BY '.$order;
	}
	if( $group != '' ) {
		if( substr( $group, 0, 4 ) == 'sql:' ) {
			$group_text = 'GROUP BY '.substr( $group, 4 );
		} elseif( strpos( $group, ',' ) ) {
			$group_a = preg_split( '/(\W)*[,](\W+)*/', $group );
			$group = implode( '`, `', $group_a );
			$group_text = 'GROUP BY `'.$group.'`';
		} else {
			$group_text = 'GROUP BY `'.str_replace( '.', '`.`', $group).'`';
		}
	}
	if( $select == '' or $select == null ) {
		$select = '*';
	} elseif( is_array( $select ) ) {
		$select = implode( ', ', $select );
	}
	//echo "SELECT". $select." FROM ". $table .$where. $group_text .$order_text.$limit_text;
	
	$return = query( "SELECT $select FROM `$table` $where $group_text $order_text $limit_text;", $debug );
	//If we were only asked for one row, or for a count we only return that.
	if( $limit == 1 or ( ( substr( $select, 0, 6 ) == 'count(' or substr( $select, 0, 4 ) == 'avg(' ) and strpos( $select, ',' ) === false ) ) {
		if( $debug == true ) {
			echo 'removing data from array<br />\n';
		}
		$return = $return[0];
		//If the select was only one item we only return that one item.
		if( strpos( $select, ',' ) == false and $select != '*' and is_array( $return ) ) {
			$keys = array_keys( $return );
			$select_key = $keys[0];
			$return = $return[$select_key];
		}
	} elseif( strpos( $select, ',' ) == false and $select != '*' and is_array( $return[0] ) ) {
		$keys = array_keys( $return[0] );
		$select_key = $keys[0];
		foreach( $return as $key => $val ) {
			$return[$key] = $val[$select_key];
		}
	}
	if( $debug != false ) {
		dump( $return );
	}
	
	return $return;
	
}

function sitecontent($str)
		{
		//echo $a="SELECT pagedetail FROM travel_cms where id='$str'";exit;
		$pagedetail=@mysql_result(mysqli_query($con,"SELECT pagedetail FROM travel_cms where id='$str'"),0,0);
		return stripslashes($pagedetail);
		}


function cms_content($id)
{
echo "select * from `frame_cms` where `id`=$id";exit;
$content=mysqli_fetch_array(mysqli_query($con,"select * from `frame_cms` where `id`=$id"));
return $content['pagedetail'];
}  

function get_lat_log($location,$zip)
{
		$address = $location.','.$zip;
		$prepAddr = str_replace(' ','+',$address);
		$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
		$output= json_decode($geocode);
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;
		
		$main['latitude']=$latitude;
		$main['longitude']=$longitude;
		
		return $main;

}
?>