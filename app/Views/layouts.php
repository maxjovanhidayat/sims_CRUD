<!-- app/Views/layout.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script><!-- Dropzone CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.css" rel="stylesheet">

    <!-- Dropzone JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>

    <style>
        /* Custom styles for the sidebar */
        #wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        /* Sidebar styles */
        #sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 250px;
            /* Full width when open */
            background-color: #343a40;
            color: white;
            transition: width 0.3s ease-in-out;
        }

        /* Collapsed sidebar */
        #sidebar.collapsed {
            width: 60px;
            /* Width of collapsed sidebar */
        }

        /* Sidebar content styles */
        #sidebar ul {
            padding-left: 0;
            list-style-type: none;
        }

        #sidebar ul li {
            padding: 10px 15px;
            display: flex;
            align-items: center;
        }

        #sidebar ul li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        #sidebar ul li i {
            font-size: 18px;
        }

        /* Hide the text when the sidebar is collapsed */
        #sidebar.collapsed ul li span {
            display: none;
        }

        /* Hide text and logos in header when collapsed */
        #sidebar.collapsed .sidebar-header .text-start,
        #sidebar.collapsed .sidebar-header .fa-bag-shopping {
            display: none;
        }

        /* Sidebar hover effect */
        #sidebar ul li:hover {
            background-color: #ff5b5b;
        }

        /* Active menu item styling */
        ul li.active a {
            background-color: #ff5b5b;
            /* Active background color */
            color: white;
            /* Active text color */
        }

        ul li.active {
            background-color: #ff5b5b;
            /* Active background color */
            color: white;
            /* Active text color */
        }

        /* Hover effect for all items */
        ul li:hover {
            background-color: #e34a4a;
            /* Hover background color */
        }

        /* Prevent the active menu from changing color on hover */
        ul li.active:hover {
            background-color: #ff5b5b;
            /* Keep the same color when hovered over */
        }

        /* Sidebar toggle button styles */
        #sidebarToggle {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 1050;
            background-color: #343a40;
            color: white;
            border: none;
            padding: 10px;
            font-size: 18px;
            cursor: pointer;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            #sidebar {
                width: 200px;
            }

            #page-content-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include('sidebar.php'); ?>

        <!-- Page content -->
        <div id="page-content-wrapper" class="container-fluid">
            <!-- Dynamic content goes here -->
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

    <script>
        $(document).ready(function () {
            // Initial state: sidebar is open (not collapsed)
            let sidebarCollapsed = false;

            // When the page loads, the sidebar is fully expanded and content is adjusted
            $('#sidebar').removeClass('collapsed');
            $('#page-content-wrapper').css('margin-left', '250px');

            // Toggle sidebar on click
            $('#sidebarToggleIcon').click(function () {
                if (sidebarCollapsed) {
                    // Expand the sidebar
                    $('#sidebar').removeClass('collapsed');
                    $('#page-content-wrapper').animate({ marginLeft: '250px' }, 300);
                } else {
                    // Collapse the sidebar
                    $('#sidebar').addClass('collapsed');
                    $('#page-content-wrapper').animate({ marginLeft: '60px' }, 300);
                }
                sidebarCollapsed = !sidebarCollapsed;  // Toggle the state
            });
        });
    </script>
</body>

</html>