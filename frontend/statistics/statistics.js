function getStatistics(){
    fetch('../../backend/endpoints/statistics.php', {
        method: 'GET'
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error('Error getting statistics.');
            }
            return response.json();
        })
        .then(response => {
            getStatisticsIndicator(response.userCount, `user-count`, "Брой потребители");
            getStatisticsIndicator(response.postCount, `post-count`, "Брой постове");
            getStatisticsPieChart(response.faculty, `faculty`);
            getStatisticsBarChart(response.speciality, `speciality`, "Брой потребители по специалност");
            getStatisticsBarChart(response.graduationYear, `graduation-year`, "Брой потребители по година на завършване");
        })
        .catch(error => {
            const message = 'Error getting statistics.';
            console.error(message);
        });
}

function getStatisticsBarChart(statistics, element, barTitle){
    var data = [
        {
          x: statistics[0],
          y: statistics[1],
          type: 'bar',
        
          marker: {
              color: '#3bb371',
          }
        }
      ];
      
      var layout = {
        title: barTitle
      }
    Plotly.newPlot(element, data, layout);
}

function getStatisticsPieChart(statistics, element){
    var data = [{
        type: "pie",
        labels: statistics[0],
        values: statistics[1],
        textinfo: "label+percent",
        insidetextorientation: "radial"
      }]
      
      var layout = {
        title: 'Брой потребители по факултет',
        height: 600,
        width: 600
      }
      
      Plotly.newPlot(element, data, layout)
}

function getStatisticsIndicator(statistics, element, text){
    var data = [
        {
          type: "indicator",
          value: statistics,
         
          title: {
            text:
              text
          }
        }
      ];
      
      var layout = {
        width: 300,
        height: 300,
      };
      
      Plotly.newPlot(element, data, layout);
}

getStatistics();