<?php
//1-Create Connection
require_once("connection.php");
$error = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_REQUEST['name'];
    $gender = $_REQUEST['gender'];
    $dob = $_REQUEST['dob'];

    if (!$name) {
        $error[] = "Name is required";
    }
    if (!$gender) {
        $error[] = "Gender is required";
    }
    if (!$dob) {
        $error[] = "Dob is required";
    }


    if (empty($error)) {
        $image = $_FILES['image'] ?? null;
        $imagePath = "";
        function randomString($n)
        {
            $character = "123456789abcdefghigklmnopqrstuvwxyz";
            $str = "";
            for ($i = 0; $i <= $n; $i++) {
                $index = rand(0, strlen($character) - 1);
                $str .= $character[$index];
            }
            return $str;
        }
        if ($image["name"]) {
            $imagePath = "images/" . randomString(8) . $image['name'];
            move_uploaded_file($image['tmp_name'], $imagePath);
        } else {
            $imagePath = $_REQUEST["oldimages"];
        }
        //Prepare
        $upSt = $pdo->prepare("update tblEmployee set employeeName=:name,gender=:gender,dob=:dob, address=:address, phone=:phone, image=:image where userId=:id");

        //Bind Value
        $upSt->bindValue(':id', $_REQUEST['id']);
        $upSt->bindValue(':name', $name);
        $upSt->bindValue(':gender', $gender);
        $upSt->bindValue(':dob', $dob);
        $upSt->bindvalue(':address', $_REQUEST['address']);
        $upSt->bindValue(':phone', $_REQUEST['phone']);
        $upSt->bindValue(':image', $imagePath);

        //Execute
        $upSt->execute();
        header("Location: index.php");
        return false;
    }
}






$id = $_REQUEST['id'];


//2-Prepare Statement
$st = $pdo->prepare("select * from tblEmployee where userId = :id");

//3-Bind Value
$st->bindValue(':id', $id);

//4-Execute
$st->execute();

//5-Get Data
$products = $st->fetch(PDO::FETCH_ASSOC);



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Update Product</title>
    <style>
        .btn-success {
            float: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Product</h1>
        <?php if (!empty($errors)) { ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?php echo $error ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php } ?>
        <form action="update.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3 row">
                <label for="name" class="form-label">Employee Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $products['employeeName']; ?>">
            </div>
            <div class="mb-3 row">
                <label for="gender" class="form-label">Gender:</label>
                <input type="text" class="form-control" id="gender" name="gender" value="<?php echo $products['gender']; ?>">
            </div>
            <div class="mb-3 row">
                <label for="dob" class="form-label">Gender:</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $products['dob']; ?>">
            </div>
            <div class="mb-3 row">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3"><?php echo $products['address']; ?></textarea>
            </div>
            <div class="mb-3 row">
                <label for="phone" class="form-label">Phone Number:</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $products['phone']; ?>">
            </div>
            <div class="mb-3 row">
                <img style=" width: 250px;height: 200px" src="<?php echo $products['image'] ?>">
            </div>
            <div class="mb-3 row">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <input type="hidden" class="form-control" id="oldimages" name="oldimages" value="<?php echo $products['image'] ?>">
            </div>
            <div class=" mb-3 row">
                <label for="id" class="form-label">Employee Id</label>
                <input readonly type="text" class="form-control" id="id" name="id" value="<?php echo $id = $products['userId']; ?>"></textarea>
            </div>
            <button type="submit" class="btn btn-success ">Save</button>
        </form>
    </div>

</body>

</html>