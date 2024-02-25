<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Prepare
    $stRemove = $pdo->prepare("delete from tblEmployee where userId = :id");

    //Bind Value
    $id = $_REQUEST["id"];
    $stRemove->bindValue(':id', $id);

    $stRemove->execute();
    header("Location: index.php");
    exit();
}



//2-Prepare Statement
$st = $pdo->prepare("select * from tblEmployee where userId = :id");

//3-Bind Value
$st->bindValue(':id', $_REQUEST["id"]);

//4-Execute
$st->execute();

//5-Get Data
$pro = $st->fetch(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Delete Form</title>
</head>

<body>
    <center>
        <h1>Delete Employee</h1>
        Employee Name: <?php echo $pro['employeeName'] ?> <br>
        Gender: <?php echo $pro['gender'] ?><br>
        Dob:<?php echo $pro['dob'] ?> <br>
        Address: <?php echo $pro['address'] ?><br>
        Phone Number: <?php echo $pro['phone'] ?><br>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $pro["userId"] ?>">
            <input type="submit" value="Comfirm Delete">
        </form>
    </center>
</body>

</html>