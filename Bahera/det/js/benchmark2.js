		$(function() {  // Document Ready function START  
			
			
			//////ALARM TABLE START/////
			
                $('#example1').dataTable({
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": false,
                    "bAutoWidth": false
                });//////ALARM TABLE END/////


		
		///HIGHCHART START 
		///Container 1
		$("#container1").highcharts({
			
        chart: {
            zoomType: 'xy',
			 width: 1050,
            height: 150
        },
        title: {
            text: null
        },
        subtitle: {
            text: null
        },
        xAxis: [{
            categories: ts
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value}kW',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            title: {
                text: 'Power',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            }
        }, { // Secondary yAxis
            title: {
                text: 'Energy',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            labels: {
                format: '{value} kWh',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true,
			style: {
				fontSize: '9px'
			}
        },
       legend: {
            /* layout: 'vertical',
            align: 'left',
            x: 120,
            verticalAlign: 'top',
            y: 100,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'*/
			enabled: false
        },
		exporting: {
        enabled: false
    	},
        series: [{
            name: 'Energy',
            type: 'column',
            yAxis: 1,
            data: energy,
            tooltip: {
                valueSuffix: 'kWh'
            }

        }, {
            name: 'Power',
            type: 'spline',
            data: power,
            tooltip: {
                valueSuffix: 'kW'
            }
        }]
    });
	///container 1 end
	
	 //Date/time picker with time picker
      
		$('#timepicker').datetimepicker({
	datepicker:false,
	format:'H:i',
	
});
$('#datepicker').datetimepicker({
	
	timepicker:false,
	format:'d/m/Y',
	formatDate:'Y/m/d',
	minDate:'-2013/01/01' // and tommorow is maximum date calendar
});
		});  // Document Ready function END 

          
