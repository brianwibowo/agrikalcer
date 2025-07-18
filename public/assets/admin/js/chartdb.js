let currentYear = 2024;
let currentMonth = 3; // April (0-based index)

const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

document.getElementById('year').innerText = currentYear;
document.getElementById('month').innerText = monthNames[currentMonth];

function generateDays(year, month) {
    const daysContainer = document.getElementById('days');
    daysContainer.innerHTML = ''; // Clear previous days

    const daysInMonth = new Date(year, month + 1, 0).getDate();
    for (let i = 1; i <= daysInMonth; i++) {
        const dayElement = document.createElement('span');
        dayElement.innerText = i;
        dayElement.classList.add('day'); // Add base day class

        dayElement.addEventListener('click', function () {
            document.querySelectorAll('.days-grid span').forEach(day => day.classList.remove('active'));
            dayElement.classList.add('active');

            const selectedDate = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            updateChart(selectedDate);
        });

        daysContainer.appendChild(dayElement);
    }
}

// Node selection
document.querySelectorAll('.node-btn').forEach(button => {
    button.addEventListener('click', function () {
        document.querySelectorAll('.node-btn').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
        this.style.backgroundColor = '#fec015'; // Active color
        this.style.color = '#ffffff';

        const selectedDate = document.querySelector('.day.active')?.dataset.date;
        if (selectedDate) {
            updateChart(selectedDate);
        }
    });
});

// Generate initial days for the current month
generateDays(currentYear, currentMonth);

document.getElementById('prevYear').addEventListener('click', () => {
    currentYear--;
    document.getElementById('year').innerText = currentYear;
    generateDays(currentYear, currentMonth);
});

document.getElementById('nextYear').addEventListener('click', () => {
    currentYear++;
    document.getElementById('year').innerText = currentYear;
    generateDays(currentYear, currentMonth);
});

document.getElementById('prevMonth').addEventListener('click', () => {
    currentMonth = (currentMonth - 1 + 12) % 12;
    document.getElementById('month').innerText = monthNames[currentMonth];
    generateDays(currentYear, currentMonth);
});

document.getElementById('nextMonth').addEventListener('click', () => {
    currentMonth = (currentMonth + 1) % 12;
    document.getElementById('month').innerText = monthNames[currentMonth];
    generateDays(currentYear, currentMonth);
});

// Update chart based on selected date, node, and sensor
function updateChart(selectedDate) {
    const selectedNode = document.querySelector('.node-btn.active')?.dataset.node || 1;
    const selectedSensor = document.getElementById('sensorSelect').value;

    $.ajax({
        url: '/admin/dashboard/fetchData',
        method: 'GET',
        data: {
            node: selectedNode,
            sensor: selectedSensor,
            date: selectedDate,
        },
        success: function (response) {
            // Debugging: Cek respons dari server
            console.log('Response:', response);
    
            if (response.labels.length > 0) {
                chart.data.labels = response.labels;
                chart.data.datasets = [{
                    label: `${selectedSensor} data`,
                    data: response.values,
                    borderColor: '#4c74dc',
                    fill: false,
                }];
                chart.update();
            } else {
                console.log('No data available for the selected parameters.');
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
        }
    });    
}
