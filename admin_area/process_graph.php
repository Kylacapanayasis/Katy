<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
    // Include database connection
    include("includes/db.php");

    // Fetch Yearly Sales Data from customer_orders
    $get_yearly_sales = "SELECT YEAR(order_date) AS year, SUM(due_amount) AS total_sales 
                         FROM customer_orders 
                         WHERE order_status = 'Completed'
                         GROUP BY YEAR(order_date)";
    $run_yearly_sales = mysqli_query($con, $get_yearly_sales);

    $yearlySales = [];
    while ($row_yearly = mysqli_fetch_array($run_yearly_sales)) {
        $yearlySales[] = [
            "label" => $row_yearly['year'],
            "y" => (float)$row_yearly['total_sales']
        ];
    }

    // Fetch Monthly Sales Data
    $get_monthly_sales = "SELECT MONTH(order_date) AS month, SUM(due_amount) AS total_sales 
                          FROM customer_orders 
                          WHERE YEAR(order_date) = YEAR(CURDATE()) 
                          AND order_status = 'Completed'
                          GROUP BY MONTH(order_date)";
    $run_monthly_sales = mysqli_query($con, $get_monthly_sales);

    $monthlySales = [];
    while ($row_monthly = mysqli_fetch_array($run_monthly_sales)) {
        $monthlySales[] = [
            "label" => date("F", mktime(0, 0, 0, $row_monthly['month'], 10)), // Converts month number to name
            "y" => (float)$row_monthly['total_sales']
        ];
    }

    // Fetch Weekly Sales Data
    $get_weekly_sales = "SELECT 
                            MONTH(order_date) AS month, 
                            WEEK(order_date, 1) AS week_number, 
                            MAX(order_date) AS end_date, 
                            SUM(due_amount) AS total_sales 
                         FROM customer_orders 
                         WHERE order_status = 'Completed'
                         GROUP BY month, week_number 
                         ORDER BY month, week_number";
    $run_weekly_sales = mysqli_query($con, $get_weekly_sales);

    $weeklySales = [];
    while ($row_weekly = mysqli_fetch_array($run_weekly_sales)) {
        // Get the last date of the week
        $week_end_date = date('M j', strtotime($row_weekly['end_date'])); // Format: Sept 7
        $weeklySales[] = [
            "label" => "Week " . $row_weekly['week_number'] . " of " . date("F", mktime(0, 0, 0, $row_weekly['month'], 10)) . " (" . $week_end_date . ")",
            "y" => (float)$row_weekly['total_sales']
        ];
    }

    // Fetch Daily Sales Data
    $get_daily_sales = "SELECT WEEKDAY(order_date) + 1 AS day_of_week, SUM(due_amount) AS total_sales 
                        FROM customer_orders 
                        WHERE MONTH(order_date) = MONTH(CURDATE()) 
                        AND YEAR(order_date) = YEAR(CURDATE()) 
                        AND order_status = 'Completed'
                        GROUP BY WEEKDAY(order_date)";
    $run_daily_sales = mysqli_query($con, $get_daily_sales);

    $dailySales = [];
    while ($row_daily = mysqli_fetch_array($run_daily_sales)) {
        $dailySales[] = [
            "label" => date('l', strtotime("Sunday +{$row_daily['day_of_week']} days")), // Get day name
            "y" => (float)$row_daily['total_sales']
        ];
    }

    // Fetch customer_orders details
    $get_orders = "SELECT order_id, coffee, size, qty, due_amount FROM customer_orders WHERE order_status = 'Completed'";
    $run_orders = mysqli_query($con, $get_orders);

    $orders = [];
    while ($row_order = mysqli_fetch_array($run_orders)) {
        $orders[] = [
            "order_id" => $row_order['order_id'],
            "coffee" => $row_order['coffee'],
            "size" => $row_order['size'],
            "qty" => $row_order['qty'],
            "due_amount" => $row_order['due_amount']
        ];
    }
?>

