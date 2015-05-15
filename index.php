<?php
//инициализация сессии
session_start();
include("includes/init.php");
include("includes/database.php");
$per_page = 4;//how many entry was show from DB
if($result = $mysqli->query("SELECT * FROM book LEFT JOIN sef ON book.id=sef.id"))
{
    global $mysqli;//define global

    if ($result->num_rows != 0)
    {

        $total_results = $result->num_rows;
        $total_pages = ceil($total_results / $per_page);
        if (isset($_GET['page']) && is_numeric($_GET['page']))
        {
            $show_page = $_GET['page'];
            if($show_page > 0 && $show_page <= $total_pages)
            {
                $start = ($show_page - 1) * $per_page;
                $end = $start + $per_page;
            }
            else
            {
                $start = 0;
                $end = $per_page;
            }
        }
        else
        {
            $start = 0;
            $end = $per_page;
        }
        //show pagination
        for ($i = 1; $i <= $total_pages; $i++)
        {
            if (isset($_GET['page']) && $_GET['page'] == $i)
            {
                echo $i . " ";
            }
            else
            {
                echo "
            <ul class='pagination'>
            <li>
            <a class='btn-link'  href='/index.php/page/$i'>" . $i . "</a>
            </li>
            </ul>
            ";
            }
        }
        echo "</p>";
        //show records from DB
        for($i = $start; $i < $end; $i++)
        {
            if ($i == $total_results) { break;}
            $result->data_seek($i);
            $row = $result->fetch_row();
            echo "<p style='border: 1px groove'>" . " <div>Тема: $row[1]</div>" . " " . "Автор: " . $row[2] . "</p>";
            echo '<p style="border-bottom: 1px groove">' . $row[3] . '</p>';
            echo '<p>' . '<img id="images" src="'.$row[8].'" alt="">' . '</p>';
        }
    }
    else
    {
        echo "Нет результата";
    }
}
else
{
    echo "Error: " . $mysqli->error;
}
$input['subject'] = '';
$input['name'] = '';
$input['message'] = '';
$input['image'] = '';
include("view/v_index.php");
?>

<?
if(isset($_POST['button']))
{
    $input['subject'] = htmlentities($_POST['subject'], ENT_QUOTES);
    $input['name'] = htmlentities($_POST['name'], ENT_QUOTES);
    $input['message'] = htmlentities($_POST['message'], ENT_QUOTES);

    //check correct fill in captcha

    if($_SESSION['captcha'] == $_POST['captcha'])
    {
        $input['subject'] = htmlentities($_POST['subject'], ENT_QUOTES);
        $input['name'] = htmlentities($_POST['name'], ENT_QUOTES);
        $input['message'] = htmlentities($_POST['message'], ENT_QUOTES);



        $whitespaces = " ";

        //clean up variable
        $_POST['subject'] = trim($_POST['subject']);
        $_POST['name'] = trim($_POST['name']);
        $_POST['message'] = trim($_POST['message']);
        //check to empty fields
        if(!empty($_POST['subject']) && !empty($_POST['name']) && !empty($_POST['message']))
        {
            if($_POST['subject']!= $whitespaces && $_POST['name']!= $whitespaces && $_POST['message']!= $whitespaces)
            {


             $result = $mysqli->prepare("INSERT book (subject, name, message) VALUES (?,?,?)");
        {
            $result->bind_param("sss", $input['subject'], $input['name'],  $input['message'] );
            $result->execute();
            $result->close();
            $input['subject'] = '';
            $input['name'] = '';
            $input['message'] = '';
            //to attach file

            if ($_FILES && $_FILES['filename']['error']== UPLOAD_ERR_OK)
            {

                $name = $Book->rus2translit($_FILES['filename']['name']);
                move_uploaded_file($_FILES['filename']['tmp_name'],  "./images/" . $Book->rus2translit($_FILES["filename"]["name"]));

                //echo $name;
               // echo "<br>";

                //create link on image
                $imgurl = "/images/".$name;
                //get last ID
                $max_id = $mysqli->query("SELECT max(id) from book");
                $row = $max_id->fetch_row();
                //to insert last id and URL on image
                $mysqli->query("INSERT sef (id, link) VALUES ('$row[0]', '$imgurl')");
                echo '<p style="font-weight: bold; color: green; font-size:13pt;  text-align: center;">Файл успешно загружен.</p>' ;
            }
        }

        unset($_POST['subject']);
        unset($_POST['name']);
        unset($_POST['message']);
    }

        }
    }
}
?>




<link rel="stylesheet" href="/css/bootstrap.css"/>
<link rel="stylesheet" href="/css/style.css"/>