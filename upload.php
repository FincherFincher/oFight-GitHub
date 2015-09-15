<?php

    define("OFIGHTENGINE", true);
    define ( 'ROOT_DIR', dirname ( __FILE__ ) );

    include_once('engine/configs/dbconfig.php');
    include_once('engine/classes/database.class.php');

    include_once(ROOT_DIR . '/engine/classes/users.class.php');
    $user = new Users();




    if($_POST['fUploadType'] == 'uAvatar'){

        if($_FILES['file']['type'] != 'image/jpeg'){
            echo '0';
            exit();
        }

        if($_FILES['file']['size'] > 100000){
            echo '2';
            exit();
        }

        $fname = md5(strval(time())).'.'.explode('.', $_FILES['file']['name'])[1];

        $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
        $targetPath = $_SERVER['DOCUMENT_ROOT']."/uploads/avatars/".$fname; // Target path where file is to be stored

        if(move_uploaded_file($sourcePath, $targetPath)){
            $uName = $_SESSION['username']; session_write_close();
            $uData = $user->userinfo($uName);
            $user->setAvatar($uName, $fname);
            
            if($uData['avatar'] != 'defaultavatar.jpg'){
                unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/avatars/'.$uData['avatar']); 
            }
            
            echo $fname;
        } 
        exit();
    }


    if($_POST['fUploadType'] == 'regularUpload'){

        if($_FILES['file']['type'] != 'image/jpeg'){
            echo '1';
            exit();
        }

        if($_FILES['file']['size'] > 200000){
            echo '2';
            exit();
        }

        $fname = md5(strval(time())).'.'.explode('.', $_FILES['file']['name'])[1];

        $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
        $targetPath = $_SERVER['DOCUMENT_ROOT']."/uploads/".$fname; // Target path where file is to be stored

        if(move_uploaded_file($sourcePath, $targetPath)){
            echo $fname;
        } 
        exit();
    }






?>