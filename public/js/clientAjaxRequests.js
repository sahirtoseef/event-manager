$(document).ready(function() {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
  });

  const buildActionsArray = [
    { action: "GET-CLIENT-EVENTS" },
    { action: "GET-CLIENT-REGISTRATIONS" },
    { action: "GET-CLIENT-VISITORS" },
    { action: "GET-CLIENT-PEAK-TIMINGS"}
  ];
  buildActionsArray.map(singleObj => {
    $.ajax({
      type: "POST",
      url: "/client/handleAjaxRequests",
      data: singleObj,
      cache: false,
      success: function(data, status, jqXHR) {
        const payload = JSON.parse(data);
        switch (payload.action) {
          case "GET-CLIENT-EVENTS":
            setUpEvetnsToDom(payload);
            break;
          case "GET-CLIENT-REGISTRATIONS":
            setUpRegistrationsToDom(payload);
            break;
	  case "GET-CLIENT-VISITORS":
            setUpVisitorsToDom(payload);
            break;
	  case "GET-CLIENT-PEAK-TIMINGS":
            setUpPeakTimingsToDom(payload);
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
  function setUpRegistrationsToDom(payload) {
    $(".client-registrations-count").text(payload.totalRegistrations);
    formatSpan(".client-registrations-percentage", payload);
  }
  function setUpVisitorsToDom(payload) {
    $(".client-visitors-count").text(payload.totalVisitors);
    formatSpan(".client-visitors-percentage", payload);
  }
  function setUpPeakTimingsToDom(payload) {
    $(".client-peak-hour-time").text(payload.peakHourTime);
    formatSpan(".client-peak-hour-percentage", payload);
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
});
