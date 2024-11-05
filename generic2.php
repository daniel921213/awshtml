<!DOCTYPE HTML>
<html>
<head>
    <title>Employee Management - Edit Employee</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <style>
        .form-container {
            margin: 20px 0;
            padding: 20px;
            background-color: #333;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #fff;
        }
        .form-container input[type="text"] {
            background-color: #444;
            color: #fff;
            border: 1px solid #777;
            padding: 8px;
            margin: 5px 0;
            width: 90%;
            border-radius: 3px;
        }
        .form-container input[type="submit"] {
            background-color: #5a67d8;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 3px;
        }
        .form-container input[type="submit"]:hover {
            background-color: #4c51bf;
        }
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
        <a href="index.html" class="title">Employee Management</a>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="add_employee.php">Add Employee</a></li>
                <li><a href="view_employees.php" class="active">View Employees</a></li>
            </ul>
        </nav>
    </header>

    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Main -->
        <section id="main" class="wrapper">
            <div class="inner">
                <h1 class="major">Edit Employee</h1>
                
                <?php
                    include "../inc/dbinfo.inc"; 
                    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

                    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

                    $database = mysqli_select_db($connection, DB_DATABASE);

                    VerifyEmployeesTable($connection, DB_DATABASE);

                    $employee_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : null;
                    $employee_name = "";
                    $employee_position = "";
                    $employee_department = "";
                    $employee_contact = "";

                    if ($employee_id) {
                        $query = "SELECT * FROM EMPLOYEES WHERE ID = $employee_id";
                        $result = mysqli_query($connection, $query);
                        if ($row = mysqli_fetch_assoc($result)) {
                            $employee_name = $row['NAME'];
                            $employee_position = $row['POSITION'];
                            $employee_department = $row['DEPARTMENT'];
                            $employee_contact = $row['CONTACT'];
                        }
                    }

                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $employee_id) {
                        $employee_name = htmlentities($_POST['EMP_NAME']);
                        $employee_position = htmlentities($_POST['POSITION']);
                        $employee_department = htmlentities($_POST['DEPARTMENT']);
                        $employee_contact = htmlentities($_POST['CONTACT']);
                        
                        // Update employee data
                        UpdateEmployee($connection, $employee_id, $employee_name, $employee_position, $employee_department, $employee_contact);
                    }
                ?>

                <!-- Input form for editing an employee -->
                <div class="form-container">
                    <form action="" method="POST">
                        <table>
                            <tr>
                                <td><label for="EMP_NAME">Name</label></td>
                                <td><label for="POSITION">Position</label></td>
                                <td><label for="DEPARTMENT">Department</label></td>
                                <td><label for="CONTACT">Contact</label></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="EMP_NAME" id="EMP_NAME" value="<?php echo $employee_name; ?>" required /></td>
                                <td><input type="text" name="POSITION" id="POSITION" value="<?php echo $employee_position; ?>" required /></td>
                                <td><input type="text" name="DEPARTMENT" id="DEPARTMENT" value="<?php echo $employee_department; ?>" required /></td>
                                <td><input type="text" name="CONTACT" id="CONTACT" value="<?php echo $employee_contact; ?>" required /></td>
                                <td><input type="submit" value="Update Employee" /></td>
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
                        <th>Action</th>
                    </tr>

                    <?php
                        $result = mysqli_query($connection, "SELECT * FROM EMPLOYEES");

                        while($query_data = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>", $query_data['ID'], "</td>",
                                 "<td>", $query_data['NAME'], "</td>",
                                 "<td>", $query_data['POSITION'], "</td>",
                                 "<td>", $query_data['DEPARTMENT'], "</td>",
                                 "<td>", $query_data['CONTACT'], "</td>",
                                 "<td><a href='?edit_id=" . $query_data['ID'] . "'>Edit</a></td>";
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
function UpdateEmployee($connection, $id, $name, $position, $department, $contact) {
    $query = "UPDATE EMPLOYEES SET NAME='$name', POSITION='$position', DEPARTMENT='$department', CONTACT='$contact' WHERE ID=$id;";
    return mysqli_query($connection, $query);
}

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
