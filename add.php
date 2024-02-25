<?php
$error = [];
$name = "";
$gender = "";
$dob = "";
$address = "";
$phone = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_REQUEST['name'];
    $gender = $_REQUEST['gender'];
    $dob = $_REQUEST['dob'];
    $address = $_REQUEST['address'];
    $phone = $_REQUEST['phone'];
    $errors = [];
    if (!$name) {
        $errors[] = "Name is Required";
    }

    if (!$gender) {
        $errors[] = "Gender is Required";
    }

    if (!$dob) {
        $errors[] = "Dob is Required";
    }

    if (!$address) {
        $error[] = "Address is Required";
    }

    if (!$phone) {
        $error[] = "Phone is Required";
    }
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
    if (empty($errors)) {
        $image = $_FILES['image'] ?? null;
        $imagePath = "";
        if ($image) {
            $imagePath = "images/" . randomString(8) . $image['name'];
            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        //1 ==Create Connection
        require("connection.php");

        //2 ==Prepare statement
        $name = $_REQUEST["name"];
        $gender = $_REQUEST["gender"];
        $dob = $_REQUEST["dob"];
        $address = $_REQUEST["address"];
        $phone = $_REQUEST["phone"];

        $statement = $pdo->prepare("Insert Into tblEmployee(employeeName, gender, dob, address,phone,image) VALUES(:name,:gender,:dob, :address, :phone, :image)");

        //3== Bind Value
        $statement->bindValue(':name', $name);
        $statement->bindValue(':gender', $gender);
        $statement->bindValue(':dob', $dob);
        $statement->bindValue(':address', $address);
        $statement->bindValue(':phone', $phone);
        $statement->bindValue(':image', $imagePath);
        $statement->execute();
        //3 ==Back To Index.php
        header("Location: index.php");
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Add Product</title>
    <style>
        .btn-success {
            float: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add Product</h1>
        <?php if (!empty($errors)) { ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?php echo $error ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php } ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3 row">
                <label for="name" class="form-label">Employee Name:</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class=" mb-3 row">
                <label for="gender" class="form-label">Gender:</label>
                <input type="text" class="form-control" id="gender" name="gender">
            </div>
            <div class="mb-3 row">
                <label for="dob" class="form-label">Date of birth:</label>
                <input type="date" class="form-control" id="dob" name="dob">
            </div>
            <div class="mb-3 row">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
            </div>
            <div class="mb-3 row">
                <label for="phone" class="form-label">Phone Number:</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="mb-3 row">
                <label for="id" class="form-label">Employee Id</label>
                <input readonly type="text" class="form-control" id="id" name="id">
            </div>
            <div class="mb-3 row">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-success ">Save</button>
        </form>
    </div>

</body>

</html>