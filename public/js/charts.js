
const CHART = document.getElementById("lineChart");
const CHART2 = document.getElementById("lineChart2");
// Chart.defaults.global.responsive = false; change the properties with this, now you chart lose the responsive design
// // () => is like function () { }
 Chart.defaults.global.animation.onComplete = () => {
   console.log("finished");
 }
// Chart.defaults.global.animation.duration =  50; change the speed of the chart
let lineChart = new Chart(CHART, {
  type: 'line',
  data:  {
    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
    datasets: [
          {
              label: "Ventas total del mes",
              fill: true,
              //spiky or curve the graphic linetension
              lineTension: 0,
              backgroundColor: "rgba(75,174,234,1)",
              borderColor: "rgba(20,127,211,1)",
              borderCapStyle: 'butt',
              borderDash: [],
              borderDashOffset: 0.0,
              borderJoinStyle: 'miter',
              pointBorderColor: "rgba(0,0,255,1)",
              pointBackgroundColor: "#fff",
              pointBorderWidth: 1,
              pointHoverRadius: 5,
              pointHoverBackgroundColor: "rgba(20,127,211,1)",
              pointHoverBorderColor: "rgba(0,0,255,1)",
              pointHoverBorderWidth: 2,
              pointRadius: 1,
              pointHitRadius: 10,
              data: totales,
              spanGaps: false,
          }
    ]
},
options: {
  //showLines: false, to hide the lines of the chart
  scales: {
    yAxes: [{
      ticks: {
        //to begin from 0 the chart
        beginAtZero:true,
        // reverse: true   to begin with the end to start
      }
    }]
  }
}
});



// Chart.defaults.global.animation.duration =  50; change the speed of the chart
let lineChart2 = new Chart(CHART2, {
 type: 'line',
 data:  {
   labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
   datasets: [
         {
             label: "Mejores clientes",
             fill: true,
             //spiky or curve the graphic linetension
             lineTension: 0,
             backgroundColor: "rgba(75,174,234,1)",
             borderColor: "rgba(20,127,211,1)",
             borderCapStyle: 'butt',
             borderDash: [],
             borderDashOffset: 0.0,
             borderJoinStyle: 'miter',
             pointBorderColor: "rgba(0,0,255,1)",
             pointBackgroundColor: "#fff",
             pointBorderWidth: 1,
             pointHoverRadius: 5,
             pointHoverBackgroundColor: "rgba(20,127,211,1)",
             pointHoverBorderColor: "rgba(0,0,255,1)",
             pointHoverBorderWidth: 2,
             pointRadius: 1,
             pointHitRadius: 10,
             data: totales,
             spanGaps: false,
         }
   ]
},
options: {
 //showLines: false, to hide the lines of the chart
 scales: {
   yAxes: [{
     ticks: {
       //to begin from 0 the chart
       beginAtZero:true,
       // reverse: true   to begin with the end to start
     }
   }]
 }
}
});
