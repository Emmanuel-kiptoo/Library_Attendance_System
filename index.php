<?php
include("db.php");
include("header.php");

$flag = 0;
$update = 0;

if (isset($_POST['submit'])) {
    $date = date("Y-m-d");

    // Check if attendance has already been recorded for the current date
    $records = mysqli_query($con, "SELECT * FROM attendance_records WHERE date='$date'");
    $num = mysqli_num_rows($records);

    if ($num) {
        // Update existing records for the current date
        foreach ($_POST['attendance_status'] as $id => $attendance_status) {
            if (isset($_POST['sname'][$id], $_POST['adm'][$id], $_POST['school'][$id], $_POST['comments'][$id])) {
                $sname = mysqli_real_escape_string($con, $_POST['sname'][$id]);
                $adm = mysqli_real_escape_string($con, $_POST['adm'][$id]);
                $school = mysqli_real_escape_string($con, $_POST['school'][$id]);
                $comments = mysqli_real_escape_string($con, $_POST['comments'][$id]);

                $query = "UPDATE attendance_records SET sname=?, adm=?, school=?, attendance_status=?, comments=? WHERE adm=? AND date=?";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "sssssss", $sname, $adm, $school, $attendance_status, $comments, $adm, $date);
                $result = mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                if ($result) {
                    $update = 1;
                }
            }
        }
    } else {
        // Insert new records for the current date
        foreach ($_POST['attendance_status'] as $id => $attendance_status) {
            if (isset($_POST['sname'][$id], $_POST['adm'][$id], $_POST['school'][$id], $_POST['comments'][$id])) {
                $sname = mysqli_real_escape_string($con, $_POST['sname'][$id]);
                $adm = mysqli_real_escape_string($con, $_POST['adm'][$id]);
                $school = mysqli_real_escape_string($con, $_POST['school'][$id]);
                $comments = mysqli_real_escape_string($con, $_POST['comments'][$id]);

                $query = "INSERT INTO attendance_records (sname, adm, school, attendance_status, comments, date) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "ssssss", $sname, $adm, $school, $attendance_status, $comments, $date);
                $result = mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                if ($result) {
                    $flag = 1;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Records</title>
    <!-- Include CSS and other meta tags if needed -->
</head>
<body>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="button-group">
            <h2>
                <a class="btn btn-success" href="add.php">Add Students</a>
                <a class="btn btn-info pull-right" href="viewall.php">View All</a>
            </h2>
        </div>        
        <?php if ($flag) { ?>
            <div class="alert alert-success">
                Attendance Data Added Successfully
            </div>
        <?php } ?>
        <?php if ($update) { ?>
            <div class="alert alert-success">
                Students Attendance Updated Successfully
            </div>
        <?php } ?>
        <h6><div class="well text-center">Date: <?php echo date("Y-m-d"); ?></div></h6>
    </div>
    <div class="panel-body">
        <form action="index.php" method="post">
            <table class="table table-striped">
                <tr>
                    <th>#Serial Number</th>
                    <th>Student Name</th>
                    <th>Gender</th>
                    <th>Admission</th>
                    <th>School</th>
                    <th>Attendance Status</th>
                    <th>Comments</th>
                </tr>
                <?php 
                $result = mysqli_query($con, "SELECT * FROM attendances_system");
                $serialnumber = 0;
                $counter = 0;
                while ($row = mysqli_fetch_array($result)) {
                    $serialnumber++;
                ?>
                <tr>
                    <td><?php echo $serialnumber; ?></td>
                    <td><?php echo htmlspecialchars($row["sname"]); ?>
                        <input type="hidden" value="<?php echo htmlspecialchars($row["sname"]); ?>" name="sname[]"> 
                    </td>
                    <td><?php echo htmlspecialchars($row["gender"]); ?>
                        <input type="hidden" value="<?php echo htmlspecialchars($row["gender"]); ?>" name="gender[]"> 
                    </td>
                    <td><?php echo htmlspecialchars($row["adm"]); ?> 
                        <input type="hidden" value="<?php echo htmlspecialchars($row["adm"]); ?>" name="adm[]">
                    </td>
                    <td><?php echo htmlspecialchars($row["school"]); ?> 
                        <input type="hidden" value="<?php echo htmlspecialchars($row["school"]); ?>" name="school[]">
                    </td>
                    <td>
                        <input type="radio" name="attendance_status[<?php echo $counter; ?>]" value="present" 
                            <?php if (isset($_POST['attendance_status'][$counter]) && $_POST['attendance_status'][$counter] == "present") { echo "checked"; } ?> required> Present
                        <input type="radio" name="attendance_status[<?php echo $counter; ?>]" value="absent" 
                            <?php if (isset($_POST['attendance_status'][$counter]) && $_POST['attendance_status'][$counter] == "absent") { echo "checked"; } ?> required> Absent
                    </td>
                    <td>
                        <input type="text" name="comments[<?php echo $counter; ?>]" value="<?php echo isset($_POST['comments'][$counter]) ? htmlspecialchars($_POST['comments'][$counter]) : ''; ?>" class="form-control">
                    </td>
                </tr>
                <?php
                    $counter++;
                }
                ?>
            </table>
            <div class="button-group">
                <input type="submit" value="Submit" name="submit" class="btn btn-primary">
                <a href="report.php" class="btn btn-info">Report Summary</a>
            </div>
        </form>
    </div>
</div>

<style>
    .button-group {
        display: flex;
        justify-content: center; /* Align buttons to the left */
        align-items: center;
        gap: 10px; /* Optional: Add space between buttons */
        margin-top: 20px; /* Optional: Adjust as needed */
    }
</style>
</body>
</html>
