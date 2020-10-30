var attTemplate = document.getElementsByClassName('blankAttendee')[0]
var attendeeList = attTemplate.parentElement
var showMore = attendeeList.parentElement.getElementsByClassName('loadMore')[0]

var visibleAtts = 0
var totalAtts = getNumOfAtts()

var curattendee = ["hypotheticalAttendee"] // Adding extra information, like status or number of guests per user, could be a stretch goal


function getNumOfAtts(){
    var num = 120 //replace with datacall
    if (num == 0){
        showMore.className = "inactive"
    }
   else{
        document.getElementsByClassName('noAtts')[0].className = "hide"
    }   
    return num
}


//Loads 20 attendees automatically
for (var i = 0; i < 20; i++){
    if (visibleAtts < totalAtts){
         displayNewAttendee(curattendee)
     }
     if(visibleAtts == totalAtts){
          showMore.className = "inactive"
     }   
 }

//Loads an additional 20 attendees when "show more" is clicked
showMore.addEventListener("click", function(){
    for (var i = 0; i < 20; i++){
       if (visibleAtts < totalAtts){
            displayNewAttendee(curattendee)
        }
        if(visibleAtts == totalAtts){
             showMore.className = "inactive"
        }   
    }
})

//Displays the next attendee
function displayNewAttendee(attendee){
    attTemplate.getElementsByClassName('username')[0].innerHTML = attendee[0]
    attendeeList.innerHTML = attendeeList.innerHTML + "<li>" + attTemplate.innerHTML + "</li>" 
    console.log(attTemplate)
    visibleAtts++
}
