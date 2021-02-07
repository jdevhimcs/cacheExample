<?php
$time_start = microtime(true);

try{
	$cacheFile = 'cacheFolder/index.cache.php';
	if(file_exists($cacheFile) && filemtime($cacheFile)+20 > time() ){
		echo 'From Cache <br>';
		echo filemtime($cacheFile)+20; echo '<br>';
		echo time();
		include($cacheFile);		
	}else{
		echo 'From code <br>';
		$con 	= new PDO('mysql:host=localhost;dbname=demo', 'root', '');
	
		$result	= $con->query("SELECT * FROM member"); 
		$output = '<table border=1>';
		$output.= '<tr><td>Name</td><td>Gender</td><td>Email</td><td>Mobile</td><td>Basic Info</td></tr>';
		if($result->rowCount()>0){		
			while($row = $result->fetch(PDO::FETCH_ASSOC)){
				//print_r($row);
				//$jsonValue = json_decode($row['basic_info']);
				//var_dump($jsonValue);
				$output.= '<tr>';
					$output.= '<td>'.$row['first_name'].' '.$row['last_name'].'</td>';
					$output.= '<td>'.$row['gender'].'</td>';
					$output.= '<td>'.$row['email'].'</td>';
					$output.= '<td>'.$row['mobile'].'</td>';
					$output.= '<td>'.$row['basic_info'].'</td>';
				$output.= '</tr>';			
			}		
		}else{
			$output.= '<tr><td colspan"5">No record found!</td></tr>';
		}
		$output.= '</table>';		
		echo $output;
		
		$fileOpen = fopen($cacheFile, "w+");
		fwrite($fileOpen, $output);
		fclose($fileOpen);		
	}
	
}catch(PDOException $e){
	print "Database error : " . $e->getMessage();die(); 
}
catch(Exception $e) {
  echo "Error : " .$e->getMessage();die(); 
}
$con = null;
$time_end = microtime(true);


echo 'Execution Time '. sprintf('%f', $time_end - $time_start);
?>