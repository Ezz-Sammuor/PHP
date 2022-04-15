<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PHP";


// إنشاء اتصال مع سيلفر
$connection = new mysqli($servername, $username, $password ,$dbname);

// تفقد الإتصال مع سيلفر
// if ($connection->connect_error) {
//     die("Connection failed: " . $connection->connect_error);
// }
// echo "Connected successfully"."<br>";

// انشاء قاعدة البيانات
// $sql = "CREATE DATABASE php";
// if ($connection->query($sql) === TRUE) {
//   echo "Database created successfully"."<br>";
// } else {
//   echo "Error creating database: " . $connection->error ."<br>";
// }

// انشاء جدول في قاعدة البيانات
// $sql = "CREATE TABLE php_assignment	(
//         name VARCHAR(50)  NOT NULL,
//         email VARCHAR(50) PRIMARY KEY,
//         address VARCHAR(50) NOT NULL,
//         age VARCHAR(2) NOT NULL,
//         gender VARCHAR(10) NOT NULL
// )";
//     if ($connection->query($sql) === TRUE) {
//           echo "Table MyGuests created successfully";
//         } else {
//               echo "Error creating table: " . $connection->error . "<br>";
//     }
//     $connection->close();

// اضافة على الجدول
$sql =$connection->prepare("INSERT INTO php_assignment (name,email,address,age,gender) VALUES (?,?,?,?,?)");

$sql->bind_param("sssis",$name,$email,$address,$age,$gender);

$address = $_POST['address'];
$gender = $_POST['gender'];

// جمل الفحص المدخلات
$nameErr = $ageErr = $emailErr= "";

$error1 =array();
$error2 =array();
$error3 =array();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST['name'])) {
        $nameErr = "Name is required *"."<br>";
    }else {
        if (isset($_POST['submit'])){
            $name = $_POST['name'];
           if (strlen($name)<6 || strlen($name)>15) {
               array_push($error1 ,"The characters entered must be greater than 6 and less than 15"."<br>");
            }
           if (!preg_match('/[a-z_A-Z]/',$name)){
               array_push($error1 ,"The entry must contain lowercase letters"."<br>");
            }
           if (preg_match('/\d/',$name)) {
               array_push($error1, "The entry must not contain numbers"."<br>");
            }
        }
    }
    if (empty($_POST['age'])) {
        $ageErr = "age is required *"."<br>";
    }else {
        if (isset($_POST['submit'])){
            $age = $_POST['age'];
            if ($age<10 || $age>30) {
                array_push($error2 ,"It should contain numbers from 10 to 30"."<br>");
           }
        }
    }
    if (empty($_POST['email'])) {
        $emailErr = "Email is required *"."<br>";
    }else {
        if (isset($_POST['submit'])){
            $email = $_POST['email'];
            if (preg_match('/\s/',$email)) {
                array_push($error3, "The entry must not contain a space"."<br>");
            }
            if (!preg_match('/[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]{2}/',$email)) {
                array_push($error3, "Enter the correct email"."<br>");
            }
        }
    }
}


// الحذف من الجدول
// $sql = "DELETE FROM php_assignment";
// if ($connection->query($sql) === TRUE) {
//    echo "Record deleted successfully";
//} else {
    //    echo "Error deleting record: " . $connection->error;
//}
?>

<html>
   <body>
        <h2>Aizz Sammuor</h2>
        <h3>120201663</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            Name : <input type="text" name="name"> <br>
            <?php if ($error1){
                foreach ($error1 as $error){
                    $nameErr = $error . "<br>";
                    echo $nameErr;
                    }
                }else {
                    echo  $nameErr ."<br>";
                }?>
            Email : <input type="text" name="email"> <br>
            <?php 
            if ($error3){
                foreach ($error3 as $error){
                    $emailErr = $error . "<br>";
                    echo $emailErr;
                }
            }else {
                echo $emailErr."<br>";
            }?>
            Age : <input type="text" name="age"> <br>
            <?php 
            if ($error2){
                foreach ($error2 as $error){
                    $ageErr = $error . "<br>";
                    echo $ageErr;
                }
            }else {
                echo $ageErr."<br>";
            }?>
            Address : <input type="text" name="address"> <br><br>
            Gender :<input type="radio" name="gender" value="male" checked >Male
                    <input type="radio" name="gender" value="female">Female <br><br>
            <input type="submit" name="submit" class="submit">
        </form>
        <style>
            *{
                font-family:sans-serif;
            }
            
        </style>
    </body>
</html>

<?php
if (empty ($error1) && empty ($error2) && empty ($error3)){ 
    if ($sql->execute() === TRUE) { 
        echo "You are welcome : ". $name ." / Your email is : ".$email." / Residential area : ".$address." / Your age : ".$age." / Your gender : ".$gender ."<br>";
    }
}
?>
