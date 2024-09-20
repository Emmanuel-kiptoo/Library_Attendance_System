<?php
include("header.php");
include("db.php");

$flag = 0;
$userExists = false;

if (isset($_POST['submit'])) {
    // Check if the student already exists
    $sname = $_POST['sname'];
    $adm = $_POST['adm'];
    $gender = $_POST['gender']; // Add this line to get the gender value from the form

    $checkQuery = mysqli_query($con, "SELECT * FROM `attendances_system` WHERE `sname` = '$sname' AND `gender` = '$gender' AND `adm` = '$adm'");
    if (mysqli_num_rows($checkQuery) > 0) {
        $userExists = true;
    } else {
        // Insert the new student record
        $result = mysqli_query($con, "INSERT INTO `attendances_system` (`sname`, `gender`, `adm`, `school`, `Grade`, `age`) VALUES ('$_POST[sname]', '$_POST[gender]', '$_POST[adm]', '$_POST[school]', '$_POST[gclass]', '$_POST[age]')");
        
        if ($result) {
            $flag = 1;
        }
    }
}
?>
<style>
    body {
        background-color: #29AB87; /* Jungle Green */
        color: #2AAA8A; /* White text for better contrast */
    }
    .container {
        background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent white background for the content */
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 6px;
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .header h1 {
        margin: 0;
    }
    .input-pane {
        width: 100%;
    }
</style>
<div class="container mt-5-custom">
    <div class="panel panel-default">
        <?php if ($flag) { ?>
        <div class="alert alert-success text-center">
            <strong>Success!</strong> Attendance Data Successfully entered!
        </div>
        <?php } elseif ($userExists) { ?>
        <div class="alert alert-danger text-center">
            <strong>Error!</strong> User already exists!
        </div>
        <?php } ?>
        <div class="panel-heading text-center">
            <h2>
                <a class="btn btn-success" href="add.php">Add Student</a>
                <a class="btn btn-info" href="index.php">Back</a>
            </h2> 
        </div>
        <div class="panel-body">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <form action="add.php" method="post">
                        <div class="form-group">
                            <label for="sname">Student Name</label>
                            <input type="text" name="sname" id="sname" class="form-control input-pane" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="form-control input-pane" required>
                                <option value="Female">Female</option>    
                                <option value="Male">Male</option>                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="adm">Admission No</label>
                            <input type="text" name="adm" id="adm" class="form-control input-pane" required>
                        </div>
                        <div class="form-group">
                            <label for="school">School</label>
                            <select name="school" id="school" class="form-control input-pane" required>
                                <option value="mashimoni">Mashimoni school</option>
                                <option value="chemichemi">Chemichemi school</option>
                                <option value="fafu">Fafu school</option>
                                <option value="goodshepherd">Good Shepherd school</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gclass">Grade</label>
                            <select name="gclass" id="gclass" class="form-control input-pane" required>
                                <option value="grade-1">Grade PP1</option>
                                <option value="grade-2">Grade PP2</option>
                                <option value="grade-3">Grade One</option>
                                <option value="grade-4">Grade Two</option>
                                <option value="grade-5">Grade Three</option>
                                <option value="grade-6">Grade Four</option>
                                <option value="grade-7">Grade Five</option>
                                <option value="grade-8">Grade Six</option>
                                <option value="form-1">Form One</option>
                                <option value="form-2">Form Two</option>
                                <option value="form-3">Form Three</option>
                                <option value="form-4">Form Four</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="age">Student Age</label>
                            <input type="text" name="age" id="age" class="form-control input-pane" required>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div> 
    </div>
</div>
