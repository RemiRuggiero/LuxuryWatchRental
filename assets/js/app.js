// Import des fichiers CSS
import '../css/app.scss';
import '../css/register.scss';
import '../css/index.scss';
import '../css/login.scss';
import '../css/catalogue.scss';
import '../css/account.scss';
import '../css/show.scss';



// Transition de page

// Page: "show.html.twig" -> Gestion transition image du carousel
$('.carousel').carousel({
  interval: 6200
})

// Page: "show.html.twig" -> Calendrier DateRangePicker
$(function() {

  var date = new Date();
  var currentMonth = date.getMonth();
  var currentDate = date.getDate();
  var currentYear = date.getFullYear();
  
  var btn = document.getElementById('btn');
  var daterange = document.getElementById('daterange');

  daterange.addEventListener('click', function(e){
    e.preventDefault;
    console.log(daterange.value);
  })
  

  $('input[name="daterange"]').daterangepicker({
    opens: 'right',
    minDate: new Date(currentYear, currentMonth, currentDate)
    
  }, function(start, end, label) {
     console.log("A new date selection was made: " + start.format('dd/MMMM/y') + ' to ' + end.format('dd/MMMM/y'));
  });
  
  


});