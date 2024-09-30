<?php 
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use WP_Pembinaan\Services\Utils;

// Inisialisasi kelas Utils
$utils = new Utils();

// function enqueue_dashboard_styles() {
//   wp_enqueue_style('dashboard-styles', plugins_url('/assets/css/style.css', __FILE__), array(), '1.0.0', 'all');
// }
// add_action('wp_enqueue_scripts', 'enqueue_dashboard_styles'); // Untuk frontend



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papan Notifikasi</title>
    <?php wp_head(); ?>
</head>
<style>
  html{
      height: 100vh !important;
      width: 100vw;
      overflow: hidden;
      margin: 0 !important;
      padding: 0;
  }
  body {
      background: linear-gradient(to bottom right, #4B4C51, #203D47);
      height: 100vh !important;
      width: 100vw;
      color: white;
      font-family: Arial, sans-serif;
      padding-left:10px;
      margin: 0 !important;
  }
  h1, h3 {
      margin: 0;
  }
  canvas{
      color:white !important;
  }
</style>
<body>
    <div class="header">
        <h1>Papan Kontrol Pembinaan</h1>
        <h3>Kejaksaan Negeri Maluku Tengah</h3>
        <!-- Clock for Seoul GMT+9 -->
    </div>
    <div class="container">
        <!-- Timeline container -->
        <div class="timeline">
            <?php 
               $today = date('d - m - Y'); // Format today's date to match the date format in your data
              foreach ($grouped_notifications as $date => $types): ?>
                <div class="timeline-item">
                    <span class="timeline-date"><?php echo $date; ?></span>
                    <div class="timeline-content <?php echo ($date === $today) ? 'pulse' : ''; ?>">
                      <?php foreach ($types as $type => $details): ?>
                              <span class="timeline-jenis"><?php echo str_replace('-', ' ', ucfirst($type)); ?></span>
                              <ul>
                                  <?php foreach ($details as $detail): ?>
                                      <li>
                                          <span style="font-weight:600"><?= $detail['nama'] ?></span><br>
                                          <?= $detail['deskripsi'] ?>
                                      </li>
                                  <?php endforeach; ?>
                              </ul>
                      <?php endforeach; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

        <div class="calendar-container">
            <h3>Total Pegawai</h3>
            <div style="display:flex;flex-direction:row;gap:10px;">
                <div class="glass">
                        <h5>ASN/ CPNS</h5>
                        <span>
                            <?= $c_pegawai ?> Pegawai
                        </span>
                </div>
                <div class="glass">
                        <h5>PTT</h5>
                        <span>
                          <?= $c_honorer ?> Pegawai
                        </span>
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
                    labels: [
                      'Jaksa', 'Tata Usaha'
                    ],
                    datasets: [{
                        label: '# of Votes',
                        data: [ <?= $c_jaksa ?>, <?= $c_tata_usaha ?>],
                        backgroundColor: ['#3FB67C', '#FF9F40'],
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
