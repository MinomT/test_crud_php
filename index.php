<?php
require("connection.php");
//PDO
$statement = $pdo->prepare("SELECT * FROM tblEmployee");
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <title>Document</title>
</head>
<style>
  .btn-primary {
    float: right;
  }

  .btn {
    margin: 5px 5px;
  }
</style>

<body>
  <a href="add.php"><button type="button" class="btn btn-primary " btn-danger>+ Add Product</button></a>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Employee Name</th>
        <th scope="col">Gender</th>
        <th scope="col">Date Of Birth</th>
        <th scope="col">Address</th>
        <th scope="col">Address</th>
        <th scope="col">Phone Number</th>
        <th scope="col">Employee Image</th>
      </tr>
    </thead>
    <?php foreach ($products as $key => $pro) { ?>
      <tbody>
        <tr>
          <th scope="row">
            <?php echo $key + 1 ?>
          </th>
          <td>
            <?php echo $pro['employeeName'] ?>
          </td>
          <td>
            <?php echo $pro['gender'] ?>
          </td>
          <td>
            <?php echo $pro['dob'] ?>
          </td>
          <td>
            <?php echo $pro['address'] ?>
          </td>
          <td>
            <?php echo $pro['address'] ?>
          </td>
          <td>
            <?php echo $pro['phone'] ?>
          </td>
          <td>
            <img style="width: 50px;height: 50px" src="<?php echo $pro['image'] ?>">
          </td>
          <td>
            <a href="delete.php?id=<?php echo $pro['userId'] ?>" type="button" class="btn btn-danger" data-toggle="button" aria-pressed="false" autocomplete="off">
              <i class="bi bi-trash"></i>
            </a>
            <a href="update.php?id=<?php echo $pro['userId'] ?>" type="button" class="btn btn-success" data-toggle="button" aria-pressed="false" autocomplete="off">
              <i class="bi bi-pencil"></i>
            </a>
          </td>
        </tr>
      </tbody>
    <?php } ?>
  </table>
</body>

</html>