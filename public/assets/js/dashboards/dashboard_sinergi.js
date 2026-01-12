
$(function () {


    // =====================================
    // Chart "Statistik Persuratan" (Bar Chart for Surat Masuk vs Keluar)
    // Replaces the main revenue chart style
    // =====================================
    var suratChartOptions = {
        series: [
            {
                name: "Surat Masuk",
                data: [20, 15, 30, 25, 10, 18],
            },
            {
                name: "Surat Keluar",
                data: [12, 18, 14, 8, 5, 12],
            },
        ],
        chart: {
            toolbar: {
                show: false,
            },
            type: "bar",
            fontFamily: "Plus Jakarta Sans', sans-serif",
            foreColor: "#adb0bb",
            height: 320,
            stacked: true,
        },
        colors: ["var(--bs-primary)", "var(--bs-secondary)"],
        plotOptions: {
            bar: {
                horizontal: false,
                barHeight: "60%",
                columnWidth: "20%",
                borderRadius: [6],
                borderRadiusApplication: 'end',
                borderRadiusWhenStacked: 'all'
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: true,
        },
        grid: {
            borderColor: "rgba(0,0,0,0.1)",
            strokeDashArray: 3,
            xaxis: {
                lines: {
                    show: false,
                },
            },
        },
        yaxis: {
            min: -5,
            max: 40,
            title: {
                // text: 'Jumlah Surat',
            },
        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            categories: [
                "Juli",
                "Agust",
                "Sept",
                "Okt",
                "Nov",
                "Des",
            ],
        },
        yaxis: {
            tickAmount: 4,
        },
        tooltip: {
            theme: "dark",
        },
    };

    var chart_surat = new ApexCharts(
        document.querySelector("#chart-persuratan"),
        suratChartOptions
    );
    chart_surat.render();


    // =====================================
    // Chart "Kondisi Aset" (Donut Chart)
    // Replaces Monthly Earnings or similar
    // =====================================
    var asetChartOptions = {
        color: "#adb5bd",
        series: [150, 25, 10], // Baik, Rusak Ringan, Rusak Berat
        labels: ["Baik", "Rusak Ringan", "Rusak Berat"],
        chart: {
            type: "donut",
            height: 300,
            fontFamily: "Plus Jakarta Sans', sans-serif",
            foreColor: "#adb0bb",
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '75%',
                    background: 'transparent',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            offsetY: 7,
                        },
                        value: {
                            show: false,
                        },
                        total: {
                            show: true,
                            color: '#5A6A85',
                            fontSize: '20px',
                            fontWeight: '600',
                            label: '185 Aset',
                        },
                    },
                },
            },
        },
        stroke: {
            show: false,
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            position: "bottom",
            horizontalAlign: "center",
            show: true,
        },
        colors: ["var(--bs-success)", "var(--bs-warning)", "var(--bs-danger)"],
        tooltip: {
            theme: "dark",
            fillSeriesColor: false,
        },
    };

    var chart_aset = new ApexCharts(
        document.querySelector("#chart-aset"),
        asetChartOptions
    );
    chart_aset.render();


    // =====================================
    // Sparkline Charts for Summary Cards
    // =====================================

    // Surat Masuk Sparkline
    var sparklineMasuk = {
        series: [{
            name: "Masuk",
            data: [4, 10, 9, 7, 9, 10, 11, 8, 10]
        }],
        chart: {
            type: 'area',
            height: 40,
            sparkline: { enabled: true },
            fontFamily: "Plus Jakarta Sans', sans-serif",
        },
        stroke: { curve: 'smooth', width: 2 },
        fill: { type: 'gradient', gradient: { opacityFrom: 0.1, opacityTo: 0, stops: [0, 100] } },
        colors: ["var(--bs-primary)"],
        tooltip: { fixed: { enabled: false }, x: { show: false }, marker: { show: false } }
    };
    new ApexCharts(document.querySelector("#spark-surat-masuk"), sparklineMasuk).render();

    // Surat Keluar Sparkline
    var sparklineKeluar = {
        series: [{
            name: "Keluar",
            data: [2, 5, 6, 11, 5, 9, 3, 5, 2]
        }],
        chart: {
            type: 'area',
            height: 40,
            sparkline: { enabled: true },
            fontFamily: "Plus Jakarta Sans', sans-serif",
        },
        stroke: { curve: 'smooth', width: 2 },
        fill: { type: 'gradient', gradient: { opacityFrom: 0.1, opacityTo: 0, stops: [0, 100] } },
        colors: ["var(--bs-secondary)"],
        tooltip: { fixed: { enabled: false }, x: { show: false }, marker: { show: false } }
    };
    new ApexCharts(document.querySelector("#spark-surat-keluar"), sparklineKeluar).render();



});
