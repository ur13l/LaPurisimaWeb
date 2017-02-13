
const CHART = document.getElementById("lineChart");
// Chart.defaults.global.responsive = false; change the properties with this, now you chart lose the responsive design
// // () => is like function () { }
 Chart.defaults.global.animation.onComplete = () => {
   console.log("finished");
 }
// Chart.defaults.global.animation.duration =  50; change the speed of the chart
let lineChart = new Chart(CHART, {
  type: 'line',
  data:  {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
        {
            label: "My First dataset",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: [65, 59, 80, 81, 56, 55, 40],
            spanGaps: false,
        },   {
              label: "My second dataset",
              fill: true,
              //spiky or curve the graphic linetension
              lineTension: 0,
              backgroundColor: "rgba(75,75,192,0.4)",
              borderColor: "rgba(75,72,192,1)",
              borderCapStyle: 'butt',
              borderDash: [],
              borderDashOffset: 0.0,
              borderJoinStyle: 'miter',
              pointBorderColor: "rgba(75,72,192,1)",
              pointBackgroundColor: "#fff",
              pointBorderWidth: 1,
              pointHoverRadius: 5,
              pointHoverBackgroundColor: "rgba(75,72,192,1)",
              pointHoverBorderColor: "rgba(220,220,220,1)",
              pointHoverBorderWidth: 2,
              pointRadius: 1,
              pointHitRadius: 10,
              data: [100, 20, 60, 20, 80, 55, 90],
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
