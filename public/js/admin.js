/* MegaOfertas — admin dashboard JS (gráficas) */
(function () {
    'use strict';

    function chartData() {
        var el = document.getElementById('chart-data');
        return el ? JSON.parse(el.textContent) : null;
    }

    function fmt(n) {
        return '$' + Math.round(n).toLocaleString('en-US');
    }

    document.addEventListener('DOMContentLoaded', function () {
        var data = chartData();
        if (!data || !window.Chart) return;

        Chart.defaults.font.family = "'Inter', -apple-system, 'Segoe UI', Roboto, sans-serif";
        Chart.defaults.color = '#64748B';

        // ── Gráfica principal: barras (ingresos) + línea (comisión) ──
        var revenueCanvas = document.getElementById('revenueChart');
        if (revenueCanvas) {
            new Chart(revenueCanvas, {
                data: {
                    labels: data.labels,
                    datasets: [
                        {
                            type: 'bar',
                            label: 'Ingresos ($)',
                            data: data.revenue,
                            backgroundColor: 'rgba(79, 70, 229, .78)',
                            hoverBackgroundColor: 'rgba(79, 70, 229, 1)',
                            borderRadius: 8,
                            borderSkipped: false,
                            maxBarThickness: 34,
                            yAxisID: 'y',
                            order: 2
                        },
                        {
                            type: 'line',
                            label: 'Comisión de afiliado ($)',
                            data: data.commission,
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, .12)',
                            pointBackgroundColor: '#10B981',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            borderWidth: 3,
                            tension: .35,
                            fill: true,
                            yAxisID: 'y1',
                            order: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: { usePointStyle: true, boxWidth: 8, padding: 18, font: { size: 12, weight: '600' } }
                        },
                        tooltip: {
                            backgroundColor: '#0F172A',
                            padding: 12,
                            cornerRadius: 10,
                            titleFont: { size: 13, weight: '700' },
                            bodyFont: { size: 12.5 },
                            callbacks: {
                                label: function (ctx) {
                                    return ' ' + ctx.dataset.label + ': ' + fmt(ctx.parsed.y);
                                }
                            }
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { size: 11.5 } } },
                        y: {
                            position: 'left',
                            beginAtZero: true,
                            grid: { color: 'rgba(15, 23, 42, .06)' },
                            ticks: { font: { size: 11.5 }, callback: function (v) { return '$' + (v >= 1000 ? v / 1000 + 'k' : v); } }
                        },
                        y1: {
                            position: 'right',
                            beginAtZero: true,
                            grid: { drawOnChartArea: false },
                            ticks: { font: { size: 11.5 }, callback: function (v) { return '$' + (v >= 1000 ? v / 1000 + 'k' : v); } }
                        }
                    }
                }
            });
        }

        // ── Doughnut: estados de compras ──
        var statusCanvas = document.getElementById('statusChart');
        if (statusCanvas) {
            var order = ['aprobado', 'pendiente', 'nuevo', 'reversado'];
            var labels = { aprobado: 'Aprobado', pendiente: 'Pendiente', nuevo: 'Nuevo', reversado: 'Reversado' };
            var colors = { aprobado: '#10B981', pendiente: '#F59E0B', nuevo: '#3B82F6', reversado: '#EF4444' };
            var labelsArr = [], dataArr = [], colorsArr = [];

            order.forEach(function (key) {
                if (data.status[key]) {
                    labelsArr.push(labels[key]);
                    dataArr.push(data.status[key]);
                    colorsArr.push(colors[key]);
                }
            });

            var total = dataArr.reduce(function (a, b) { return a + b; }, 0);

            new Chart(statusCanvas, {
                type: 'doughnut',
                data: {
                    labels: labelsArr,
                    datasets: [{
                        data: dataArr,
                        backgroundColor: colorsArr,
                        borderColor: '#fff',
                        borderWidth: 3,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '62%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { usePointStyle: true, boxWidth: 8, padding: 16, font: { size: 12, weight: '600' } }
                        },
                        tooltip: {
                            backgroundColor: '#0F172A',
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: function (ctx) {
                                    var pct = total ? Math.round(ctx.parsed / total * 100) : 0;
                                    return ' ' + ctx.label + ': ' + ctx.parsed + ' pedidos (' + pct + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }
    });
})();
