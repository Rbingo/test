# Excel数据导入到MySQL中
 

PHP上传Excel,并将数据导入数据库,使用PHPEXCEL类
 
 
 * 其中的方法是比较费时的,其实可以将数据拼接起来，只要不大于MYSQL设置的max_allowed_packet,一条SQL就可以搞定,而不需要读一条数据就操作一次MYSQL
 
 
 - 修改如下：
 
 $sql='insert into think_excel (id,name) values ';
 for ($row = 2; $row <= $highestRow; $row++){//行数是以第1行开始
		$i=0;
	    for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
	        $dataset[$title[$i].''] = $sheet->getCell($column.$row)->getValue();
	        $i++;
	    }
	    $sql .="(".$dataset['id'].",'".$dataset['name']."'),";
	    // echo $sql;
	}
  mysqli_query($conn,$sql);
	echo mysqli_error($conn);
  $dataset=array();
