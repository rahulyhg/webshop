<?php //include_once 'config.php';




 function getIDByQuery($sql) {
try {
        
        $sql = "SELECT * FROM freshquater_user WHERE id=:id ";
        //$db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $user->id);
        $stmt->execute();
        $getUserdetails = $stmt->fetchObject();
        
        
        
        
        
        
        $db = getConnection();
        $stmt = $db->prepare($sql); 
        $stmt->execute();
        if($stmt->rowCount()>0)
        {
            
            $getUserdetails = $stmt->fetchObject();
            
            $data['user_id']= $getUserdetails->id;
		    $data['ACK']=1;
		    $data['msg']='Login Error';
        }
        else
        {
            $data['user_id']='0';
		    $data['ACK']=0;
		    $data['msg']='Login Error';
        }
    }
    catch(PDOException $e) {
        return 0; 
    }
}
 
 
 function updateByQuery($sql) {
try {
        $db = getConnection();
        $stmt = $db->prepare($sql); 
        $data = $stmt->execute();
        if($stmt->rowCount()>0)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    catch(PDOException $e) {
        return 0; 
    }
}




/*
 * $sql : Sql query with conditions
 * $type : all - find multiple row
 *         one - find one row
 */
function findByQuery($sql,$type='all')
{
    $rarray = array();
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute(); 
        if($type=='one')
            $rarray = $stmt->fetch(PDO::FETCH_ASSOC);
        else
            $rarray = $stmt->fetchAll();
        $db = null;
        return $rarray; 
    } catch(PDOException $e) {
 return $rarray; 
    }
}




function findByConditionArray($conditions,$table) {
        $rarray = array();
	$sql = "SELECT * FROM ".$table;
	try {
            if(!empty($conditions)) 
            {
                $sql .= " WHERE ";
                foreach ($conditions as $key=>$condition)
                {
                    $sql .= "$key=:$key ";
                    $$key = $condition;
                }
            }
            $db = getConnection();
            $stmt = $db->prepare($sql);
            $s = json_decode(json_encode($conditions));
            if(!empty($s))
            {
                foreach ($s as $key => $t) 
                {
                    //echo $t.$key;
                    $stmt->bindValue($key, $s->$key);
                    //$sql .= "$key=:$key ";
                }
            }
            //exit;

            $stmt->execute();			
            $rarray = $stmt->fetchAll();
            $db = null;
            return $rarray; 
	} catch(PDOException $e) {
		return $rarray; 
	}
}

?>
