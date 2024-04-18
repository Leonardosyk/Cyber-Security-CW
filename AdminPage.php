<?php
session_start();

if (isset($_SESSION['username'])){
    $Username = $_SESSION['username'];

    $servername = "localhost";
    $rootUser = "id19918980_root";
    $db = "id19918980_loginsignup";
    $rootPassword = "K!5eB>([=X4gv\qM";

    // create connection
    $conn = new mysqli($servername, $rootUser, $rootPassword, $db);

    if ($conn -> connect_error)
    {
        die ("connection failed" . $conn -> connect_error);
    }

    echo "<script language=\"JavaScript\">\r\n";
    echo "alert(\"Hi! Administrator " . $Username . ", Welcome back!\");\r\n";
    echo "</script>";

    echo "Current Time: ";
    echo date('Y-m-d h:i:s',time());
    echo "</br>";
    echo "<h1>The users' requests are: </h1>";


    $Query = "SELECT * FROM user_description ORDER BY U_name";
    $result = $conn -> query($Query);

    if ($result -> num_rows > 0)
    {
        $Num = 1;
        while ($Row = $result -> fetch_assoc())
        {
            
            echo "<h4>" . $Num . ". " . "User: " . $Row['U_name'] . "</h4>";
            echo "Description: " . $Row['description'] . "</br></br>";
            $U_name = $Row['U_name'];
            $url3 = 'uploads/'; //图片所存在的目录
            $url0 = '/uploads/'; //图片所存在的目录
            $url = "$url0$U_name/";
            $hostdir=dirname(__FILE__).$url; //要读取的文件夹
            $filesnames = array_slice(scandir($hostdir),2); //得到所有的文件
            if(is_dir("$url3$U_name")){//检查文件夹是否存在 
            
            $www = 'https://project2022syk.000webhostapp.com/'; //域名
            
            foreach ($filesnames as $name) {
                $aurl= "<img width='450' height='400' img src='".$www.$url.$name."'>"; //图片
                echo $aurl ; //输出他    
            }
            
        }
            else{
                
            }
            echo "<br/><br/>"; 
            $Num += 1;
        }
    }
    else
    {
        echo "<h1>No Requests Found!</h1>";
    }

    echo "<form action = 'index.html' method='POST'>";
    echo "<br/><input type = 'submit' value='Logout'></form>";
    session_destroy();
    }
else {
    echo "<script language=\"JavaScript\">\r\n";

    echo "alert(\"Please login\");\r\n";

    echo " location.replace(\"index.html\");\r\n";

    echo "</script>";
}
// $url = "$url0$U_name/";
// $hostdir=dirname(__FILE__).$url; //要读取的文件夹
// $filesnames = array_slice(scandir($hostdir),2); //得到所有的文件
// //  print_r($filesnames);exit;
// //获取也就是扫描文件夹内的文件及文件夹名存入数组 $filesnames

// $www = 'https://project2022syk.000webhostapp.com/'; //域名

// foreach ($filesnames as $name) {
//     $aurl= "<img width='450' height='400' img src='".$www.$url.$name."'>"; //图片
//     echo $aurl ; //输出他
// }

?>