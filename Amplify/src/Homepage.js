var template = document.getElementById('thumbnail_template');
var eventpane = document.getElementById('eventpane');
var footer = document.getElementsByTagName('footer')[0];
var visibleEvents = [] /*array that holds all currently visible events*/
var numvisible = 0;
var maxEventsOnPage = getNumberOfEvents();


//Function prototypes for data call functions
//=============================================
function getNumberOfEvents(){
    return 60;
}

function getEventTitle(){
    return "User-generated Event";
}

function getImageURL(){
    return "empty_event.png";
}
//=============================================


/*Draws a new event thumbnail on the screen*/
function loadNewEvent(){
    var newEvent = document.createElement('div')
    var curEvent = eventpane.appendChild(newEvent)
    curEvent.className = "thumbnail"
    curEvent.innerHTML = template.innerHTML
    console.log(curEvent)
    curEvent.getElementsByClassName('eventTitle')[0].innerHTML = getEventTitle()
    curEvent.getElementsByTagName('img').src = getImageURL()
    numvisible++
    visibleEvents.push(curEvent)
}

//Loads 8 events automatically on startup
for (var i = 0; i < 8; i++){
    if (numvisible == maxEventsOnPage){
        break;
    }
    loadNewEvent()
}


//Loads an additional 8 events when the page footer enters the screen
document.addEventListener("DOMContentLoaded", () => {
    let options = {
        root: null,
        rootMargins: "0px",
        threshold: 0.25
    };
    let observer = new IntersectionObserver(onPage, options);
    observer.observe(footer)
});
function onPage(element, observer){
    if (element[0].isIntersecting){
        for(var i = 0; i < 8; i++){
            if (numvisible == maxEventsOnPage){
                break;
            }
            loadNewEvent();
        }
        //Ends the observer if all events have been loaded
        if (numvisible == maxEventsOnPage){
            observer.unobserve(footer)
            document.getElementsByTagName('h3')[0].className = '';
        }
    }

}