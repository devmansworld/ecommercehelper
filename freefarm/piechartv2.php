<?php
// Connect to the database
$db_host = 'chinitowong.cl';
$db_user = 'cch78902_vistaswordpress';
$db_pass = 'Reportes2023..';
$db_name = 'cch78902_wp_9a6d1';
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Retrieve data from the "products" table
$query = "SELECT sku, description, brand, price FROM products";
$result = mysqli_query($conn, $query);

// Initialize an array to store the data
$data = array();

// Loop through the result set and add the data to the array
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array($row['sku'], intval($row['price']));
}

// Close the connection
mysqli_close($conn);

// Encode the data in JSON format
$json_data = json_encode($data);
?>

<html>
<head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'SKU');
      data.addColumn('number', 'Price');
      data.addRows(<?php echo $json_data; ?>);

      var options = {
        title: 'SKU and Price',
        is3D: true,
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }
  </script>
</head>
<body>
  <div id="piechart" style="width: 900px; height: 500px;"></div>
</body>
</html>