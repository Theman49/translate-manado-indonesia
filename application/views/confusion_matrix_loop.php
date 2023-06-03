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
		$idx = 0;
                foreach($header_table as $row){
		    if($idx == 1){
			echo "<td style='background-color: #ddd; color: black'>kosakata</td>";
		    }
		    echo "<th style='background-color: #ddd; color: black'>".$row."</th>";
		    $idx++;
                }
            ?>
            <th>jumlah</th>
        </tr>
    </thead>
    <tbody>
            <?php
                $idx = 0;
                foreach($scores as $score){
		    $colName = "col_".$idx+2;
                    echo "<tr>";
                    echo "<td>".$names[$idx]."</td>";
		    echo "<th style='background-color: #ddd; color: black'>".$header_table[$colName]."</th>";
                    foreach($score['array_score'] as $v){
                        echo "<td style='text-align: center'>".$v."</td>";
                    }
                    echo "<td>".$score[$names[$idx]]."</td>";
                    echo "</tr>";
                    $idx++;
                }
            ?>
            <tr>
	    <?php
		$sum = 0;
		$idx = 0;
		foreach($scores as $score){
			$sum += $score[$names[$idx]];
			$idx++;
		}

		$average = $sum / count($scores[0]['array_score']);
	    ?>
                <td colspan="12" style="text-align: right; background-color: #ddd; ">Total</td>
                <td style="background-color: #ddd; "><?=$sum?></td>
            </tr>
    </tbody>
</table>

    <p>Accuracy = (Jumlah Prediksi Benar / total prediksi) * 100%</p>
    <p>Accuracy = (100 / <?=$sum ?>) * 100%</p>
    <p>Accuracy = <?=$average * 10?>%</p>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
