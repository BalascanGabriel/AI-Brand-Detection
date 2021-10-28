<?php

if(isset($_POST['submit']))
{

$target_dir = "poze/";
$target_file = $target_dir . basename($_FILES["fisier"]["name"]);

$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$path = "poze/";

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
    {
        $file1 = $_FILES['fisier']['name']; //input file name in this code is file1
        $size = $_FILES['fisier']['size'];

        if(strlen($file1))
            {
                list($txt, $ext) = explode(".", $file1);
                
                        $actual_image_name = $txt.".".$ext;
                        $tmp = $_FILES['fisier']['tmp_name'];
                        if(move_uploaded_file($tmp, $path.$actual_image_name))
                            {
                            	echo "Fisierul a fost trimis!";
				
                            }
                        else
                            echo "Fisierul nu s-a putut trimite";  
			             
                    
        }
    }
}


?>