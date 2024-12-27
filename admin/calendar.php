<?php
// session_start();

include('../includes/top-bar.php');
// Check if the user is logged in
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header("Location: ../login.php"); // Redirect to login if not logged in as admin
//     exit();
// }
require '../includes/db.php';

function build_calendar($month, $year) {
    global $pdo; // Use the database connection from includes/db.php

    $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);

    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];

    $appointments = [];
    $startDate = "$year-$month-01 00:00:00";
    $endDate = "$year-$month-$numberDays 23:59:59";

    $query = "SELECT first_name, last_name, contact_number, appointment_date 
              FROM appointments 
              WHERE status = 'accepted' 
              AND appointment_date BETWEEN :startDate AND :endDate";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':startDate', $startDate);
    $stmt->bindValue(':endDate', $endDate);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $date = date('Y-m-d', strtotime($row['appointment_date']));
        if (!isset($appointments[$date])) {
            $appointments[$date] = [];
        }
        $appointments[$date][] = $row;
    }

    $calendar = "<div class='container mx-auto px-4'>"; 
    $calendar .= "<h2 class='text-xl font-bold text-center mb-4'>$monthName $year</h2>";
    $calendar .= "<div class='grid grid-cols-7 gap-2 text-center text-xs sm:text-sm'>";

    foreach ($daysOfWeek as $day) {
        $calendar .= "<div class='font-semibold text-gray-600'>$day</div>";
    }

    if ($dayOfWeek > 0) {
        $calendar .= str_repeat('<div></div>', $dayOfWeek);
    }

    $currentDay = 1;

    while ($currentDay <= $numberDays) {
        $todayClass = ($currentDay == date('j') && $month == date('n') && $year == date('Y')) 
            ? 'bg-blue-500 text-white font-bold' 
            : 'bg-white';

        $dateKey = sprintf('%04d-%02d-%02d', $year, $month, $currentDay);
        $tooltipContent = "";

        if (isset($appointments[$dateKey])) {
            $todayClass = 'bg-green-100';
            foreach ($appointments[$dateKey] as $appt) {
                $tooltipContent .= htmlspecialchars($appt['first_name'] . " " . $appt['last_name']) . " - " . htmlspecialchars($appt['contact_number']) . "<br>" ;
            }
        }

        $calendar .= "<div class='relative group p-2 border rounded $todayClass' title='" . strip_tags($tooltipContent) . "'>
                        <div class='font-bold'>$currentDay</div>
                        <div class='absolute left-0 top-full hidden group-hover:block bg-gray-700 text-white text-xs p-2 rounded shadow-lg z-10'>
                            " . ($tooltipContent ?: "No appointments") . "
                        </div>
                      </div>";

        $currentDay++;
        $dayOfWeek++;

        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
        }
    }

    if ($dayOfWeek != 0) {
        $remainingDays = 7 - $dayOfWeek;
        $calendar .= str_repeat('<div></div>', $remainingDays);
    }

    $calendar .= "</div></div>";

    return $calendar;
}

$month = date('m');
$year = date('Y');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $month = $_POST['month'] ?? $month;
    $year = $_POST['year'] ?? $year;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="outer-container bg-gray-200 p-6 m-20 rounded-lg shadow-lg">
        <form method="POST" class="mb-4 text-center">
            <select name="month" class="p-2 border rounded">
                <?php
                for ($m = 1; $m <= 12; $m++) {
                    $selected = ($m == $month) ? 'selected' : '';
                    echo "<option value='$m' $selected>" . date('F', mktime(0, 0, 0, $m, 1)) . "</option>";
                }
                ?>
            </select>
            <select name="year" class="p-2 border rounded">
                <?php
                $currentYear = date('Y');
                for ($y = $currentYear - 5; $y <= $currentYear + 5; $y++) {
                    $selected = ($y == $year) ? 'selected' : '';
                    echo "<option value='$y' $selected>$y</option>";
                }
                ?>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">View</button>
        </form>
        <?php echo build_calendar($month, $year); ?>
    </div>
</body>

</html>
