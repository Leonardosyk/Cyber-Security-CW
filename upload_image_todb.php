<?php
// 连接数据库
$servername = "localhost";
$rootUser = "id19918980_root";
$db = "id19918980_loginsignup";
$rootPassword = "K!5eB>([=X4gv\qM";
$conn = new mysqli($servername, $rootUser, $rootPassword, $db);

if ($conn -> connect_error)
{
	die ("connection failed" . $conn -> connect_error);
}
// 判断action
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : '';

// 上传图片
if($action=='add'){
    $image = file_get_contents($_FILES['photo']['tmp_name']);
    $type = $_FILES['photo']['type'];
    $sqlstr = "insert into photo(type,binarydata) values('".$type."','".$image."')";
    // @mysql_query($sqlstr) or die(mysql_error());
    header('location:upload_image_todb.php');
    exit();
// 显示图片
}elseif($action=='show'){
    $id = isset($_GET['id'])? intval($_GET['id']) : 0;
    $query = "select * from photo where id=$id";
    $thread = mysqli_fetch_assoc($query);
    if($thread){
        header('content-type:'.$thread['type']);
        echo $thread['binarydata'];
        exit();
    }
}else{}
// 显示图片列表及上传表单
?>
<?php
    $sqlstr = "select * from photo order by id desc";
    $sql = mysqli_query($conn,$sqlstr);
    $result = array();
    while($thread1=mysqli_fetch_assoc($sql)){
        $result[] = $thread1;
    }
    foreach($result as $val){
        echo '<p><img src="upload_image_todb.php?action=show&id='.$val['id'].'&t='.time().'" width="150"></p>';
    }
    if ($sql->execute()){
    echo "<script language=\"JavaScript\">\r\n";

    echo "alert(\"Add new description Successful!\");\r\n";

    echo " location.replace(\"UserPage.php\");\r\n";

    echo "</script>";
}
else {
    echo "<script language=\"JavaScript\">\r\n";

    echo "alert(\"Add new description fail!\");\r\n";

    echo " location.replace(\"UserPage.php\");\r\n";

    echo "</script>";
}

?>