<div class="row"><!-- 2 row Starts -->

    <div class="col-lg-12"><!-- col-lg-12 Starts -->

        <div class="panel panel-default"><!-- panel panel-default Starts -->

            <div class="panel-heading"><!-- panel-heading Starts -->

                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> View Sales Reports
                </h3>

            </div><!-- panel-heading Ends -->

            <div class="panel-body"><!-- panel-body Starts -->

                <div class="print-button-container">
                    <button onclick="printPage()" class="btn btn-primary">Print</button>
                    <button id="toggleGraph" class="btn btn-secondary" onclick="toggleGraph()">Toggle Table/Graph</button>
                </div>

                <!-- Top Row: Daily and Weekly Charts -->
                <div class="row" id="salesData">
                    <div class="col-md-6">
                        <div class="card mt-3 border"><!-- Daily Sales Card -->
                            <div class="card-header">
                                <h5>Daily Total Sales (PHP)</h5>
                            </div>
                            <div class="card-body">
                                <div id="dailyChartContainer" class="chart-container" style="height: 200px; width: 100%;"></div>
                                <table class="table table-striped" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th>Day</th>
                                            <th>Total Sales (PHP)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($dailySales as $day): ?>
                                            <tr>
                                                <td><?= $day['label']; ?></td>
                                                <td>₱<?= number_format($day['y'], 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mt-3 border"><!-- Weekly Sales Card -->
                            <div class="card-header">
                                <h5>Weekly Total Sales (PHP)</h5>
                            </div>
                            <div class="card-body">
                                <div id="weeklyChartContainer" class="chart-container" style="height: 200px; width: 100%;"></div>
                                <table class="table table-striped" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th>Week</th>
                                            <th>Total Sales (PHP)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($weeklySales as $week): ?>
                                            <tr>
                                                <td><?= $week['label']; ?></td>
                                                <td>₱<?= number_format($week['y'], 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Row: Monthly and Yearly Charts -->
                <div class="row" id="salesData">
                    <div class="col-md-6">
                        <div class="card mt-3 border"><!-- Monthly Sales Card -->
                            <div class="card-header">
                                <h5>Monthly Total Sales (PHP)</h5>
                            </div>
                            <div class="card-body">
                                <div id="monthlyChartContainer" class="chart-container" style="height: 200px; width: 100%;"></div>
                                <table class="table table-striped" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Total Sales (PHP)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($monthlySales as $month): ?>
                                            <tr>
                                                <td><?= $month['label']; ?></td>
                                                <td>₱<?= number_format($month['y'], 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mt-3 border"><!-- Yearly Sales Card -->
                            <div class="card-header">
                                <h5>Yearly Total Sales (PHP)</h5>
                            </div>
                            <div class="card-body">
                                <div id="yearlyChartContainer" class="chart-container" style="height: 200px; width: 100%;"></div>
                                <table class="table table-striped" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th>Year</th>
                                            <th>Total Sales (PHP)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($yearlySales as $year): ?>
                                            <tr>
                                                <td><?= $year['label']; ?></td>
                                                <td>₱<?= number_format($year['y'], 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- panel-body Ends -->

        </div><!-- panel panel-default Ends -->

    </div><!-- col-lg-12 Ends -->

</div><!-- 2 row Ends -->

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
    // JavaScript to generate charts using CanvasJS
    window.onload = function() {
        var dailyChart = new CanvasJS.Chart("dailyChartContainer", {
            title: { text: "Daily Total Sales (PHP)" },
            data: [{ type: "column", dataPoints: <?= json_encode($dailySales); ?> }]
        });
        dailyChart.render();

        var weeklyChart = new CanvasJS.Chart("weeklyChartContainer", {
            title: { text: "Weekly Total Sales (PHP)" },
            data: [{ type: "column", dataPoints: <?= json_encode($weeklySales); ?> }]
        });
        weeklyChart.render();

        var monthlyChart = new CanvasJS.Chart("monthlyChartContainer", {
            title: { text: "Monthly Total Sales (PHP)" },
            data: [{ type: "column", dataPoints: <?= json_encode($monthlySales); ?> }]
        });
        monthlyChart.render();

        var yearlyChart = new CanvasJS.Chart("yearlyChartContainer", {
            title: { text: "Yearly Total Sales (PHP)" },
            data: [{ type: "column", dataPoints: <?= json_encode($yearlySales); ?> }]
        });
        yearlyChart.render();
    };

    // Function to toggle between showing/hiding tables and graphs
    function toggleGraph() {
        var tables = document.querySelectorAll("table");
        var charts = document.querySelectorAll(".chart-container");

        tables.forEach(function(table) {
            table.style.display = table.style.display === "none" ? "table" : "none";
        });

        charts.forEach(function(chart) {
            chart.style.display = chart.style.display === "none" ? "block" : "none";
        });
    }

    // Print function
    function printPage() {
        window.print();
    }
</script>

<?php } ?>
