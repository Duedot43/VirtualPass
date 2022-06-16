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

  chart.title('John Doe');
  chart.yAxis().title('Frequency of leaves');
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
  output = [];
  console.log(history_data['history']);
  for(his_arr in history_data){
    console.log("NICE!")
  }
    return [

      ['1/2/22', 1.0],
      ['1/3/22', 0],
      ['1/4/22', 0],
      ['1/5/22', 0],
      ['1/6/22', 4.0],
      ['1/7/22', 0],
      ['1/8/22', 1.0],
      ['1/9/22', 2.0],
      ['1/10/22', 0],
      ['1/11/22', 3.0],
      //User Data here.
    ];
  }
