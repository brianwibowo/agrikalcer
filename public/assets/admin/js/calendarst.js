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

        // Event listener untuk klik
        dayElement.addEventListener('click', function() {
            // Hapus kelas 'active' dari semua elemen hari
            const allDays = document.querySelectorAll('.days-grid span');
            allDays.forEach(day => day.classList.remove('active'));

            // Tambahkan kelas 'active' pada hari yang diklik
            dayElement.classList.add('active');
        });

        daysContainer.appendChild(dayElement);
    }
}

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
