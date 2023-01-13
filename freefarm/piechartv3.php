<?php
// Use the API key and secret to authenticate
$consumer_key = 'ck_d6f1155e43ef5263eeb09fe8071ee52b1cdfa719';
$consumer_secret = 'cs_aa5ed086c245ff63217a90a7645434063738877c';


// Get the sales data for the last day and week
$last_day = strtotime('-1 day');
$last_week = strtotime('-1 week');

$last_day_sales = get_sales_data($consumer_key, $consumer_secret, $last_day);
$last_week_sales = get_sales_data($consumer_key, $consumer_secret, $last_week);

function get_sales_data($consumer_key, $consumer_secret, $timestamp) {
    // Use the API key and secret to authenticate
    $headers = array(
        'Authorization' => 'Basic ' . base64_encode( $consumer_key . ':' . $consumer_secret )
    );

    // Get the orders from the API
    $api_endpoint = 'http://chinitowong.cl/tienda/wp-json/wc/v3/orders?status=completed&after=' . $timestamp;
    $response = wp_remote_get( $api_endpoint, array( 'headers' => $headers ) );

    $orders = json_decode( wp_remote_retrieve_body( $response ), true );

    // Calculate the total sales for the period
    $sales = 0;
    foreach ( $orders as $order ) {
        $sales += $order['total'];
    }

    return $sales;
}
?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Period', 'Sales'],
          ['Last Day', <?php echo $last_day_sales; ?>],
          ['Last Week', <?php echo $last_week_sales; ?>]
        ]);

        var options = {
          title: 'WooCommerce Sales Report'
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