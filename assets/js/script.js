/* 
 * This is a simple script that just removes the notifications on click.
 * 
 * In practice, you should be using something cooler like jQuery, mootools
 * or backbone, I'm using raw JavaScript just to keep the assets directory as clean
 * as possible.
 */
window.addEventListener("load", function(){
    var notifications = document.getElementById("Notifications").childNodes;

    for(var i in notifications){
        notifications[i].onclick = closeNotification;
    }

    function closeNotification(){
        this.parentNode.removeChild(this);
    }
}, false);