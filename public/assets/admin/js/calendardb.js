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
            document.getElementById('generateReport').setAttribute('data-date', selectedDate);
        });

        daysContainer.appendChild(dayElement);
    }
}

// Menambahkan event listener untuk setiap tombol Node
document.querySelectorAll('.node-btn').forEach(button => {
    button.addEventListener('click', function () {
        // Menghapus kelas active dari semua tombol
        document.querySelectorAll('.node-btn').forEach(btn => btn.classList.remove('active'));

        // Menambahkan kelas active ke tombol yang diklik
        this.classList.add('active');

        // Menambahkan perubahan warna
        this.style.backgroundColor = '#fec015'; // Warna aktif
        this.style.color = '#ffffff';
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
