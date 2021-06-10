// useri - fakultet, specialnost, godina na zavurshvane, vsichki useri
// broi na vsichki postove

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
            getStatisticsBarChart(response.speciality, `speciality`);
            getStatisticsBarChart(response.graduationYear, `graduation-year`);
        })
        .catch(error => {
            const message = 'Error getting statistics.';
            console.error(message);
        });
}

function getStatisticsBarChart(statistics, element){
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
      
    Plotly.newPlot(element, data);
}

function getStatisticsPieChart(statistics, element){
    var data = [{
        type: "pie",
        labels: statistics[0],
        values: statistics[1],
        textinfo: "label+percent",
        insidetextorientation: "radial"
      }]
      
      var layout = [{
        title: 'Faculty',
        height: 700,
        width: 700
      }]
      
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
        height: 400,
        margin: { t: 0, b: 0, l: 0, r: 0 }
      };
      
      Plotly.newPlot(element, data, layout);
}

getStatistics();