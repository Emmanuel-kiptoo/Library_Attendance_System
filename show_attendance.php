<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Records</title>
    <!-- Include CSS and other meta tags if needed -->
</head>
<body>
<?php

include("db.php");
include("header.php");

?>
<div class="panel panel-default">
    <div class="panel-heading">
        
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
                if (isset($_POST['date'])) {
                    $date = mysqli_real_escape_string($con, $_POST['date']);
                    $result = mysqli_query($con, "SELECT * FROM attendance_records WHERE date='$date'");

                    if (!$result) {
                        echo "Error: " . mysqli_error($con);
                        exit;
                    }

                    $serialnumber = 0;
                    $counter = 0;

                    while ($row = mysqli_fetch_array($result)) {
                        $serialnumber++;
                        $gender = isset($row['gender']) ? $row['gender'] : '';
                        if ($gender !== 'male' && $gender !== 'female') {
                            $gender = 'N/A';
                        }
                ?>

                <tr>
                    <td> <?php echo $serialnumber; ?> </td>
                    <td> <?php echo htmlspecialchars($row["sname"] ?? 'N/A'); ?> </td>
                    <td> <?php echo htmlspecialchars($gender); ?> </td>
                    <td> <?php echo htmlspecialchars($row["adm"] ?? 'N/A'); ?> </td>
                    <td> <?php echo htmlspecialchars($row["school"] ?? 'N/A'); ?> </td>
                    <td> 
                        <input type="radio" name="attendance_status[<?php echo $counter; ?>]" 
                            value="present" <?php if(isset($row['attendance_status']) && $row['attendance_status']=="present") echo "checked"; ?> required> Present
                        <input type="radio" name="attendance_status[<?php echo $counter; ?>]" 
                            value="absent" <?php if(isset($row['attendance_status']) && $row['attendance_status']=="absent") echo "checked"; ?> required> Absent
                    </td>
                    <td>
                        <input type="text" name="comments[<?php echo $counter; ?>]" value="<?php echo htmlspecialchars($row['comments'] ?? ''); ?>" class="form-control">
                    </td>
                </tr>

                <?php
                        $counter++;
                    }
                } else {
                    echo "<tr><td colspan='7'>Please select a date to view attendance records.</td></tr>";
                }
                ?>
            </table>

            <h2>
                <a class="btn btn-primary pull-right" href="index.php">Back</a>
            </h2>
        </form>
    </div>
</div>
</body>
</html>
