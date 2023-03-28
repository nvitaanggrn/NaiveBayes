<?php
//untuk memanggil syntax php
$jawaban = "";
if (isset($_GET['pertanyaan'])) {
    require "bayes.php";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayes</title>
</head>

<body>
    </br>
    </br>
    <div style="background-color:pink; padding:80px"> 
        <form action="" method="get">
            <label for="pertanyaan">Tanyakan Sesuatu</label>
            <input type="text" name="pertanyaan" id="pertanyaan" style="width: 500px;">
        </form>
        <p>Jawaban : </p>
        <p><?= $jawaban ?></p>
    </div>
</body>

</html>