<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>RepairShopr Rest API Demo</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <link rel="icon" href="favicon.ico">
    </head>
    <body>
        <div class="container" style="margin-top:32px;">
            <div class="jumbotron">
                <h1 class="display-3">RepairShopr Rest API Demo</h1>
                <p class="lead">This is a simple demonstration of the Rest API avaliable for the CRM system RepairShopr. It will run through the list of products and display them paginated in blocks of 20.</p>
                <p class="lead">
                    <a class="btn btn-primary" href="https://ryanapil.uk" role="button">https://ryanapil.uk</a>
                </p>
            </div>
            <?php
                if ((isset($_GET['page'])) && (is_numeric($_GET['page']))) {
                    $page_id = $_GET['page'];
                } else {
                    $page_id = "1";
                }
                //next example will recieve all messages for specific conversation
                $service_url = 'http://SUBDOMAIN.repairshopr.com/api/v1/products?api_key=API_KEY&page=' . $page_id;
                $curl = curl_init($service_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $curl_response = curl_exec($curl);
                if ($curl_response === false) {
                    $info = curl_getinfo($curl);
                    curl_close($curl);
                    die('error occured during curl exec. Additioanl info: ' . var_export($info));
                }
                curl_close($curl);
                $decoded = json_decode($curl_response, true);

                echo "<table class='table'>
    <thead>
        <tr>
            <th></th>
            <!--<th>ID</th>-->
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>";
                foreach ($decoded as $key => $products) {
                    foreach($products as $key => $value) {
                        echo "<tr>
<td>";
                        foreach($value["photos"] as $key => $image) {
                            if ($key == 0) {
                                echo "<img src='" . $image["thumbnail_url"] . "'>";
                            }
                        }
                        echo "</td>
<!--<td>" . $value["id"] . "</td>-->
<td>" . $value["name"] . "</td>
<td>" . $value["description"] . "</td>
<td>£" . $value["price_retail"] . "</td>
</tr>";
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="?page=<?php echo $page_id - 1; ?>" class="btn btn-secondary">Previous</a>
                                <button type="button" class="btn btn-secondary disabled"><?php echo $page_id; ?></button>
                                <a href="?page=<?php echo $page_id + 1; ?>" class="btn btn-secondary">Next</a>
                            </div>
                        <td>
                    <tr>
                </tfoot>
                <?php
                echo "</tbody>
</table>";
            ?>
            <div class="text-center" style="margin-bottom:32px;">
                Copyright &copy; 2017 Ryan Pilbrow All Rights Reserved.
            </div>
        </div>
        <script src="https://use.fontawesome.com/c4647d034e.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    </body>
</html>
