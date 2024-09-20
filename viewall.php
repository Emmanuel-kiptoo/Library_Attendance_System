<?php


include("db.php");
include("header.php");

?>
 <style>
        body {
            background-color: #29AB87; /* Jungle Green */
            color: #fff; /* White text for better contrast */
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent white background for the content */
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 2px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            margin: 0;
        }
        
    </style>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="button-group">
            <h2>
                <a class="btn btn-success" href="add.php">Add Students</a>
                <a class="btn btn-info pull-right" href="index.php">Back</a>
            </h2>
        </div>
        
     

        <div class="panel-body">
            
                <table class="table table-striped">
                    <tr>
                    <th>Serial Number</th><th>Dates</th><th>Show Attendance</th>
                    </tr>

                    <?php 
                    $result = mysqli_query($con, "SELECT distinct date FROM attendance_records");
                    $serialnumber = 0;
                    while ($row = mysqli_fetch_array($result)) {
                        $serialnumber++;
                    ?>

                    <tr>
                        <td> <?php echo $serialnumber; ?> </td>
                        <td> <?php echo $row["date"]; ?>
                        </td>
                        <td>
                            <form action="show_attendance.php" method="POST">
                                <input type="hidden" value="<?php echo $row['date']  ?>" name="date" >
                                <input type="submit" value="Show Attendance" class="btn btn-primary"> 

                            </form> 
                            
                        </td>
                                              
                    </tr>

                    <?php
                    }
                    ?>
                </table>
                <div class="button-group">
                <input type="submit" value="Submit" name="submit" class="btn btn-primary">
           
                </div>
                
        </div>
    </div>
</div>
<style>
    .button-group {
        display: flex;
        justify-content: center; /* Align buttons to the left */
        align-items: center;
        gap: 10px; /* Optional: Add space between buttons */
        margin-top: 10px; /* Optional: Adjust as needed */
    }
</style>
