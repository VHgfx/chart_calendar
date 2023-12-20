var myChart;
var chartData;
var ctx;

console.log(initialData);

$(document).ready(function () {
    $("#start_date, #end_date").on('input', function () {
        var startDate = $("#start_date").val();
        var endDate = $("#end_date").val();

        // Perform validation as needed
        if (startDate && endDate && startDate > endDate) {
            toastr.error('La date de début doit être avant la date de fin', 'Erreur');
        } else {
            toastr.clear();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    ctx = document.getElementById('myChart').getContext('2d');
    chartData = initialData;
    var chartLabels = chartData.data.labels;
    var chartValue = chartData.data.value;

    /*if (typeof chartData === 'object' && chartData.data) {
        console.log('Correct Type');
    } else { 
        console.log('Incorrect Type');
    }*/

    console.log('ChartData Labels :',chartData.data.labels);
    console.log('ChartData Data :',chartData.data.value);
    

    myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartValue
            }]
        },
        options: {
            animation: {
                duration: 2000, // Set your desired duration
                easing: 'easeInOutQuart',
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});

function updateChart(event) {
    if (event) {
        event.preventDefault(); // Prevent form submission
    }

    // Capture the form data
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();

    var currentDate = new Date();
    var currentHour = currentDate.toISOString().slice(11,19);

    if (start_date.trim() !== '') {
        start_date = start_date + ' ' + currentHour;
    }
    
    // Check if end_date is not empty before appending currentHour
    if (end_date.trim() !== '') {
        end_date = end_date + ' ' + currentHour;
    }

    // Send an AJAX request to update data
    $.ajax({
        type: 'POST',
        url: 'data.php', // Update the URL with your data processing script
        data: {start_date: start_date, end_date: end_date},
        success: function(response) {
            response = JSON.parse(response);
            // Assuming your server responds with JSON data
            updateChartData(myChart, response);
        },
        error: function(xhr, status, error) {
            console.log('Response Data:', response.data);
        }
    });
}

function updateChartData(chartName, response) {
    console.log("Avant la mise à jour", chartName.data.datasets[0].data);
    chartName.data.datasets[0].data = [];
    chartName.data.datasets[0].data = response.data.value;

    // Specify the duration of the animation (e.g., 1000 milliseconds)
    const animationDuration = 2000;
    console.log("Après la mise à jour", chartName.data.datasets[0].data);

    chartName.update();
      
};

toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: 'toast-top-right',
    showMethod: 'slideDown',
    timeOut: 4000
};

// Probleme : Plus d'update apres coup, verifier fonction UpdateChart