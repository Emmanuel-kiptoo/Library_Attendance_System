<?php
include("db.php");
include("header.php");

function getTotalStudents($con) {
    $result = mysqli_query($con, "SELECT COUNT(DISTINCT adm) AS total_students FROM attendance_records");
    $data = mysqli_fetch_assoc($result);
    return $data['total_students'];
}

function getAttendanceByGrade($con) {
    $query = "SELECT school, COUNT(*) AS count FROM attendance_records GROUP BY school";
    $result = mysqli_query($con, $query);
    $attendance_by_grade = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $attendance_by_grade[$row['school']] = $row['count'];
    }
    return $attendance_by_grade;
}

function getMonthlyAttendance($con) {
    $query = "SELECT DATE_FORMAT(date, '%Y-%m') AS month, COUNT(*) AS count FROM attendance_records GROUP BY month";
    $result = mysqli_query($con, $query);
    $monthly_attendance = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $monthly_attendance[$row['month']] = $row['count'];
    }
    return $monthly_attendance;
}

// Fetch data
$total_students = getTotalStudents($con);
$attendance_by_grade = getAttendanceByGrade($con);
$monthly_attendance = getMonthlyAttendance($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Summary</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
</head>
<body>
    <div class="container">
        <div class="header mt-4">
            <h1>Attendance Summary</h1>
            <a class="btn btn-info" href="index.php">Back</a>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Total Students: <?php echo $total_students; ?></h3>
            </div>
            <div class="col-md-6">
                <h3>Attendance by Grade</h3>
                <canvas id="gradeChart"></canvas>
            </div>
            <div class="col-md-6">
                <h3>Monthly Attendance</h3>
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Data for Attendance by Grade
        const gradeData = <?php echo json_encode($attendance_by_grade); ?>;
        const gradeLabels = Object.keys(gradeData);
        const gradeCounts = Object.values(gradeData);

        const ctx1 = document.getElementById('gradeChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: gradeLabels,
                datasets: [{
                    label: 'Attendance by Grade',
                    data: gradeCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Data for Monthly Attendance
        const monthlyData = <?php echo json_encode($monthly_attendance); ?>;
        const monthlyLabels = Object.keys(monthlyData);
        const monthlyCounts = Object.values(monthlyData);

        const ctx2 = document.getElementById('monthlyChart').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Monthly Attendance',
                    data: monthlyCounts,
                    fill: false,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
