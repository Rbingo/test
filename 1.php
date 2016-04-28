<?php
	//print_r($_FILES);  
	if(move_uploaded_file($_FILES['file']['tmp_name'],'up.xlsx'))//上传文件，成功返回true  
	{
	    echo '上传成功';  
	}else{
		echo '上传失败';
		die;
	}
	$db_server="localhost";
	$db_user_name="root";
	$db_user_password='';
	$db_name="excel";//表名   
	$conn=mysqli_connect($db_server,$db_user_name,$db_user_password,$db_name);
	mysqli_query($conn,"SET NAMES UTF8");
	// mysqli_select_db($db_name, $conn);
	require_once('Classes/PHPExcel/Reader/Excel2007.php');  
	$objReader = new PHPExcel_Reader_Excel2007;  
	$objPHPExcel = $objReader->load("up.xlsx");
	$sheet = $objPHPExcel->getSheet(0); // 读取第一個工作表
	$highestRow = $sheet->getHighestRow(); // 取得总行数 var_dump($highestRow);//50
	$highestColumm = $sheet->getHighestColumn(); // 取得总列数 var_dump($highestColumm);//B
	/** 循环读取每个单元格的数据 */
	for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
	        $title[] = $sheet->getCell($column.'1')->getValue();
	        // $data[]=$sheet->getCell($column.$row)->getValue();
	}
	for ($row = 2; $row <= $highestRow; $row++){//行数是以第1行开始
		$i=0;
	    for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
	        $dataset[$title[$i].''] = $sheet->getCell($column.$row)->getValue();
	        $i++;
	    }
	    $sql="insert into think_excel (id,name) values (".$dataset['id'].",'".$dataset['name']."')";
	    // echo $sql;
	    mysqli_query($conn,$sql);
	    echo mysqli_error($conn);
	    $dataset=array();
	}
	echo "\n";
	echo '添加成功';
	mysqli_close($conn);
?>