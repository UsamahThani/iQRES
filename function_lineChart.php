
<?php
function DisplayLineChart() {
    global $connect;

    // Get the current month
    $currentMonth = date('n');

    // Calculate the start month for fetching data (6 months ago)
    $startMonth = ($currentMonth - 6 + 12) % 12 + 1;

    // Fetch data from the database for new equipment
    $query = "SELECT MONTH(equipRegisterDate) AS month, COUNT(*) AS newCount
              FROM equipment
              WHERE equipRegisterDate >= DATE_FORMAT(NOW() - INTERVAL 6 MONTH, '%Y-%m-01')
              GROUP BY MONTH(equipRegisterDate)";
    $result = mysqli_query($connect, $query);

    $newEquipmentData = array_fill($startMonth, 6, 0); // Initialize array for new equipment counts

    while ($row = mysqli_fetch_assoc($result)) {
        $month = $row['month'];
        $newCount = $row['newCount'];
        $newEquipmentData[$month] = $newCount;
    }

    // Fetch data for broken equipment
    $query = "SELECT MONTH(brokenDate) AS month, COUNT(*) AS brokenCount
              FROM brokenequipment
              WHERE brokenDate >= DATE_FORMAT(NOW() - INTERVAL 6 MONTH, '%Y-%m-01')
              GROUP BY MONTH(brokenDate)";
    $result = mysqli_query($connect, $query);

    $brokenEquipmentData = array_fill($startMonth, 6, 0); // Initialize array for broken equipment counts

    while ($row = mysqli_fetch_assoc($result)) {
        $month = $row['month'];
        $brokenCount = $row['brokenCount'];
        $brokenEquipmentData[$month] = $brokenCount;
    }

    // Combine data into equipData array
    $equipData = [];
    for ($month = $startMonth; $month <= $startMonth + 5; $month++) {
        $equipData[] = [
            'month' => date('M', strtotime("2023-$month-01")), // Format month as 'M'
            'equipment' => [
                'new' => $newEquipmentData[$month],
                'broken' => $brokenEquipmentData[$month],
            ],
        ];
    }

    // JavaScript setup code
    echo "
    <script>
        const equipData = " . json_encode($equipData) . ";

        // setup 
        const data = {
        datasets: [{
            label: 'New',
            data: equipData,
            backgroundColor: 'rgba(81, 231, 93, 0.2)',
            borderColor: 'rgba(81, 231, 93, 1)',
            parsing: {
            yAxisKey: 'equipment.new'
            }
        },
        {
            label: 'Broken',
            data: equipData,
            backgroundColor: 'rgba(255, 26, 104, 0.2)',
            borderColor: 'rgba(255, 26, 104, 1)',
            parsing: {
            yAxisKey: 'equipment.broken'
            }
        }]
        };

        // config 
        const config = {
        type: 'line',
        data,
        options: {
            tension: 0.4,
            parsing: {
            xAxisKey: 'month',
            },
            scales: {
            y: {
                beginAtZero: true
            }
            }
        }
        };

        // render init block
        const myChart = new Chart(
        document.getElementById('myChart'),
        config
        );

        // Instantly assign Chart.js version
        const chartVersion = document.getElementById('chartVersion');
        chartVersion.innerText = Chart.version;
    </script>";
}
?>
