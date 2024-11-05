<!DOCTYPE HTML>
<html>
<head>
    <title>Employee Management - Add Employee</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
    <style>
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #2e2e2e;
            border-radius: 8px;
        }

        .form-container table {
            width: 100%;
        }

        .form-container input[type="text"], .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .success-message {
            color: #4caf50;
            font-weight: bold;
            margin-top: 15px;
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
                <li><a href="add_employee.php" class="active">Add Employee</a></li>
                <li><a href="view_employees.php">View Employees</a></li>
            </ul>
        </nav>
    </header>

    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Main -->
        <section id="main" class="wrapper">
            <div class="inner">
                <h1 class="major">Add New Employee</h1>
                
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
                                <td><label for="emp_name">Name</label></td>
                                <td><label for="position">Position</label></td>
                                <td><label for="department">Department</label></td>
                                <td><label for="contact">Contact</label></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="EMP_NAME" id="emp_name" maxlength="45" required /></td>
                                <td><input type="text" name="POSITION" id="position" maxlength="45" required /></td>
                                <td><input type="text" name="DEPARTMENT" id="department" maxlength="45" required /></td>
                                <td><input type="text" name="CONTACT" id="contact" maxlength="15" required /></td>
                            </tr>
                            <tr>
                                <td colspan="4"><input type="submit" value="Add Employee" /></td>
                            </tr>
                        </table>
                    </form>
                </div>

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
