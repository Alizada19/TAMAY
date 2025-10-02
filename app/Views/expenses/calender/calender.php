
<div id="listCon" style="width:80%; margin-left:10%; margin-right:10%;margin-bottom:10%;">
<div id="calendar"></div>
</div>		
<script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
    <script>

document.addEventListener('DOMContentLoaded', function () {
    // Parse events from PHP backend, including the 'order' field
    var mevents = <?= json_encode($events) ?>;

    // Debug: Log events to ensure 'order' exists
    //console.log("Before sorting:", mevents);

    // Manually sort events by the 'order' field
    mevents.sort(function (a, b) {
        return a.order - b.order; // Sort in ascending order based on 'order'
    });

    // Debug: Log events after sorting
    //console.log("After sorting:", mevents);

    // Initialize FullCalendar with the sorted events
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        contentHeight: 600,
        aspectRatio: 1.8,
        events: mevents,  // Use the manually sorted events
        eventOrder: function(a, b) { // This function ensures sorting doesn't override the order
            return a.order - b.order; // Compare based on 'order'
        },
		eventContent: function(info) {
			var tooltip = info.event.extendedProps.tooltip;
			return {
				html: '<div title="' + tooltip + '">' + info.event.title + '</div>'
			};
		}
    });

    // Render the calendar
    calendar.render();
});



</script>