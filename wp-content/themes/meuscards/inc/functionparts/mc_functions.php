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
      labels: $labels[0],
      datasets: [{
        label: '# of Votes',
        data: $data[0],
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
    echo '<pre>';
    var_dump($data);
    var_dump($labels);
    echo '</pre>';


}
