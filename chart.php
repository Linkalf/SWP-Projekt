<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart</title>
    <script src="//cdn.zingchart.com/zingchart.min.js"></script>
</head>
<body>
    <?php  include "zc.php"; ?>
    <div id="Chart1"></div>
    <?php

    $zc1 = new \ZingChart\PHPWrapper\ZC("Chart1", "line");
    $zc1->setSeriesData(0, [1,5,4,6,8]);
    $zc1->render();

    ?>
</body>
</html>