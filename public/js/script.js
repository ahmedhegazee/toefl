window.onload=function(){
    window.addEventListener('beforeunload', (event) => {
        // Cancel the event as stated by the standard.
        event.preventDefault();

        window.location.replace(location.hostname+":8000/logout");
        // window.location.href = location.hostname+":8000/logout";
        // Chrome requires returnValue to be set.

        event.returnValue = '';
    });
};
