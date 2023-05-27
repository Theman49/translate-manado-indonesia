<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
<table class="table">
    <thead>
        <tr>
            <?php
                foreach($header_table as $row){
                    echo "<th>".$row."</th>";
                }
            ?>
            <th>jumlah</th>
        </tr>
    </thead>
    <tbody>
            <?php
                $idx = 0;
                foreach($scores as $score){
                    echo "<tr>";
                    echo "<th>".$names[$idx]."</th>";
                    foreach($score['array_score'] as $v){
                        echo "<td>".$v."</td>";
                    }
                    echo "<td>".$score[$names[$idx]]."</td>";
                    echo "</tr>";
                    $idx++;
                }
            ?>
            <tr>
                <td colspan="11" style="text-align: right">Rata-rata</td>
                <td><?=$average?></td>
            </tr>
    </tbody>
</table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>