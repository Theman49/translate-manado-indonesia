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
    </tr>
  </thead>
  <tbody>
    <?php
        $count_data = count($header_table) - 1;
        $no = 0;
        foreach($header_table as $row){
            $row = trim($row);
            if($row == 'nama'){
                continue;
            }      
            echo "<tr>";
            echo "<th>".$row."</th>";
            for($i=0; $i<$count_data; $i++){
                if($no == $i){
                    $value = $scores[$i][$reference[$i]] / 10 * 100;
                    echo "<td>".$value."%</td>";
                }else{
                    echo " 
                        <td>0</td>
                    ";
                }
                
            }
            echo "</tr>";
            $no+=1;
        }
       
    ?>
    <tr>
        <td></td>
    </tr>
  </tbody>
</table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>