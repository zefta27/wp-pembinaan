<?php 
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use WP_Pembinaan\Services\Utils;

// Inisialisasi kelas Utils
$utils = new Utils();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papan Notifikasi</title>
    <style>
        html{
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }
        body {
            background: linear-gradient(to bottom right, #4B4C51, #203D47);
            height: 100vh;
            width: 100vw;
            color: white;
            font-family: Arial, sans-serif;
            padding-left:10px;
        }

        .header {
            text-align: center;
            padding: 20px;
        }

        h1, h3 {
            margin: 0;
        }
        canvas{
            color:white !important;
        }
        .clock {
            font-size: 24px;
            margin-top: 10px;
        }

        /* Timeline container */
        .timeline {
            flex-grow: 3 !important;
            position: relative;
            max-width: 900px;
            margin: 20px auto;
            padding-left: 40px; /* Increase padding to avoid overlap with the line */
        }

        /* Each timeline item */
        .timeline-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px; /* Adjust this if the space is too much */
            position: relative;
            padding-top: 15px; /* Add padding to top for visual alignment */
        }
        .calendar-container{
            flex-grow: 2 !important;
        }

        /* Circle on the left side */
        .timeline-item::before {
            content: '';
            width: 12px;
            height: 12px;
            background-color: #fff;
            border: 2px solid #FF9F3F ;
            border-radius: 50%;
            position: absolute;
            left: -50px; /* Adjusted for visual correctness */
            top: 40px; /* Adjust this to position the circle correctly */
        }

        /* Vertical line */
        .timeline-item::after {
            content: '';
            position: absolute;
            left: -43px; /* Position the line left of the circle */
            top: 50px; /* Start a bit lower to align with the middle of the circle */
            width: 2px;
            height: calc(100% + 10px); /* Extend the line to connect to the next circle */
            background-color: #FF9F3F ;
            z-index: -1;
        }

        /* Last item should not have the after line */
        .timeline-item:last-child::after {
            display: none;
        }

        /* The actual card */
        .timeline-content {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding:30px 20px;
            margin-left: -15x;
            box-shadow: 0 4px 8px rgba(128, 128, 128, 0.5);
            width: 100%;
        }

        .timeline-content h4 {
            margin: 0 0 10px 0;
            font-size: 20px;
        }

        .timeline-content p {
            margin: 5px 0;
            font-size: 14px;
        }
        .timeline-date{
            position: absolute;
            background-color: #FF9F3F;
            padding: 6px 10px 6px 10px;
            border-radius: 5px;
            top: 2px;
            left: -2px;
        }
        .timeline-tipe{
            background-color: #EBECEE;
            padding: 5px 14px;
            border-radius: 14px;
            width: fit-content;
            position: absolute;
            bottom: 10px;
            right: 12px;
            color: #453c3c;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        /* container */
        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        .timeline, .calendar-container {
            margin: 0 10px; /* Add some space between them */
        }

        .calendar-container {
            display: flex;
            align-items: center;
            flex-direction: column;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            width: 300px;
            margin: 20px;
            box-shadow: 0 4px 8px rgba(128, 128, 128, 0.5);
        }

      
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;200;300;400;500;600;700&display=swap');

        :root {
            --calendar-bg-color: rgba(255, 255, 255, 0.2);
            --calendar-font-color: black;
            --weekdays-border-bottom-color: #404040;
            --calendar-date-hover-color: #505050;
            --calendar-current-date-color: #1b1f21;
            --calendar-today-color: linear-gradient(to bottom, #03a9f4, #2196f3);
            --calendar-today-innerborder-color: transparent;
            --calendar-nextprev-bg-color: transparent;
            --next-prev-arrow-color : #FFF;
            --calendar-border-radius: 16px;
            --calendar-prevnext-date-color: #484848
        }

        * {
            padding: 0;
            margin: 0;
        }

        .calendar {
            font-family: 'IBM Plex Sans', sans-serif;
            position: relative;
            max-width: 400px; /*change as per your design need */
            min-width: 320px;
            /* background: var(--calendar-bg-color); */
            background: rgba(255, 255, 255, 0.2); 
            color: black;
            margin: 20px auto;
            box-sizing: border-box;
            overflow: hidden;
            font-weight: normal;
            border-radius: var(--calendar-border-radius);
        }

        .calendar-inner {
            padding: 10px 10px;
        }

        .calendar .calendar-inner .calendar-body {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
        }

        .calendar .calendar-inner .calendar-body div {
            padding: 4px;
            min-height: 30px;
            line-height: 30px;
            border: 1px solid transparent;
            margin: 10px 2px 0px;
        }

        .calendar .calendar-inner .calendar-body div:nth-child(-n+7) {
            border: 1px solid transparent;
            border-bottom: 1px solid var(--weekdays-border-bottom-color);
        }

        .calendar .calendar-inner .calendar-body div:nth-child(-n+7):hover {
            border: 1px solid transparent;
            border-bottom: 1px solid var(--weekdays-border-bottom-color);
        }

        .calendar .calendar-inner .calendar-body div>a {
            color: var(--calendar-font-color);
            text-decoration: none;
            display: flex;
            justify-content: center;
        }

        .calendar .calendar-inner .calendar-body div:hover {
            border: 1px solid var(--calendar-date-hover-color);
            border-radius: 4px;
        }

        .calendar .calendar-inner .calendar-body div.empty-dates:hover {
            border: 1px solid transparent;
        }

        .calendar .calendar-inner .calendar-controls {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
        }

        .calendar .calendar-inner .calendar-today-date {
            display: grid;
            text-align: center;
            cursor: pointer;
            margin: 3px 0px;
            background: white;
            /* background: var(--calendar-current-date-color); */
            padding: 8px 0px;
            border-radius: 10px;
            width: 80%;
            margin: auto;
        }

        .calendar .calendar-inner .calendar-controls .calendar-year-month {
            display: flex;
            min-width: 100px;
            justify-content: space-evenly;
            align-items: center;
        }

        .calendar .calendar-inner .calendar-controls .calendar-next {
            text-align: right;
        }

        .calendar .calendar-inner .calendar-controls .calendar-year-month .calendar-year-label,
        .calendar .calendar-inner .calendar-controls .calendar-year-month .calendar-month-label {
            font-weight: 500;
            font-size: 20px;
        }

        .calendar .calendar-inner .calendar-body .calendar-today {
            background: var(--calendar-today-color);
            border-radius: 4px;
        }

        .calendar .calendar-inner .calendar-body .calendar-today:hover {
            border: 1px solid transparent;
        }

        .calendar .calendar-inner .calendar-body .calendar-today a {
            outline: 2px solid var(--calendar-today-innerborder-color);
        }

        .calendar .calendar-inner .calendar-controls .calendar-next a,
        .calendar .calendar-inner .calendar-controls .calendar-prev a {
            color: var(--calendar-font-color);
            font-family: arial, consolas, sans-serif;
            font-size: 26px;
            text-decoration: none;
            padding: 4px 12px;
            display: inline-block;
            /* background: var(--calendar-nextprev-bg-color); */
            background: var(--calendar-nextprev-bg-color);
            margin: 10px 0 10px 0;
        }

        .calendar .calendar-inner .calendar-controls .calendar-next a svg,
        .calendar .calendar-inner .calendar-controls .calendar-prev a svg {
            height: 20px;
            width: 20px;
        }

        .calendar .calendar-inner .calendar-controls .calendar-next a svg path,
        .calendar .calendar-inner .calendar-controls .calendar-prev a svg path{
            fill: var(--next-prev-arrow-color);
        }

        .calendar .calendar-inner .calendar-body .prev-dates,
        .calendar .calendar-inner .calendar-body .next-dates {
            color: var(--calendar-prevnext-date-color);
        }

        .calendar .calendar-inner .calendar-body .prev-dates:hover,
        .calendar .calendar-inner .calendar-body .next-dates:hover {
        border: 1px solid transparent;
        pointer-events: none;
        }
        .clock {
            max-width: 700px !important;
            margin-top: 10px;
            display: inline-block;
            padding: 20px 40px;
            background: rgba(255, 255, 255, 0.2); /* Warna transparan */
            border-radius: 15px;
            backdrop-filter: blur(10px); /* Efek blur seperti kaca beku */
            -webkit-backdrop-filter: blur(10px); /* Cross-browser support */
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: white;
            font-family: 'Arial', sans-serif;
            letter-spacing: 2px;
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .clock:hover {
            transform: scale(1.05); /* Sedikit memperbesar saat di-hover */
        }
        .glass {
            padding: 14px 20px;
            background: rgba(255, 255, 255, 0.2);
            font-size: 18px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: white;
            margin-top: 10px;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>
    <div class="header">
        <h1>Papan Kontrol Pembinaan</h1>
        <h3>Kejaksaan Negeri Maluku Tengah</h3>
        <!-- Clock for Seoul GMT+9 -->
    </div>
    <div class="container">
        <!-- Timeline container -->
        <div class="timeline">
            <?php if (!empty($notifikasi)): ?>
                <?php foreach ($notifikasi as $notif): ?>
                    <div class="timeline-item">
                        <span class="timeline-date">
                            <?php echo esc_html($utils->formatTanggal($notif->tanggal)); ?>
                        </span>
                        <div class="timeline-content">
                            <h4><?php echo esc_html($notif->nama); ?></h4>
                            <p><?php echo esc_html($notif->deskripsi); ?></p>
                            <span class="timeline-tipe">
                                <?php echo esc_html($notif->tipe); ?>
                            </span>
                            
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Tidak ada notifikasi yang tersedia.</p>
            <?php endif; ?>
        </div>
        <div class="calendar-container">
            <h3>Total Pegawai</h3>
            <div style="display:flex;flex-direction:row;gap:10px;">
                <div class="glass">
                        <h5>ASN/ CPNS</h5>
                        38 Pegawai
                </div>
                <div class="glass">
                        <h5>PTT</h5>
                        15 Pegawai
                </div>
            </div>
           
            <h3>EiS Pegawai</h3>
            <div>
                <canvas id="myChart" style="color:white !important;"></canvas>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

            <script>
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Jaksa', 'Tata Usaha'],
                    datasets: [{
                        label: '# of Votes',
                        data: [12, 24],
                        backgroundColor: ['#4BC0C0', '#FF9F40'],
                        borderWidth: 0 // Menghilangkan border
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white', // Ubah warna label legend menjadi putih
                                font: {
                                    size: 14 // Ukuran font label legend
                                }
                            }
                        },
                        tooltip: {
                            enabled: true
                        },
                        datalabels: {
                            color: 'white', // Warna teks di dalam chart
                            font: {
                                weight: 'bold', // Membuat teks lebih tebal
                                size: 14 // Ukuran font label dalam chart
                            },
                            formatter: (value, ctx) => {
                                let total = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                let percentage = (value / total * 100).toFixed(1) ;
                                return value; // Tampilkan persentase
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels] // Memuat plugin ChartDataLabels
            });

            </script>
        </div>
        <!-- Calendar container -->
        <div class="calendar-container">
          <div class="clock" id="clock"></div>
          <!-- <?php // echo generateCalendar(date('n'), date('Y')); ?> -->
          <div class="calendar"></div>

        </div>
       
    </div>

    <div class="footer">
        <p>Powered by WP Pembinaan</p>
    </div>

    <script>
        // Function to update clock for Seoul (GMT+9)
        function updateClock() {
            var now = new Date();
            // Convert to Seoul Time (GMT+9)
            var options = {
                timeZone: 'Asia/Seoul',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };
            var formatter = new Intl.DateTimeFormat([], options);
            document.getElementById('clock').textContent = formatter.format(now);
        }

        // Update the clock every second
        setInterval(updateClock, 1000);

        // Run clock immediately on load
        updateClock();
    </script>
    <script>
        function CalendarControl() {
    const calendar = new Date();
    const calendarControl = {
      localDate: new Date(),
      prevMonthLastDate: null,
      calWeekDays: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
      calMonthName: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec"
      ],
      daysInMonth: function (month, year) {
        return new Date(year, month, 0).getDate();
      },
      firstDay: function () {
        return new Date(calendar.getFullYear(), calendar.getMonth(), 1);
      },
      lastDay: function () {
        return new Date(calendar.getFullYear(), calendar.getMonth() + 1, 0);
      },
      firstDayNumber: function () {
        return calendarControl.firstDay().getDay() + 1;
      },
      lastDayNumber: function () {
        return calendarControl.lastDay().getDay() + 1;
      },
      getPreviousMonthLastDate: function () {
        let lastDate = new Date(
          calendar.getFullYear(),
          calendar.getMonth(),
          0
        ).getDate();
        return lastDate;
      },
      navigateToPreviousMonth: function () {
        calendar.setMonth(calendar.getMonth() - 1);
        calendarControl.attachEventsOnNextPrev();
      },
      navigateToNextMonth: function () {
        calendar.setMonth(calendar.getMonth() + 1);
        calendarControl.attachEventsOnNextPrev();
      },
      navigateToCurrentMonth: function () {
        let currentMonth = calendarControl.localDate.getMonth();
        let currentYear = calendarControl.localDate.getFullYear();
        calendar.setMonth(currentMonth);
        calendar.setYear(currentYear);
        calendarControl.attachEventsOnNextPrev();
      },
      displayYear: function () {
        let yearLabel = document.querySelector(".calendar .calendar-year-label");
        yearLabel.innerHTML = calendar.getFullYear();
      },
      displayMonth: function () {
        let monthLabel = document.querySelector(
          ".calendar .calendar-month-label"
        );
        monthLabel.innerHTML = calendarControl.calMonthName[calendar.getMonth()];
      },
      selectDate: function (e) {
        console.log(
          `${e.target.textContent} ${
            calendarControl.calMonthName[calendar.getMonth()]
          } ${calendar.getFullYear()}`
        );
      },
      plotSelectors: function () {
        document.querySelector(
          ".calendar"
        ).innerHTML += `<div class="calendar-inner"><div class="calendar-controls">
          <div class="calendar-prev"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 128 128"><path fill="#666" d="M88.2 3.8L35.8 56.23 28 64l7.8 7.78 52.4 52.4 9.78-7.76L45.58 64l52.4-52.4z"/></svg></a></div>
          <div class="calendar-year-month">
          <div class="calendar-month-label"></div>
          <div>-</div>
          <div class="calendar-year-label"></div>
          </div>
          <div class="calendar-next"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 128 128"><path fill="#666" d="M38.8 124.2l52.4-52.42L99 64l-7.77-7.78-52.4-52.4-9.8 7.77L81.44 64 29 116.42z"/></svg></a></div>
          </div>
          <div class="calendar-today-date">Today: 
            ${calendarControl.calWeekDays[calendarControl.localDate.getDay()]}, 
            ${calendarControl.localDate.getDate()}, 
            ${calendarControl.calMonthName[calendarControl.localDate.getMonth()]} 
            ${calendarControl.localDate.getFullYear()}
          </div>
          <div class="calendar-body"></div></div>`;
      },
      plotDayNames: function () {
        for (let i = 0; i < calendarControl.calWeekDays.length; i++) {
          document.querySelector(
            ".calendar .calendar-body"
          ).innerHTML += `<div>${calendarControl.calWeekDays[i]}</div>`;
        }
      },
      plotDates: function () {
        document.querySelector(".calendar .calendar-body").innerHTML = "";
        calendarControl.plotDayNames();
        calendarControl.displayMonth();
        calendarControl.displayYear();
        let count = 1;
        let prevDateCount = 0;
  
        calendarControl.prevMonthLastDate = calendarControl.getPreviousMonthLastDate();
        let prevMonthDatesArray = [];
        let calendarDays = calendarControl.daysInMonth(
          calendar.getMonth() + 1,
          calendar.getFullYear()
        );
        // dates of current month
        for (let i = 1; i < calendarDays; i++) {
          if (i < calendarControl.firstDayNumber()) {
            prevDateCount += 1;
            document.querySelector(
              ".calendar .calendar-body"
            ).innerHTML += `<div class="prev-dates"></div>`;
            prevMonthDatesArray.push(calendarControl.prevMonthLastDate--);
          } else {
            document.querySelector(
              ".calendar .calendar-body"
            ).innerHTML += `<div class="number-item" data-num=${count}><a class="dateNumber" href="#">${count++}</a></div>`;
          }
        }
        //remaining dates after month dates
        for (let j = 0; j < prevDateCount + 1; j++) {
          document.querySelector(
            ".calendar .calendar-body"
          ).innerHTML += `<div class="number-item" data-num=${count}><a class="dateNumber" href="#">${count++}</a></div>`;
        }
        calendarControl.highlightToday();
        calendarControl.plotPrevMonthDates(prevMonthDatesArray);
        calendarControl.plotNextMonthDates();
      },
      attachEvents: function () {
        let prevBtn = document.querySelector(".calendar .calendar-prev a");
        let nextBtn = document.querySelector(".calendar .calendar-next a");
        let todayDate = document.querySelector(".calendar .calendar-today-date");
        let dateNumber = document.querySelectorAll(".calendar .dateNumber");
        prevBtn.addEventListener(
          "click",
          calendarControl.navigateToPreviousMonth
        );
        nextBtn.addEventListener("click", calendarControl.navigateToNextMonth);
        todayDate.addEventListener(
          "click",
          calendarControl.navigateToCurrentMonth
        );
        for (var i = 0; i < dateNumber.length; i++) {
            dateNumber[i].addEventListener(
              "click",
              calendarControl.selectDate,
              false
            );
        }
      },
      highlightToday: function () {
        let currentMonth = calendarControl.localDate.getMonth() + 1;
        let changedMonth = calendar.getMonth() + 1;
        let currentYear = calendarControl.localDate.getFullYear();
        let changedYear = calendar.getFullYear();
        if (
          currentYear === changedYear &&
          currentMonth === changedMonth &&
          document.querySelectorAll(".number-item")
        ) {
          document
            .querySelectorAll(".number-item")
            [calendar.getDate() - 1].classList.add("calendar-today");
        }
      },
      plotPrevMonthDates: function(dates){
        dates.reverse();
        for(let i=0;i<dates.length;i++) {
            if(document.querySelectorAll(".prev-dates")) {
                document.querySelectorAll(".prev-dates")[i].textContent = dates[i];
            }
        }
      },
      plotNextMonthDates: function(){
       let childElemCount = document.querySelector('.calendar-body').childElementCount;
       //7 lines
       if(childElemCount > 42 ) {
           let diff = 49 - childElemCount;
           calendarControl.loopThroughNextDays(diff);
       }

       //6 lines
       if(childElemCount > 35 && childElemCount <= 42 ) {
        let diff = 42 - childElemCount;
        calendarControl.loopThroughNextDays(42 - childElemCount);
       }

      },
      loopThroughNextDays: function(count) {
        if(count > 0) {
            for(let i=1;i<=count;i++) {
                document.querySelector('.calendar-body').innerHTML += `<div class="next-dates">${i}</div>`;
            }
        }
      },
      attachEventsOnNextPrev: function () {
        calendarControl.plotDates();
        calendarControl.attachEvents();
      },
      init: function () {
        calendarControl.plotSelectors();
        calendarControl.plotDates();
        calendarControl.attachEvents();
      }
    };
    calendarControl.init();
  }
  
  const calendarControl = new CalendarControl();
    </script>
</body>
</html>
