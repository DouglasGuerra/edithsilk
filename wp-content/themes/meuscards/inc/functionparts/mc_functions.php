<?php
function chart($labels, $data){
 
?>
    
    <div>
    <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
        labels: [<?php 
                foreach($labels as $label){
                    echo "' $label '" . ',';
                }

            ?>],
        datasets: [{
            label: 'Dashboard',
            data: [<?php foreach($data as $dado){
                    echo " $dado " . ',' ;

            } ?>],
            borderWidth: 1
        }]
        },
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });
    </script>

 <?php
         
    print_r($labels);
    print_r($data);

}
