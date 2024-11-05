<!DOCTYPE HTML>
<html>
<head>
    <title>員工管理 - 員工清單</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <style>
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: #fff;
        }
        .data-table th, .data-table td {
            border: 1px solid #555;
            padding: 8px;
            text-align: left;
            background-color: #333;
        }
        .data-table th {
            background-color: #444;
        }
    </style>
</head>
<body class="is-preload">
    <!-- Header -->
    <header id="header">
        <a href="index.html" class="title">員工管理
		</a>
        <nav>
            <ul>
				<li><a href="index.html">主頁</a></li>
				<li><a href="generic.php">新增員工</a></li>
                <li><a href="generic2.php">修改員工</a></li>
				<li><a href="generic3.php">刪除員工</a></li>
                <li><a href="generic4.php" >所有員工</a></li>
            </ul>
        </nav>
    </header>

    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Main -->
        <section id="main" class="wrapper">
            <div class="inner">
                <h1 class="major">List of Employees</h1>
                
                <?php
                    include "../inc/dbinfo.inc"; 
                    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

                    if (mysqli_connect_errno()) {
                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    }

                    $database = mysqli_select_db($connection, DB_DATABASE);
                    VerifyEmployeesTable($connection, DB_DATABASE);
                ?>

                <!-- Display table data -->
                <table class="data-table">
                    <tr>
                        <th>ID</th>
                        <th>姓名</th>
                        <th>值位</th>
                        <th>部們</th>
                        <th>連絡電話</th>
                    </tr>

                    <?php
                        $result = mysqli_query($connection, "SELECT * FROM EMPLOYEES");

                        while($query_data = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>", $query_data['ID'], "</td>",
                                 "<td>", $query_data['NAME'], "</td>",
                                 "<td>", $query_data['POSITION'], "</td>",
                                 "<td>", $query_data['DEPARTMENT'], "</td>",
                                 "<td>", $query_data['CONTACT'], "</td>";
                            echo "</tr>";
                        }

                        mysqli_free_result($result);
                        mysqli_close($connection);
                    ?>
                </table>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer id="footer" class="wrapper alt">
        <div class="inner">
            <ul class="menu">
                <li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
            </ul>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>

<?php
function VerifyEmployeesTable($connection, $dbName) {
    $checktable = mysqli_query($connection, "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = 'EMPLOYEES' AND TABLE_SCHEMA = '$dbName'");
    if (mysqli_num_rows($checktable) == 0) {
        $query = "CREATE TABLE EMPLOYEES (
            ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            NAME VARCHAR(45),
            POSITION VARCHAR(45),
            DEPARTMENT VARCHAR(45),
            CONTACT VARCHAR(15)
        )";
        mysqli_query($connection, $query);
    }
}
?>
