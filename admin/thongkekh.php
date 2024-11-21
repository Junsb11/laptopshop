<?php include 'inc/header.php';
include 'inc/sidebar.php'?>

<?php
		include 'connect.php';
		$sql_thongke="select hoa_don.*, count(MaHD) as 'TongDon'  from hoa_don group by TenDangNhap;";
		$result=mysqli_query($conn,$sql_thongke);
        $result1=mysqli_query($conn,$sql_thongke);
?>

<div class="grid_10">
            <div class="box round first grid">
				<form action="thongkekh.php" method="get">
                <h2>Thống kê khách hàng thân thiết</h2>
                <div class="chart-container chart-container--size-2">
  <canvas id="chartVerticalBar"></canvas>
</div>
			   </form>
            </div>
        </div>
<script type="text/javascript">

    

    window.addEventListener('load', function () {
  var ctx = document.getElementById('chartVerticalBar').getContext('2d');
  var chart = new Chart(ctx, {

    type: 'bar',

    data: {
      labels:
      
      [
        
            <?php
                
                while ($data=mysqli_fetch_array($result)) {									
                    ?>
                          "<?php echo $data['TenDangNhap'];?>",
                            <?php
                    }
                
            ?>
        ],
      datasets: [{
        label: "Số đơn hàng",
        backgroundColor: 'rgba(245,34,34,.5)',
        borderColor: 'rgba(245,34,34,1)',
        data: [
            
            <?php
                
                while ($data1=mysqli_fetch_array($result1)) {									
                    ?>
                          "<?php echo $data1['TongDon'];?>",
                            <?php
                    }
                
            ?>
            ],
      }]
    },

    options: {
      responsive: true,
      title: {
        display: true,
        text: 'Số lượng đơn hàng'
      },
      tooltips: {
        mode: 'index',
        intersect: false,
      },
      hover: {
        mode: 'nearest',
        intersect: true,
      },
      scales: {
        xAxes: [{
          display: true,
          scaleLabel: {
            display: false,
            labelString: 'Mois'
          }
        }],
        yAxes: [{
          ticks: {
            beginAtZero: true
          },
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Số lượng đơn hàng'
          }

        }]
      }
    }
  });
  var mediaQuery = window.matchMedia('(min-width: 768px)');

  function toggleAspectRatio(mq) {
    chart.options.maintainAspectRatio = mq.matches;
    chart.resize();
  }

  toggleAspectRatio(mediaQuery);

  mediaQuery.addListener(toggleAspectRatio);
})

</script>
<?php include 'inc/footer.php';?>