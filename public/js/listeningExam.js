let  randomShortQuestions, shortConversation = 0, shortConversations;
let  randomLongConversations, longConversation = 0, longConversations;
let  randomLongConversationQuestions, longConversationQuestion = 0, longConversationQuestions;
let isLongConversations =false;
let  randomSpeeches, speech = 0, speeches;
let  randomSpeechQuestions, speechQuestion = 0, speechQuestions;
let isSpeeches =false;
// let questionsArray = [], randomQuestions, question = 0, questions;
window.onload = function () {
    setTimer();
    shortConversations = document.getElementsByClassName('short');
    var shortNumbers = fillNumbersArray(shortConversations);
    randomShortQuestions = shuffle(shortNumbers);

   longConversations = document.getElementsByClassName('long');
    var longConversationNumbers = fillNumbersArray(longConversations);
    randomLongConversations = shuffle(longConversationNumbers);

    speeches = document.getElementsByClassName('speech');
    var speechNumbers = fillNumbersArray(speeches);
    randomSpeeches = shuffle(speechNumbers);


    showNextQuestion(randomShortQuestions,shortConversations,isLongConversations,isSpeeches);
};
function showQuestion(){
   $('.q ').removeClass('d-none').addClass('d-block');
   $('.animation').addClass('d-none').removeClass('d-block');
   document.getElementById('next').setAttribute('class', 'btn btn-primary d-block');
}
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


   if(isLongConversations===true){
        showNextQuestion(randomLongConversations,longConversations,isLongConversations,isSpeeches);
    }
    else{
        showNextQuestion(randomShortQuestions,shortConversations,isLongConversations,isSpeeches);
    }
    if (shortConversation === shortConversations.length ) {
        isLongConversations=true;
        isSpeeches=false;

    }

    if(longConversation === longConversations.length && longConversationQuestion ===0){
        isSpeeches=true;
        isLongConversations=false;

    }
    if(speech === speeches.length &&speechQuestion===0){
        if(document.location.pathname.indexOf('live')==-1) {
            var questions = getQuestions();
            var answers = getAnswers(questions);
            var id = document.getElementById('id').value;
            var name = document.getElementById('name').value;
            cacheAnswers(answers, id, name);
        }
        document.getElementById('submit').setAttribute('class', 'btn btn-primary d-block');
        document.getElementById('next').setAttribute('class', 'btn btn-primary d-none');
    }
}
function hideAllQuestions(){
    var vocab=document.getElementsByClassName('short'),
    long=document.getElementsByClassName('long'),
    spech=document.getElementsByClassName('speech'),
    questions =document.getElementsByClassName('question');
    for (var i=0;i<vocab.length;i++){
        if(vocab[i].classList.contains('d-block'))
        vocab[i].classList.replace('d-block','d-none');
        if(vocab[i].classList.contains('q'))
            vocab[i].classList.remove('q');
    }
    for (var i=0;i<long.length;i++){
        if(long[i].classList.contains('d-block'))
        long[i].classList.replace('d-block','d-none');
    }
    for (var i=0;i<spech.length;i++){
        if(spech[i].classList.contains('d-block'))
        spech[i].classList.replace('d-block','d-none');
    }
    for (var i=0;i<questions.length;i++){
        if(questions[i].classList.contains('d-block'))
            questions[i].classList.replace('d-block','d-none');
        if(questions[i].classList.contains('q'))
            questions[i].classList.remove('q');
    }


}
function showNextQuestion( randomQuestionsArray,questionsList,longMode,speechMode) {
    hideAllQuestions();
    document.getElementById('next').setAttribute('class', 'btn btn-primary d-none');
    $('.q').removeClass('q');
    if(longMode===true){
        if(longConversationQuestion===0){
            longConversations[randomLongConversations[longConversation]].classList.replace('d-none','d-block');
            longConversationQuestions=$('.d-block .question');
            var questionNumbers = fillNumbersArray(longConversationQuestions);
            randomLongConversationQuestions = shuffle(questionNumbers);
            longConversation++;
            $('.d-block .audio')[0].play();
            $('.animation').addClass('d-block').removeClass('d-none');

            longConversationQuestions.get(randomLongConversationQuestions[longConversationQuestion]).classList.add('q');
            longConversationQuestion++;
        }
        else{
            longConversations[randomLongConversations[longConversation-1]].classList.replace('d-none','d-block');
            longConversationQuestions.get(randomLongConversationQuestions[longConversationQuestion]).classList.add('q');
            showQuestion();
            longConversationQuestion++;
            if(longConversationQuestion===longConversationQuestions.length){
                longConversationQuestion=0;
            }
        }

    }
    else if(speechMode===true){
        if(speechQuestion===0){
            speeches[randomSpeeches[speech]].classList.replace('d-none','d-block');
            speechQuestions=$('.d-block .question');
            var questions = fillNumbersArray(speechQuestions);
            randomSpeechQuestions = shuffle(questions);
            speech++;
            $('.d-block .audio')[0].play();
            $('.animation').addClass('d-block').removeClass('d-none');

            speechQuestions.get(randomSpeechQuestions[speechQuestion]).classList.add('q');
            speechQuestion++;
        }
        else{
            speeches[randomSpeeches[speech-1]].classList.replace('d-none','d-block');
            speechQuestions.get(randomSpeechQuestions[speechQuestion]).classList.add('q');
            showQuestion();
            speechQuestion++;
            if(speechQuestion===speechQuestions.length){
                speechQuestion=0;
            }
        }

    }
    else{
        var nextQuestion =randomQuestionsArray[shortConversation];
         questionsList[nextQuestion].children[2].children[0].classList.add('q');
        questionsList[nextQuestion].classList.replace('d-none','d-block');
        shortConversation++;


            $('.d-block .audio')[0].play();
        $('.animation').addClass('d-block').removeClass('d-none');

    }
    randomizeOptions();

}



function randomizeOptions() {
    var options = [0, 1, 2, 3];
    var option = $('.q .option'),
        parent = option.parent();
    var randomOptions = shuffle(options);
    parent.children().remove(parent.children());
    for (var i = 0; i < 4; i++) {
        var appendedOption = option[randomOptions[i]];
        parent.append(appendedOption);
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
function getQuestions(){
    let questions=[];
    var q=document.getElementsByName('questions');
    for(var i=0; i<q.length;i++){
        questions.push(parseInt(q[i].value));
    }
    return questions;
}
function getAnswers(questions){
    let answers=[];
    for (var i=0;i<questions.length;i++){
        var a=document.getElementsByName('listeningAnswers['+questions[i]+']');
        for(var j=0;j<4;j++){
            if(a[j].checked)
                answers.push(parseInt(a[j].value));
        }
    }
    return answers;
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function cacheAnswers(answers,id=0,name){
    var json =JSON.stringify(answers);
    setCookie('student-'+id+"-"+name+"-listening",json,7);
}
