<?php

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {

    // Include database connection
    include("includes/db.php");

    // Fetch Yearly Sales Data from customer_orders
    $get_yearly_sales = "SELECT YEAR(order_date) AS year, SUM(due_amount) AS total_sales 
                         FROM customer_orders 
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
                          GROUP BY MONTH(order_date)";
    $run_monthly_sales = mysqli_query($con, $get_monthly_sales);

    $monthlySales = [];
    while ($row_monthly = mysqli_fetch_array($run_monthly_sales)) {
        $monthlySales[] = [
            "label" => date("F", mktime(0, 0, 0, $row_monthly['month'], 10)),
            "y" => (float)$row_monthly['total_sales']
        ];
    }

    // Fetch Weekly Sales Data
    $get_weekly_sales = "SELECT WEEKDAY(order_date) + 1 AS day_of_week, SUM(due_amount) AS total_sales 
                         FROM customer_orders 
                         WHERE YEARWEEK(order_date, 1) = YEARWEEK(CURDATE(), 1) 
                         GROUP BY WEEKDAY(order_date)";
    $run_weekly_sales = mysqli_query($con, $get_weekly_sales);

    $weeklySales = [];
    while ($row_weekly = mysqli_fetch_array($run_weekly_sales)) {
        $weeklySales[] = [
            "label" => $row_weekly['day_of_week'],
            "y" => (float)$row_weekly['total_sales']
        ];
    }

    // Fetch Daily Sales Data
    $get_daily_sales = "SELECT DAY(order_date) AS day, SUM(due_amount) AS total_sales 
                        FROM customer_orders 
                        WHERE MONTH(order_date) = MONTH(CURDATE()) 
                        AND YEAR(order_date) = YEAR(CURDATE()) 
                        GROUP BY DAY(order_date)";
    $run_daily_sales = mysqli_query($con, $get_daily_sales);

    $dailySales = [];
    while ($row_daily = mysqli_fetch_array($run_daily_sales)) {
        $dailySales[] = [
            "label" => $row_daily['day'],
            "y" => (float)$row_daily['total_sales']
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

                <!-- Sales Reports Charts Start -->
                <div class="print-button-container">
                    <button onclick="printPage()" class="btn btn-primary">Print</button>
                </div>

                <!-- Layout for 2x2 charts -->
                <div class="row">
                    <div class="col-md-6">
                        <div id="yearlyChartContainer" class="chart-container" style="height: 300px; width: 100%;"></div>
                    </div>
                    <div class="col-md-6">
                        <div id="monthlyChartContainer" class="chart-container" style="height: 300px; width: 100%;"></div>
                    </div>
                </div>

                <!-- Yearly Sales Table -->
                <div class="row">
                    <div class="col-md-6">
                        <h4>Yearly Sales Data</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Total Sales (PHP)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($yearlySales as $yearSale) { ?>
                                    <tr>
                                        <td><?php echo $yearSale['label']; ?></td>
                                        <td>₱<?php echo number_format($yearSale['y'], 2); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Monthly Sales Table -->
                <div class="row">
                    <div class="col-md-6">
                        <h4>Monthly Sales Data</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Total Sales (PHP)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($monthlySales as $monthSale) { ?>
                                    <tr>
                                        <td><?php echo $monthSale['label']; ?></td>
                                        <td>₱<?php echo number_format($monthSale['y'], 2); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div id="weeklyChartContainer" class="chart-container" style="height: 300px; width: 100%;"></div>
                    </div>
                    <div class="col-md-6">
                        <div id="dailyChartContainer" class="chart-container" style="height: 300px; width: 100%;"></div>
                    </div>
                </div>

                <!-- Weekly Sales Table -->
                <div class="row">
                    <div class="col-md-6">
                        <h4>Weekly Sales Data</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Day of Week</th>
                                    <th>Total Sales (PHP)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($weeklySales as $weekSale) { ?>
                                    <tr>
                                        <td>
                                            <?php
                                            $days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                                            echo $days[$weekSale['label'] - 1];
                                            ?>
                                        </td>
                                        <td>₱<?php echo number_format($weekSale['y'], 2); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Daily Sales Table -->
                <div class="row">
                    <div class="col-md-6">
                        <h4>Daily Sales Data</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Total Sales (PHP)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dailySales as $daySale) { ?>
                                    <tr>
                                        <td><?php echo $daySale['label']; ?></td>
                                        <td>₱<?php echo number_format($daySale['y'], 2); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

                <script>
                    window.onload = function () {

                        // Yearly Total Sales chart
                        var yearlyChart = new CanvasJS.Chart("yearlyChartContainer", {
                            animationEnabled: true,
                            theme: "light1",
                            title: { text: "Yearly Total Sales (PHP)" },
                            axisX: { title: "Year" },
                            axisY: {
                                title: "Sales (PHP)",
                                includeZero: true,
                                prefix: "₱"
                            },
                            data: [{
                                type: "column",
                                indexLabelFontColor: "#5A5757",
                                indexLabelPlacement: "outside",
                                dataPoints: <?php echo json_encode($yearlySales, JSON_NUMERIC_CHECK); ?>
                            }]
                        });
                        yearlyChart.render();

                        // Monthly Total Sales chart
                        var monthlyChart = new CanvasJS.Chart("monthlyChartContainer", {
                            animationEnabled: true,
                            theme: "light1",
                            title: { text: "Monthly Total Sales (PHP)" },
                            axisX: { title: "Month" },
                            axisY: {
                                title: "Sales (PHP)",
                                includeZero: true,
                                prefix: "₱"
                            },
                            data: [{
                                type: "column",
                                indexLabelFontColor: "#5A5757",
                                indexLabelPlacement: "outside",
                                dataPoints: <?php echo json_encode($monthlySales, JSON_NUMERIC_CHECK); ?>
                            }]
                        });
                        monthlyChart.render();

                        // Weekly Total Sales chart
                        var weeklyChart = new CanvasJS.Chart("weeklyChartContainer", {
                            animationEnabled: true,
                            theme: "light1",
                            title: { text: "Weekly Total Sales (PHP)" },
                            axisX: { title: "Day of Week" },
                            axisY: {
                                title: "Sales (PHP)",
                                includeZero: true,
                                prefix: "₱"
                            },
                            data: [{
                                type: "column",
                                indexLabelFontColor: "#5A5757",
                                indexLabelPlacement: "outside",
                                dataPoints: <?php echo json_encode($weeklySales, JSON_NUMERIC_CHECK); ?>
                            }]
                        });
                        weeklyChart.render();

                        // Daily Total Sales chart
                        var dailyChart = new CanvasJS.Chart("dailyChartContainer", {
                            animationEnabled: true,
                            theme: "light1",
                            title: { text: "Daily Total Sales (PHP)" },
                            axisX: { title: "Day" },
                            axisY: {
                                title: "Sales (PHP)",
                                includeZero: true,
                                prefix: "₱"
                            },
                            data: [{
                                type: "column",
                                indexLabelFontColor: "#5A5757",
                                indexLabelPlacement: "outside",
                                dataPoints: <?php echo json_encode($dailySales, JSON_NUMERIC_CHECK); ?>
                            }]
                        });
                        dailyChart.render();
                    }

                    function printPage() {
                        window.print();
                    }
                </script>

            </div><!-- panel-body Ends -->

        </div><!-- panel panel-default Ends -->

    </div><!-- col-lg-12 Ends -->

</div><!-- 2 row Ends -->

<?php } ?>
