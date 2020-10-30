var template = document.getElementsByClassName('blankComment')[0]
var commentList = document.getElementsByClassName('comments')[0]
commentList = commentList.getElementsByTagName('ul')[0]
var loadMore = document.getElementsByClassName('seeMore')[0]

var visibleComments = 0
var totalComments = getNumOfComments()

//The following functions are prototypes meant to deal with data calls. 
//This was done to keep GUI functionality independent from data call implementation
//============================================= 
function getNumOfComments(){
    var num = 10 //replace with datacall
    if (num == 0){
        loadMore.className = "inactive"
    }
   else{
        document.getElementsByClassName('noComments')[0].className = "hide"
    }   
    return num
}

function getCommentBody(){
    return "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum" //TODO: implement database call maybe?
}

function getCommentDateTime(){
    return "noon or something idk"
}

function getCommentUsername(){
    return "aRandomlySelectedUser " 
}

function getCommentRating(){
    return 11
}
//============================================= 

function loadComment(){
    var comment = [getCommentUsername(), getCommentDateTime(), getCommentBody(), getCommentRating()]
    return comment
}


//Automatically loads three comments when the page loads
for (var i = 0; i < 3; i++){
    if (visibleComments < totalComments){
         displayNewComment(loadComment())
     }
     if(visibleComments == totalComments){
          loadMore.className = "inactive"
     }   
 }

//Loads three new comments every time "load more" is clicked
loadMore.addEventListener("click", function(){
    for (var i = 0; i < 3; i++){
       if (visibleComments < totalComments){
            displayNewComment(loadComment())
        }
        if(visibleComments == totalComments){
             loadMore.className = "inactive"
        }   
    }
})

//Adds a new li to the comment list containing html for the new comment
function displayNewComment(comment){
    var newComment = template  
    //The newComment variable is for readability purposes only. It is not necessary for functionality.
    newComment.getElementsByClassName('username')[0].innerHTML = comment[0]
    newComment.getElementsByTagName('p')[0].innerHTML = comment[2]
    commentList.innerHTML = commentList.innerHTML + "<li>" + newComment.innerHTML + "</li>"  
    //New comments are created without the 'blankComment' tag. This allows them to display.
    visibleComments++
}
