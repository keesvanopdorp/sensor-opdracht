<canvas id="chart" class="mx-auto"></canvas>
<script src="assets/js/chart.min.js"></script>
<script>
    const ctx = document.querySelector('#chart').getContext('2d');
    /**
     *
     * @const {Chart} chart
     */
    const chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',
        // The data for our dataset
        data: {
            labels: labels,
            datasets: [{
                label: "temperatuur",
                borderColor: 'rgb(0,152,38)',
                data: temps,
            },
                {
                    label: "luchtvochtigheid",
                    borderColor: 'rgb(20, 1, 100)',
                    data: humidity
                }]
        },

        // Configuration options go here
        options: {
            elements: {
                line: {
                    fill: false
                }
            }
        }
    });
</script>
