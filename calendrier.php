<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <meta charset="UTF-8">

</head>
<body>
    <form id="dateForm">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" oninput="updateChart()">

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" oninput="updateChart()">
    </form>

    <div>
        <canvas id="myChart" width="400"></canvas>
    </div>


    <script>
        var initialData = <?php include_once("data.php");?>;
        //initialData = JSON.parse(initialData);
        console.log('InitialData Data :',initialData);
    </script>";

    <script src="script.js"></script>
</body>