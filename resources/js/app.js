import './bootstrap';
import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';
import Swal from 'sweetalert2';

// Flatpickr
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

// FullCalendar
import { Calendar } from '@fullcalendar/core';

window.ApexCharts = ApexCharts;
window.flatpickr = flatpickr;
window.FullCalendar = Calendar;
window.Swal = Swal;

// window.Alpine = Alpine;
// Alpine.start();

document.addEventListener('DOMContentLoaded', () => {

    // Map
    if (document.querySelector('#mapOne')) {
        import('./components/map').then(module => module.initMap());
    }

    // Charts
    if (document.querySelector('#chartOne')) {
        import('./components/chart/chart-1').then(m => m.initChartOne());
    }
    if (document.querySelector('#chartTwo')) {
        import('./components/chart/chart-2').then(m => m.initChartTwo());
    }
    if (document.querySelector('#chartThree')) {
        import('./components/chart/chart-3').then(m => m.initChartThree());
    }
    if (document.querySelector('#chartSix')) {
        import('./components/chart/chart-6').then(m => m.initChartSix());
    }
    if (document.querySelector('#chartEight')) {
        import('./components/chart/chart-8').then(m => m.initChartEight());
    }
    if (document.querySelector('#chartThirteen')) {
        import('./components/chart/chart-13').then(m => m.initChartThirteen());
    }

    // Calendar
    if (document.querySelector('#calendar')) {
        import('./components/calendar-init').then(m => m.calendarInit());
    }
});
