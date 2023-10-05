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
        labels: <?php  print_r($labels) ?>,
        datasets: [{
            label: '# of Votes',
            data: <?php  print_r($data) ?>,
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
