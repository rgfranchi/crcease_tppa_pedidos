// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var pedidosPie = document.getElementById("pedidosPie");
var dataValue = []

var total = pedidosPie.getAttribute('total');
var label = JSON.parse(pedidosPie.getAttribute('label'));
var quantidade = JSON.parse(pedidosPie.getAttribute('quantidade'));
var cores = JSON.parse(pedidosPie.getAttribute('cores'));

var pedidosPieChart = new Chart(pedidosPie, {
  type: 'pie',
  data: {
    labels: label,
    datasets: [{
      data: quantidade,
      backgroundColor: cores,
      hoverBackgroundColor: "#afb1c5",
      hoverBorderColor: "black",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "black",
      borderColor: 'blue',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: true,
      position: 'bottom'
    },
    cutoutPercentage: 20,
  },
});
