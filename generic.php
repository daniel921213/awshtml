<!DOCTYPE HTML>
<html>
<head>
    <title>員工管理 - 新增員工</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
    <style>
    .form-container {
        margin: 20px 0;
        padding: 20px;
        background-color: #333; /* 更深的背景色 */
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        color: #fff; /* 白色字體顏色 */
    }
    .form-container input[type="text"] {
        background-color: #444; /* 深灰色輸入框背景 */
        color: #fff; /* 白色字體顏色 */
        border: 1px solid #777; /* 顯眼的灰色邊框 */
        padding: 8px;
        margin: 5px 0;
        width: 90%;
        border-radius: 3px;
    }
    .form-container input[type="submit"] {
        background-color: #5a67d8; /* 按鈕背景色 */
        color: #fff; /* 白色字體 */
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 3px;
    }
    .form-container input[type="submit"]:hover {
        background-color: #4c51bf; /* 深一點的按鈕背景色 */
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        color: #fff; /* 表格文字顏色 */
    }
    .data-table th, .data-table td {
        border: 1px solid #555;
        padding: 8px;
        text-align: left;
        background-color: #333; /* 表格背景色 */
    }
    .data-table th {
        background-color: #444; /* 表頭背景色 */
    }
</style>
</head>
<body class="is-preload">
    <!-- Header -->
    <header id="header">
        <a href="index.html" class="title">新增員工<</a>
        <nav>
            <ul>
			<li><a href="index.html">主頁</a></li>
                <li><a href="generic2.php">新增員工</a></li>
				<li><a href="generic3.php">修改員工</a></li>
                <li><a href="view_employees.php" class="active">所有員工</a></li>
            </ul>
        </nav>
    </header>

    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Main -->
        <section id="main" class="wrapper">
            <div class="inner">
                <h1 class="major">新增員工</h1>
                
                <?php
                    include "../inc/dbinfo.inc"; 
                    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

                    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

                    $database = mysqli_select_db($connection, DB_DATABASE);

                    VerifyEmployeesTable($connection, DB_DATABASE);

                    $employee_name = htmlentities($_POST['EMP_NAME']);
                    $employee_position = htmlentities($_POST['POSITION']);
                    $employee_department = htmlentities($_POST['DEPARTMENT']);
                    $employee_contact = htmlentities($_POST['CONTACT']);

                    $success_message = "";

                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($employee_name) && strlen($employee_position) && strlen($employee_department) && strlen($employee_contact)) {
                        if (AddEmployee($connection, $employee_name, $employee_position, $employee_department, $employee_contact)) {
                            $success_message = "<p class='success-message'>Employee added successfully!</p>";
                        }
                    }
                ?>

                <!-- Success message -->
                <?php if($success_message) echo $success_message; ?>

                <!-- Input form for adding a new employee -->
                <div class="form-container">
                    <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
                        <table>
                            <tr>
                                <td><label for="EMP_NAME">Name</label></td>
                                <td><label for="POSITION">Position</label></td>
                                <td><label for="DEPARTMENT">Department</label></td>
                                <td><label for="CONTACT">Contact</label></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="EMP_NAME" id="EMP_NAME" maxlength="45" size="30" required /></td>
                                <td><input type="text" name="POSITION" id="POSITION" maxlength="45" size="30" required /></td>
                                <td><input type="text" name="DEPARTMENT" id="DEPARTMENT" maxlength="45" size="30" required /></td>
                                <td><input type="text" name="CONTACT" id="CONTACT" maxlength="15" size="20" required /></td>
                                <td><input type="submit" value="Add Employee" /></td>
                            </tr>
                        </table>
                    </form>
                </div>

                <!-- Display table data -->
                <table class="data-table">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Contact</th>
                    </tr>

                    <?php
                        $result = mysqli_query($connection, "SELECT * FROM EMPLOYEES");

                        while($query_data = mysqli_fetch_row($result)) {
                            echo "<tr>";
                            echo "<td>", $query_data[0], "</td>",
                                 "<td>", $query_data[1], "</td>",
                                 "<td>", $query_data[2], "</td>",
                                 "<td>", $query_data[3], "</td>",
                                 "<td>", $query_data[4], "</td>";
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
function AddEmployee($connection, $name, $position, $department, $contact) {
    $n = mysqli_real_escape_string($connection, $name);
    $p = mysqli_real_escape_string($connection, $position);
    $d = mysqli_real_escape_string($connection, $department);
    $c = mysqli_real_escape_string($connection, $contact);

    $query = "INSERT INTO EMPLOYEES (NAME, POSITION, DEPARTMENT, CONTACT) VALUES ('$n', '$p', '$d', '$c');";

    return mysqli_query($connection, $query);
}

function VerifyEmployeesTable($connection, $dbName) {
    if(!TableExists("EMPLOYEES", $connection, $dbName)) {
        $query = "CREATE TABLE EMPLOYEES (
            ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            NAME VARCHAR(45),
            POSITION VARCHAR(45),
            DEPARTMENT VARCHAR(45),
            CONTACT VARCHAR(15)
        )";

        if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
    }
}

function TableExists($tableName, $connection, $dbName) {
    $t = mysqli_real_escape_string($connection, $tableName);
    $d = mysqli_real_escape_string($connection, $dbName);

    $checktable = mysqli_query($connection,
        "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

    return mysqli_num_rows($checktable) > 0;
}
?>
