document.addEventListener('DOMContentLoaded', function() {
    // Get data from HTML data attributes
    const chartContainer = document.getElementById('chart-container');
    
    if (!chartContainer) {
        console.error('Chart container not found');
        return;
    }

    try {
        const dailyData = JSON.parse(chartContainer.dataset.daily);
        const weeklyData = JSON.parse(chartContainer.dataset.weekly);
        const monthlyData = JSON.parse(chartContainer.dataset.monthly);
        const yearlyData = JSON.parse(chartContainer.dataset.yearly);

        // Store raw data for later use
        const rawDailyData = dailyData;
        const rawWeeklyData = weeklyData;
        const rawMonthlyData = monthlyData;
        const rawYearlyData = yearlyData;

        // Function to process daily data
        function processDailyData() {
            const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const dailyWasteData = new Array(7).fill(0);
            const dailyLittererData = new Array(7).fill(0);

            rawDailyData.forEach(item => {
                const dayIndex = item.day_order - 1;
                if (dayIndex >= 0 && dayIndex < 7) {
                    dailyWasteData[dayIndex] = parseInt(item.waste_count) || 0;
                    dailyLittererData[dayIndex] = parseInt(item.litterer_count) || 0;
                }
            });

            return {
                labels: dayNames,
                datasets: [{
                    label: 'Waste',
                    data: dailyWasteData,
                    backgroundColor: '#facc15',
                    borderRadius: 4
                },
                {
                    label: 'Litterer',
                    data: dailyLittererData,
                    backgroundColor: '#4ade80',
                    borderRadius: 4
                }]
            };
        }

        // Function to process weekly data
        function processWeeklyData() {
            const weeklyLabels = [];
            const weeklyWasteData = new Array(8).fill(0);
            const weeklyLittererData = new Array(8).fill(0);

            // Create date ranges for the last 8 weeks
            const today = new Date();
            const sunday = new Date(today);
            sunday.setDate(today.getDate() - today.getDay()); // Get last Sunday
            
            // Create week ranges and labels
            const weekRanges = [];
            for (let i = 7; i >= 0; i--) {
                const weekStart = new Date(sunday);
                weekStart.setDate(sunday.getDate() - (i * 7));
                
                const weekEnd = new Date(weekStart);
                weekEnd.setDate(weekStart.getDate() + 6);
                
                // Store the week range for matching
                weekRanges.push({ start: new Date(weekStart), end: new Date(weekEnd) });
                
                // Format label (e.g., "Feb 1-7")
                const startMonth = weekStart.toLocaleString('default', { month: 'short' });
                const endMonth = weekEnd.toLocaleString('default', { month: 'short' });
                
                if (startMonth === endMonth) {
                    weeklyLabels.push(`${startMonth} ${weekStart.getDate()}-${weekEnd.getDate()}`);
                } else {
                    weeklyLabels.push(`${startMonth} ${weekStart.getDate()}-${endMonth} ${weekEnd.getDate()}`);
                }
            }

            // Fill weekly data from database - using year and week_number
            rawWeeklyData.forEach(item => {
                // Create a date from year and week number (approximate)
                const year = parseInt(item.year);
                const weekNumber = parseInt(item.week_number);
                
                // Create a date for the first day of that week
                const janFirst = new Date(year, 0, 1);
                const daysToFirstMonday = janFirst.getDay() === 0 ? 1 : 8 - janFirst.getDay();
                const firstMonday = new Date(janFirst);
                firstMonday.setDate(janFirst.getDate() + daysToFirstMonday);
                
                const reportDate = new Date(firstMonday);
                reportDate.setDate(firstMonday.getDate() + (weekNumber - 1) * 7);
                
                // Find which week range this date falls into
                for (let i = 0; i < weekRanges.length; i++) {
                    if (reportDate >= weekRanges[i].start && reportDate <= weekRanges[i].end) {
                        weeklyWasteData[i] += parseInt(item.waste_count) || 0;
                        weeklyLittererData[i] += parseInt(item.litterer_count) || 0;
                        break;
                    }
                }
            });

            return {
                labels: weeklyLabels,
                datasets: [{
                    label: 'Waste',
                    data: weeklyWasteData,
                    backgroundColor: '#facc15',
                    borderRadius: 4
                },
                {
                    label: 'Litterer',
                    data: weeklyLittererData,
                    backgroundColor: '#4ade80',
                    borderRadius: 4
                }]
            };
        }

        // Function to process monthly data
        function processMonthlyData() {
            const monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
            const monthlyWasteData = new Array(12).fill(0);
            const monthlyLittererData = new Array(12).fill(0);

            rawMonthlyData.forEach(item => {
                const monthIndex = item.month - 1;
                if (monthIndex >= 0 && monthIndex < 12) {
                    monthlyWasteData[monthIndex] = parseInt(item.waste_count) || 0;
                    monthlyLittererData[monthIndex] = parseInt(item.litterer_count) || 0;
                }
            });

            return {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Waste',
                    data: monthlyWasteData,
                    backgroundColor: '#facc15',
                    borderRadius: 4
                },
                {
                    label: 'Litterer',
                    data: monthlyLittererData,
                    backgroundColor: '#4ade80',
                    borderRadius: 4
                }]
            };
        }

        // Function to process yearly data
        function processYearlyData() {
            const yearlyLabels = [];
            const yearlyWasteData = [];
            const yearlyLittererData = [];

            const currentYear = new Date().getFullYear();
            for (let i = 4; i >= 0; i--) {
                yearlyLabels.push((currentYear - i).toString());
            }

            yearlyLabels.forEach(year => {
                const yearData = rawYearlyData.find(item => item.year == year);
                yearlyWasteData.push(yearData ? parseInt(yearData.waste_count) : 0);
                yearlyLittererData.push(yearData ? parseInt(yearData.litterer_count) : 0);
            });

            return {
                labels: yearlyLabels,
                datasets: [{
                    label: 'Waste',
                    data: yearlyWasteData,
                    backgroundColor: '#facc15',
                    borderRadius: 4
                },
                {
                    label: 'Litterer',
                    data: yearlyLittererData,
                    backgroundColor: '#4ade80',
                    borderRadius: 4
                }]
            };
        }

        // Calculate max value for Y-axis with some padding
        function calculateMaxValue(data) {
            const maxValue = Math.max(...data);
            return Math.ceil(maxValue * 1.1);
        }

        // Initialize Chart
        const ctx = document.getElementById('engagementChart').getContext('2d');
        
        // Get initial DAILY data
        const initialDailyData = processDailyData();
        const dailyMax = calculateMaxValue([...initialDailyData.datasets[0].data, ...initialDailyData.datasets[1].data]);

        const chartConfig = {
            type: 'bar',
            data: initialDailyData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 800,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 10,
                        cornerRadius: 4,
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw} reports`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: dailyMax,
                        ticks: {
                            precision: 0,
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false
                }
            }
        };

        const engagementChart = new Chart(ctx, chartConfig);

        // Time Filter Change Event
        document.getElementById('timeFilter').addEventListener('change', (e) => {
            const timeFrame = e.target.value;
            
            let newData, newMax;
            
            if (timeFrame === 'daily') {
                newData = processDailyData();
                newMax = calculateMaxValue([...newData.datasets[0].data, ...newData.datasets[1].data]);
            } else if (timeFrame === 'weekly') {
                newData = processWeeklyData();
                newMax = calculateMaxValue([...newData.datasets[0].data, ...newData.datasets[1].data]);
            } else if (timeFrame === 'month') {
                newData = processMonthlyData();
                newMax = calculateMaxValue([...newData.datasets[0].data, ...newData.datasets[1].data]);
            } else {
                newData = processYearlyData();
                newMax = calculateMaxValue([...newData.datasets[0].data, ...newData.datasets[1].data]);
            }
            
            // Update chart with new data
            engagementChart.data.labels = newData.labels;
            engagementChart.data.datasets = newData.datasets;
            engagementChart.options.scales.y.max = newMax;
            
            engagementChart.update();
        });

        // Add hover effects to chart bars
        const chartCanvas = document.getElementById('engagementChart');
        if (chartCanvas) {
            chartCanvas.style.cursor = 'pointer';
        }
        
        // Add resize event to handle responsive chart
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                if (engagementChart) {
                    engagementChart.resize();
                }
            }, 250);
        });

        // Optional: Add export functionality
        const exportButton = document.getElementById('exportChart');
        if (exportButton) {
            exportButton.addEventListener('click', function() {
                const imageLink = document.createElement('a');
                const canvas = document.getElementById('engagementChart');
                if (canvas) {
                    imageLink.href = canvas.toDataURL('image/png', 1.0);
                    imageLink.download = 'user-engagement-chart.png';
                    imageLink.click();
                }
            });
        }

    } catch (error) {
        console.error('Error parsing chart data:', error);
    }
});