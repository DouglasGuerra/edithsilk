<?php
function chart($data){
    
?>
    
        <div>
            <canvas id="myChart"></canvas>
        </div>

        <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
        type: 'bar',
        data: {
            labels: $data[labels],
            datasets: [{
            label: 'Quantidade de processos',
            data: $data[data],
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
}
