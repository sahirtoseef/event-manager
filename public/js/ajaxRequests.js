$(document).ready(function() {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
  });

  const buildActionsArray = [
    { action: "GET-EVENTS" },
    { action: "GET-CLIENTS" },
    { action: "GET-VISITORS" },
    { action: "POPULATE-GRAPH" },
    { action: "PEAK-TIMINGS" }
  ];

  buildActionsArray.map(singleObj => {
    $.ajax({
      type: "POST",
      url: "/admin/handleAjaxRequests",
      data: singleObj,
      cache: false,
      success: function(data, status, jqXHR) {
        const payload = JSON.parse(data);
        switch (payload.action) {
          case "GET-EVENTS":
            setUpEvetnsToDom(payload);
            break;
          case "GET-CLIENTS":
            setUpClientsToDom(payload);
            break;
          case "GET-VISITORS":
            setUpVisitorsToDom(payload);
            break;
          case "POPULATE-GRAPH":
            populateGraph(payload);
            break;
          case "PEAK-TIMINGS":
            setUpPeakHoursToDom(payload);
            break;
          default:
            break;
        }
      },
      error: function(jqXHR, status) {
        console.log("ERR status: " + status);
        console.log("ERR xhr text: " + jqXHR.responseText);
      }
    });
  });

  function setUpEvetnsToDom(payload) {
    $(".admin-event-count").text(payload.totalEvents);
    formatSpan(".admin-event-percentage", payload);
  }
  function setUpClientsToDom(payload) {
    $(".admin-client-count").text(payload.totalClients);
    formatSpan(".admin-client-percentage", payload);
  }
  function setUpVisitorsToDom(payload) {
    $(".admin-visitor-count").text(payload.totalVisitors);
    formatSpan(".admin-visitor-percentage", payload);
  }
  function setUpPeakHoursToDom(payload) {
    $(".admin-peak-hour-count").text(payload.peakHourTime);
    $(".admin-peak-hour-percentage").addClass("text-warning");
    $(".admin-peak-hour-percentage").html(payload.difference.percentage);
  }

  function formatSpan(className, payload) {
    switch (payload.difference.colorType) {
      case "greenColor":
        $(className).addClass("text-success");
        $(className).html(
          '<i class="fa fa-arrow-up"> ' + payload.difference.percentage
        );
        break;
      case "redColor":
        $(className).addClass("text-danger");
        $(className).html(
          '<i class="fas fa-arrow-down"> ' + payload.difference.percentage
        );
        break;
      case "yellowColor":
        $(className).addClass("text-warning");
        $(className).html(
          '<i class="fa fa-arrow-up"> ' + payload.difference.percentage
        );
        break;
    }
  }

  function populateGraph(payload) {
    //Chart init
    var SalesChart = (function() {
      // Variables

      var $chart = $("#visitors-graph");

      // Methods

      function init($chart) {
        var salesChart = new Chart($chart, {
          type: "line",
          options: {
            scales: {
              yAxes: [
                {
                  gridLines: {
                    lineWidth: 1,
                    color: Charts.colors.gray[900],
                    zeroLineColor: Charts.colors.gray[900]
                  },
                  ticks: {
                    callback: function(value) {
                      if (!(value % 10)) {
                        return "" + value + "";
                      }
                    }
                  }
                }
              ]
            },
            tooltips: {
              callbacks: {
                label: function(item, data) {
                  var label = data.datasets[item.datasetIndex].label || "";
                  var yLabel = item.yLabel;
                  var content = "";

                  if (data.datasets.length > 1) {
                    content +=
                      '<span class="popover-body-label mr-auto">' +
                      label +
                      "</span>";
                  }

                  content +=
                    '<span class="popover-body-value">' + yLabel + "</span>";
                  return content;
                }
              }
            }
          },
          data: {
            labels: payload.graphData.X_AXIS,
            datasets: [
              {
                label: "Performance",
                data: payload.graphData.Y_AXIS
              }
            ]
          }
        });

        // Save to jQuery object

        $chart.data("chart", salesChart);
      }

      // Events

      if ($chart.length) {
        init($chart);
      }
    })();
  }
});
