let fillQuestionsArray = [], randomFillQuestions, fillQuestion = 0, fillQuestions;
let findQuestionsArray = [], randomFindQuestions, findQuestion = 0, findQuestions;
let isFindQuestions =false;
// let questionsArray = [], randomQuestions, question = 0, questions;
window.onload = function () {
    setTimer();
    fillQuestions = document.getElementsByClassName('fl');
    randomFillQuestions = shuffle(fillNumbersArray(fillQuestions));
    findQuestions = document.getElementsByClassName('fn');
    randomFindQuestions = shuffle(fillNumbersArray(findQuestions));
    // questions = document.getElementsByClassName('question');
    // var numbers = fillNumbersArray(questions);
    // randomQuestions = shuffle(numbers);


    // showNextQuestion(randomQuestions,questions);
    showNextQuestion(randomFillQuestions,fillQuestions,isFindQuestions);
};

function fillNumbersArray(questions) {
    var array = [];
    for (var i = 0; i < questions.length; i++) {
        array.push(i);
    }
    return array;
}

function shuffle(o) {
    for (var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x) ;
    return o;
}

function nextQuestion() {

    if(isFindQuestions===true){
        // hidePrevQuestion(findQuestions);
        showNextQuestion(randomFindQuestions,findQuestions,isFindQuestions);
    }
    else{
        // hidePrevQuestion(fillQuestions);
        showNextQuestion(randomFillQuestions,fillQuestions,isFindQuestions);
    }
    if (fillQuestion === fillQuestions.length ) {
        isFindQuestions=true;
    }

    if(findQuestion === findQuestions.length){

        document.getElementById('submit').setAttribute('class', 'btn btn-primary d-block');
        document.getElementById('next').setAttribute('class', 'btn btn-primary d-none');
    }
}
function hideAllQuestions(name){
    var find=document.getElementsByClassName(name);
    for (var i=0;i<find.length;i++){
        find[i].classList.replace('d-block','d-none');
        find[i].classList.remove('q');
    }
}
function showQuestion(question){
question.classList.replace('d-none','d-block');
question.classList.add('q');
}
function showNextQuestion( randomQuestionsArray,questionsList,mode) {
    hideAllQuestions('fn');
    hideAllQuestions('fl');
    if(mode===true){
        var nextQuestion =randomQuestionsArray[findQuestion];
        findQuestionsArray.push(nextQuestion);
        showQuestion(questionsList[nextQuestion]);
        findQuestion++;
    }
    else{
        var nextQuestion =randomQuestionsArray[fillQuestion];
        fillQuestionsArray.push(nextQuestion);
        showQuestion(questionsList[nextQuestion]);

        fillQuestion++;
    }

    randomizeOptions();
}


function randomizeOptions() {
    var options = [0, 1, 2, 3];
    var option = $('.q .option'),
        parent = option.parent();
    var randomOptions = shuffle(options);
    for (var i = 0; i < 4; i++) {
        parent.append(option[randomOptions[i]]);
        parent.children().remove(option[i]);
    }
}

function setTimer() {
    var countDownDate = new Date();
    var time = document.getElementById('time').value;
    var arr= time.split(':');
    var minutes = parseInt(arr[1]);
    countDownDate.setMinutes(countDownDate.getMinutes() + minutes);
    var hours = parseInt(arr[0]);
    countDownDate.setHours(countDownDate.getHours() + hours);

// Update the count down every 1 second
    var x = setInterval(function () {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        document.getElementById("timer").innerHTML = hours + "h "
            + minutes + "m " + seconds + "s ";

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("timer").innerHTML = "EXPIRED";
            $('#submit').click();
        }
    }, 1000);
}
