$.ajax({
  type: "post",
  url: "functions/user_profile_functions.php?function_name=get_scores_across_modules",
  data: {
    user_id: student_on_profile.id,
  },
  success: function (res) {
    var response = JSON.parse(res);

    console.log(response);

    const options = {
      chart: {
        type: "pie",
      },
      allowPointSelect: true,
      keys: ["name", "y", "selected", "sliced"],
      title: {
        text: "Student Scores Across Modules",
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: "pointer",
          dataLabels: {
            enabled: true,
            format: "<b>{point.name}</b>: {point.y:.0f}",
            style: {
              fontWeight: "bold",
            },
          },
          animation: {
            duration: 500,
            easing: "easeOutBounce",
          },
          states: {
            select: {
              animation: {
                duration: 300,
                easing: "easeOutBounce",
              },
            },
          },
        },
      },
      series: [
        {
          name: "Scores",
          data: [
            { name: "Words", y: parseInt(response.words_score ?? 0) },
            { name: "Idioms", y: parseInt(response.idioms_score ?? 0) },
            { name: "Simile", y: parseInt(response.simile_score ?? 0) },
            { name: "Metaphor", y: parseInt(response.metaphor_score ?? 0) },
            { name: "Hyperbole", y: parseInt(response.hyperbole_score ?? 0) },
            { name: "Type Master", y: parseInt(response.type_score ?? 0) },
          ],
        },
      ],
    };

    // Render the chart
    const chart = Highcharts.chart("container-charts", options);
    chart.series[0].points[4].select();
  },
});

$.ajax({
  type: "post",
  url: "../learn_typing/functions/level_functions.php?function_name=get_progress",
  data: {
    user_id: student_on_profile.id,
  },
  success: function (res) {
    var response = JSON.parse(res);

    var total_levels = response.length;
    var completed_levels = response.reduce((total, obj) => {
      if (obj.status === "completed") {
        return total + 1;
      } else {
        return total;
      }
    }, 0);

    var percent_completed = parseInt((completed_levels / total_levels) * 100);

    // if (completed_levels == 0) {
    //   document.getElementById("container-pie-chart").style.display = "none";
    // }

    Highcharts.chart("container-pie-chart", {
      chart: {
        type: "bar",
        backgroundColor: "#f2f2f2",
      },
      title: {
        text: "Learn Typing Progress",
      },
      xAxis: {
        categories: ["Levels Completed"],
      },
      yAxis: {
        min: 0,
        max: total_levels,
        title: {
          text: null,
        },
      },
      plotOptions: {
        bar: {
          dataLabels: {
            enabled: true,
            formatter: function () {
              return percent_completed + "%";
            },
          },
        },
      },
      series: [
        {
          name: "Levels Completed",
          data: [completed_levels],
          color: "#0070C0",
        },
      ],
    });
  },
});

// Define the progress bar options

// Define the chart options
