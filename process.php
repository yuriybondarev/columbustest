<?php

function process_csv() {
    $res_csv = "Код,Название,Error\n";
    $fileName = $_FILES["f"]["tmp_name"];
    
    if ($_FILES["f"]["size"] > 0) {
        include "db.php";
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $code = "";
            if (is_numeric($column[0])){
                if (isset($column[0]) && (strcmp('code',$column[0]) != 0)) {
                    $code = intval($column[0]);
                }
            }
            $title = "";
            if (isset($column[1])) {
                $title = mysqli_real_escape_string($conn, $column[1]);
            }
            if (is_numeric($code)){
                $pattern = "/[\.\-A-Za-zЁёА-Яа-я0-9]{".strlen($title).",}/";
                if(preg_match($pattern, $title)){
                    $check_stmt = $conn->prepare("SELECT * FROM `main` WHERE `code`=?");
                    $check_stmt->bind_param('i', $code);
                    $check_stmt->execute();
                    $q1 = $check_stmt->get_result();
                    if ($q1->num_rows == 0){
                        $stmt = $conn->prepare("INSERT into `main` (`code`, `title`) values (?,?)");
                        $stmt->bind_param('is', $code, $title);
                        $stmt->execute();
                    }
                    else{
                        $stmt = $conn->prepare("UPDATE `main` SET `title`=? WHERE `code`=?");
                        $stmt->bind_param('si', $title, $code);
                        $stmt->execute();
                    }
                    $res_csv = $res_csv . $code . "," . $title . ",\n";
                }
                else{
                    $pattern2 = "/[^\.\-A-Za-zЁёА-Яа-я0-9]{1,}/";
                    preg_match($pattern, $title, $matches, PREG_OFFSET_CAPTURE);
                    //$res_csv = $res_csv . $code . "," . $title . ",недопустимый символ '" . $matches[0] . "' в поле Название\n";
                    $res_csv = $res_csv . $code . "," . $title . ",недопустимый символ '" . $matches[0][0] . "' в поле Название\n";
                }
            }
            /*if (! empty($insertId)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }*/
        }
    }
    //return $res_csv;
    echo $res_csv;
}

if ($conn -> connect_errno) {
    echo "Failed to connect to MySQL: " . $conn -> connect_error;
    exit();
  }
process_csv();

?>