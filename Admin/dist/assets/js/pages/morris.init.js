!function(e){"use strict";function a(){}a.prototype.createLineChart=function(e,a,r,t,o,i){Morris.Line({element:e,data:a,xkey:r,ykeys:t,labels:o,hideHover:"auto",gridLineColor:"#eef0f2",resize:!0,lineColors:i})},a.prototype.createLineChart1=function(e,a,r,t,o,i){Morris.Line({element:e,data:a,xkey:r,ykeys:t,labels:o,gridLineColor:"#3d434a",gridTextColor:"#eee",hideHover:"auto",pointSize:3,resize:!0,lineColors:i})},a.prototype.createAreaChart=function(e,a,r,t,o,i,l,s){Morris.Area({element:e,pointSize:3,lineWidth:2,data:t,xkey:o,ykeys:i,labels:l,resize:!0,hideHover:"auto",gridLineColor:"#eef0f2",lineColors:s})},a.prototype.createBarChart=function(e,a,r,t,o,i){Morris.Bar({element:e,data:a,xkey:r,ykeys:t,labels:o,gridLineColor:"#eef0f2",barSizeRatio:.4,resize:!0,hideHover:"auto",barColors:i})},a.prototype.createDonutChart=function(e,a,r){Morris.Donut({element:e,data:a,resize:!0,colors:r})},a.prototype.createDonutChart1=function(e,a,r){Morris.Donut({element:e,data:a,resize:!0,colors:r,labelColor:"#fff",backgroundColor:"#59c6fb"})},a.prototype.createStackedChart=function(e,a,r,t,o,i){Morris.Bar({element:e,data:a,xkey:r,ykeys:t,stacked:!0,labels:o,hideHover:"auto",resize:!0,gridLineColor:"#4ac18e",gridTextColor:"#eee",barColors:i})},a.prototype.init=function(){this.createLineChart("morris-line-example",[{y:"2009",a:50,b:40},{y:"2010",a:75,b:65},{y:"2011",a:50,b:40},{y:"2012",a:75,b:65},{y:"2013",a:50,b:40},{y:"2014",a:75,b:65},{y:"2015",a:50,b:40}],"y",["a","b"],["Series A","Series B"],["#30419b","#02c58d"]),this.createAreaChart("morris-area-example",0,0,[{y:"2009",a:10,b:20},{y:"2010",a:75,b:65},{y:"2011",a:50,b:40},{y:"2012",a:75,b:65},{y:"2013",a:50,b:40},{y:"2014",a:75,b:65},{y:"2015",a:90,b:60},{y:"2016",a:90,b:75}],"y",["a","b"],["Series A","Series B"],["#30419b","#02c58d"]),this.createBarChart("morris-bar-example",[{y:"2009",a:75,b:65},{y:"2010",a:100,b:90},{y:"2011",a:85,b:75},{y:"2012",a:40,b:50},{y:"2013",a:85,b:75},{y:"2014",a:55,b:45},{y:"2015",a:80,b:65},{y:"2016",a:100,b:85}],"y",["a","b"],["Series A","Series B"],["#30419b","#02c58d"]),this.createStackedChart("morris-bar-stacked",[{y:"2005",a:45,b:180},{y:"2006",a:120,b:65},{y:"2007",a:40,b:90},{y:"2008",a:75,b:85},{y:"2009",a:100,b:90},{y:"2010",a:75,b:65},{y:"2011",a:50,b:40},{y:"2012",a:100,b:85},{y:"2013",a:50,b:40},{y:"2014",a:75,b:65},{y:"2015",a:160,b:70},{y:"2016",a:60,b:120}],"y",["a","b"],["Series A","Series B"],["#02c58d","#f0f1f4"]),this.createDonutChart("morris-donut-example",[{label:"Download Sales",value:30},{label:"In-Store Sales",value:40},{label:"Mail-Order Sales",value:30}],["#fcbe2d","#30419b","#02c58d"]),this.createDonutChart1("morris-donut-example-dark",[{label:"Download Sales",value:40},{label:"In-Store Sales",value:20},{label:"Mail-Order Sales",value:20}],["#f0f1f4","#f0f1f4","#f0f1f4"]);this.createLineChart1("morris-line-example-dark",[{y:"2009",a:20,b:5},{y:"2010",a:45,b:35},{y:"2011",a:50,b:40},{y:"2012",a:75,b:65},{y:"2013",a:50,b:40},{y:"2014",a:75,b:65},{y:"2015",a:100,b:90}],"y",["a","b"],["Series A","Series B"],["#30419b","#02c58d"])},e.MorrisCharts=new a,e.MorrisCharts.Constructor=a}(window.jQuery),function(){"use strict";window.jQuery.MorrisCharts.init()}();