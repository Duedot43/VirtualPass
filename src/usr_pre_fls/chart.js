anychart.onDocumentReady(function () {
  if (his != "NONE"){
    var history_data = JSON.parse(his);
  } else{
    var history_data = "DATA_UNAVALABLE";
  }
  var dataSet = anychart.data.set(getData(history_data));

  var seriesData = dataSet.mapAs({ x: 0, value: 1 });

  var chart = anychart.fromJson(
    {chart: {type: "line",
    series:[{seriesType: "spline",

    data: [
      {x: ""}
    ]
  
  }]
  }}
  );

  chart.title('History of students registered');
  chart.yAxis().title('Students');
  var lineChart = chart.line(seriesData);
  chart.container('freq');
  chart.draw();
  
});

//Daily Data

//scopes
  //7-day measure
  //14-day measure
  //2-weeks
  //4-weeks

//All time Data


//script to process data.
function getData(history_data) {
  var output = [];
  console.log(history_data['history']);
  for (let x in history_data['history']){
    console.log(x);
    var date = new Date(x*1000);
    output.push([date, history_data['history'][x]['userReg']]);
  }
    return output;
  }
