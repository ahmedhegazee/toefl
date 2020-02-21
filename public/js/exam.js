let fillQuestionsArray = [], randomFillQuestions, fillQuestion = 0, fillQuestions;
let findQuestionsArray = [], randomFindQuestions, findQuestion = 0, findQuestions;
let isFindQuestions = false, isReadingSection = false, isListeningSection = false;
let id = '', name = '', counter = null;

// let questionsArray = [], randomQuestions, question = 0, questions;
window.onload = function () {
    sendActiveRequest();
    // loadAudios();
    id=document.getElementById('id').value;
    name=document.getElementById('name').value;
    var isGrammarExamined=document.cookie.indexOf('student-'+id+'-'+name+'-grammar')>-1;
    var isReadingExamined=document.cookie.indexOf('student-'+id+'-'+name+'-reading-vocab')>-1;
    if(isGrammarExamined&&!isReadingExamined){
        showReadingSection();
    }
    else if(isGrammarExamined&&isReadingExamined){
        document.getElementById('grammar-section').classList.replace('d-block','d-none');
        showListeningSection();
    }else{
        var time = document.getElementById('grammar-time').value;
        setTimer(time);
        fillQuestions = document.getElementsByClassName('fl');
        randomFillQuestions = shuffle(fillNumbersArray(fillQuestions));
        findQuestions = document.getElementsByClassName('fn');
        randomFindQuestions = shuffle(fillNumbersArray(findQuestions));
        // questions = document.getElementsByClassName('question');
        // var numbers = fillNumbersArray(questions);
        // randomQuestions = shuffle(numbers);


        // showNextQuestion(randomQuestions,questions);
        showNextQuestion(randomFillQuestions, fillQuestions, isFindQuestions);
    }

};
function loadAudios(){
    var audios=document.getElementsByClassName('audio');
    for(var i=0;i<audios.length;i++){
        audios[i].load();
    }
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
    //Grammar Section
    if (!isReadingSection && !isListeningSection) {
        if (isFindQuestions === true) {
            // hidePrevQuestion(findQuestions);
            showNextQuestion(randomFindQuestions, findQuestions, isFindQuestions);
        } else {
            // hidePrevQuestion(fillQuestions);
            showNextQuestion(randomFillQuestions, fillQuestions, isFindQuestions);
        }
        if (fillQuestion === fillQuestions.length) {
            isFindQuestions = true;
        }

        if (findQuestion === findQuestions.length) {


            //TODO: Add page between grammar and reading
            document.getElementById('submit').classList.replace('d-none','d-block');
            document.getElementById('next').classList.replace('d-block','d-none');
        }
    }
    else if (isReadingSection && !isListeningSection) {
        nextReadingQuestion();
    } else if (isListeningSection && !isReadingSection) {
        nextListeningQuestion();
    }

}

function hideAllQuestions(name) {
    var questions = document.getElementsByClassName(name);
    for (var i = 0; i < questions.length; i++) {
        if (questions[i].classList.contains('d-block'))
            questions[i].classList.replace('d-block', 'd-none');
        if (questions[i].classList.contains('q'))
            questions[i].classList.remove('q');
    }
}

function hide(name) {
    var questions = document.getElementsByClassName(name);
    for (var i = 0; i < questions.length; i++) {
        if (questions[i].classList.contains('d-block'))
            questions[i].classList.replace('d-block', 'd-none');
        if (questions[i].classList.contains('p'))
            questions[i].classList.remove('p');

    }
}

function showQuestion(question) {
    question.classList.replace('d-none', 'd-block');
    question.classList.add('q');
}

function showNextQuestion(randomQuestionsArray, questionsList, mode) {
    hideAllQuestions('fn');
    hideAllQuestions('fl');
    if (mode === true) {
        var nextQuestion = randomQuestionsArray[findQuestion];
        findQuestionsArray.push(nextQuestion);
        showQuestion(questionsList[nextQuestion]);
        findQuestion++;
    } else {
        var nextQuestion = randomQuestionsArray[fillQuestion];
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

    parent.children().remove(parent.children());

    for (var i = 0; i < 4; i++) {
        parent.append(option[randomOptions[i]]);
        parent.children().remove(option[i]);

    }
}

function setTimer(time) {
    var countDownDate = new Date();
    // var time = document.getElementById('time').value;
    var arr = time.split(':');
    var minutes = parseInt(arr[1]);
    countDownDate.setMinutes(countDownDate.getMinutes() + minutes);
    var hours = parseInt(arr[0]);
    countDownDate.setHours(countDownDate.getHours() + hours);

// Update the count down every 1 second
    counter = setInterval(function () {

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
            clearInterval(counter);
            document.getElementById("timer").innerHTML = "EXPIRED";
            $('#submit').click();
        }
    }, 1000);

}

function getQuestions(name) {
    let questions = [];
    var q = document.getElementsByName(name);
    for (var i = 0; i < q.length; i++) {
        questions.push(parseInt(q[i].value));
    }
    return questions;
}

function getAnswers(questions,name) {
    let answers = [];
    for (var i = 0; i < questions.length; i++) {
        var a = document.getElementsByName(name+'[' + questions[i] + ']');
        for (var j = 0; j < 4; j++) {
            if (a[j].checked)
                answers.push(parseInt(a[j].value));
        }
    }
    return answers;
}

function setCookie(cname, cvalue, hours) {
    var d = new Date();
    d.setTime(d.getTime() + (hours  * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function cacheAnswers(answers, id = 0, st_name='',exam='',kind='') {
    var json = JSON.stringify(answers);
    if(kind.length>0)
    setCookie('student-' + id + "-" + st_name + "-reading-"+kind, json, 10);
    else
    setCookie('student-' + id + "-" + st_name + "-"+exam, json, 10);
}
//#region reading section
let vocabQuestionsArray = [], randomVocabQuestions, vocabQuestion = 0, vocabQuestions;
let randomParagraphs, paragraph = 0, paragraphs;
let randomParagraphQuestions, paragraphQuestion = 0, paragraphQuestions;
let isParagraphs = false;

// let questionsArray = [], randomQuestions, question = 0, questions;

function showReadingSection() {
    hideAllQuestions('fn');
    hideAllQuestions('fl');
    isReadingSection = true;
    document.getElementById('grammar-section').classList.add('d-none');
    document.getElementById('reading-section').classList.replace('d-none', 'd-block');
    document.getElementById('next').classList.replace('d-none','d-block');
    document.getElementById('submit').classList.replace('d-block','d-none');
    clearInterval(counter);
    var time = document.getElementById('reading-time').value;
    setTimer(time);

    vocabQuestions = document.getElementsByClassName('vocab');
    randomVocabQuestions = shuffle(fillNumbersArray(vocabQuestions));

    paragraphs = document.getElementsByClassName('paragraph');
    randomParagraphs = shuffle(fillNumbersArray(paragraphs));

    showNextReadingQuestion(randomVocabQuestions, vocabQuestions, isParagraphs);
}


function nextReadingQuestion() {

    if (isParagraphs === true) {
        // hidePrevQuestion(findQuestions);
        showNextReadingQuestion(randomParagraphs, paragraphs, isParagraphs);
    } else {
        // hidePrevQuestion(fillQuestions);
        showNextReadingQuestion(randomVocabQuestions, vocabQuestions, isParagraphs);
    }
    if (vocabQuestion === vocabQuestions.length) {
        isParagraphs = true;
    }

    if (paragraph === paragraphs.length && paragraphQuestion === 0) {


        document.getElementById('submit').classList.replace('d-none','d-block');
        document.getElementById('next').classList.replace('d-block','d-none');

    }
}

function showNextReadingQuestion(randomQuestionsArray, questionsList, mode) {
    hideAllQuestions('vocab');
    hide('paragraph');
    hideAllQuestions('question');
    if (mode === true) {
        if (paragraphQuestion === 0) {
            paragraphs[randomParagraphs[paragraph]].classList.replace('d-none', 'd-block');
            paragraphs[randomParagraphs[paragraph]].classList.add('p');
            paragraphQuestions = $('.p .question');
            var questionNumbers = fillNumbersArray(paragraphQuestions);
            randomParagraphQuestions = shuffle(questionNumbers);
            paragraph++;
        }

        if (paragraphQuestion === paragraphQuestions.length) {
            paragraphQuestion = 0;
        } else {
            paragraphs[randomParagraphs[paragraph - 1]].classList.replace('d-none', 'd-block');
            paragraphQuestions.get(randomParagraphQuestions[paragraphQuestion]).classList.replace("d-none", "d-block");
            paragraphQuestions.get(randomParagraphQuestions[paragraphQuestion]).classList.add('q');
            randomizeOptions();
            paragraphQuestion++;
            if (paragraphQuestion === paragraphQuestions.length) {
                paragraphQuestion = 0;
            }
        }

    } else {
        var nextQuestion = randomQuestionsArray[vocabQuestion];
        vocabQuestionsArray.push(nextQuestion);
        questionsList[nextQuestion].classList.add('q');
        questionsList[nextQuestion].classList.replace('d-none', 'd-block');
        vocabQuestion++;
        randomizeOptions();

    }
}
//endregion
function finishSolving(){

    if(!isReadingSection&&!isListeningSection){
        var questions = getQuestions('questions');
        var answers = getAnswers(questions,'answers');
        cacheAnswers(answers, id, name,'grammar');


        showReadingSection();

    }
   else if(isReadingSection&&!isListeningSection){

        var questions = getQuestions('vocab');
        var answers = getAnswers(questions, 'vocabAnswers');
        cacheAnswers(answers, id, name,'reading','vocab');

        questions = getQuestions('pq');
        answers = getAnswers(questions, 'paragraphAnswers');
        cacheAnswers(answers, id,  name,'reading','paragraph');
        showListeningSection();
    }
   else if(!isReadingSection&&isListeningSection){

        var questions = getQuestions('listeningQuestions');
        var answers = getAnswers(questions,'listeningAnswers');
        cacheAnswers(answers, id, name,'listening');
        document.getElementById('submit').setAttribute('type','submit');
        document.getElementById('submit').click();
    }

}
let  randomShortQuestions, shortConversation = 0, shortConversations;
let  randomLongConversations, longConversation = 0, longConversations;
let  randomLongConversationQuestions, longConversationQuestion = 0, longConversationQuestions;
let isLongConversations =false;
let  randomSpeeches, speech = 0, speeches;
let  randomSpeechQuestions, speechQuestion = 0, speechQuestions;
let isSpeeches =false;
function showListeningSection() {
    hideAllQuestions('vocab');
    hide('paragraph');
    hideAllQuestions('question');
    isReadingSection = false;
    isListeningSection=true;
    document.getElementById('reading-section').classList.add('d-none');

    document.getElementById('listening-section').classList.replace('d-none', 'd-block');
    document.getElementById('next').classList.replace('d-none','d-block');
    document.getElementById('submit').classList.replace('d-block','d-none');

    clearInterval(counter);
    var time = document.getElementById('listening-time').value;
    setTimer(time);
    shortConversations = document.getElementsByClassName('short');
    randomShortQuestions = shuffle(fillNumbersArray(shortConversations));

    longConversations = document.getElementsByClassName('long');
    randomLongConversations = shuffle(fillNumbersArray(longConversations));

    speeches = document.getElementsByClassName('speech');
    randomSpeeches = shuffle(fillNumbersArray(speeches));


    nextListeningQuestion(randomShortQuestions,shortConversations,isLongConversations,isSpeeches);
};
function showListeningQuestion(){
    $('.q ').removeClass('d-none').addClass('d-block');
    $('.animation').addClass('d-none').removeClass('d-block');
    document.getElementById('next').setAttribute('class', 'btn btn-primary d-block');
}
function nextListeningQuestion() {


    if(isLongConversations===true){
        showNextListeningQuestion(randomLongConversations,longConversations,isLongConversations,isSpeeches);
    }
    else{
        showNextListeningQuestion(randomShortQuestions,shortConversations,isLongConversations,isSpeeches);
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



        document.getElementById('submit').setAttribute('class', 'btn btn-primary d-block');
        document.getElementById('next').setAttribute('class', 'btn btn-primary d-none');
    }
}
function showNextListeningQuestion( randomQuestionsArray,questionsList,longMode,speechMode) {
    hideAllQuestions("short");
    hideAllQuestions("question");
    hide('long');
    hide('speech');
    document.getElementById('next').setAttribute('class', 'btn btn-primary d-none');
    $('.q').removeClass('q');
    if(longMode===true){
        if(longConversationQuestion===0){
            longConversations[randomLongConversations[longConversation]].classList.replace('d-none','d-block');
            longConversations[randomLongConversations[longConversation]].classList.add('p');
            longConversationQuestions=$('.p .question');
            randomLongConversationQuestions = shuffle(fillNumbersArray(longConversationQuestions));
            longConversation++;
            $('#listening-section .d-block .audio')[0].play();
            $('.animation').addClass('d-block').removeClass('d-none');

            longConversationQuestions.get(randomLongConversationQuestions[longConversationQuestion]).classList.add('q');
            longConversationQuestion++;
        }
        else{
            longConversations[randomLongConversations[longConversation-1]].classList.replace('d-none','d-block');
            longConversations[randomLongConversations[longConversation-1]].classList.add('p');

            longConversationQuestions.get(randomLongConversationQuestions[longConversationQuestion]).classList.add('q');
            showListeningQuestion();
            longConversationQuestion++;
            if(longConversationQuestion===longConversationQuestions.length){
                longConversationQuestion=0;
            }
        }

    }
    else if(speechMode===true){
        if(speechQuestion===0){
            speeches[randomSpeeches[speech]].classList.replace('d-none','d-block');
            speeches[randomSpeeches[speech]].classList.add('p');
            speechQuestions=$('.p .question');
            randomSpeechQuestions = shuffle(fillNumbersArray(speechQuestions));
            speech++;
            $('#listening-section .d-block .audio')[0].play();
            $('.animation').addClass('d-block').removeClass('d-none');

            speechQuestions.get(randomSpeechQuestions[speechQuestion]).classList.add('q');
            speechQuestion++;
        }
        else{
            speeches[randomSpeeches[speech-1]].classList.replace('d-none','d-block');
            speeches[randomSpeeches[speech-1]].classList.add('p');
            speechQuestions.get(randomSpeechQuestions[speechQuestion]).classList.add('q');
            showListeningQuestion();
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


        $('#listening-section .d-block .audio')[0].play();
        $('.animation').addClass('d-block').removeClass('d-none');

    }
    randomizeOptions();

}





function sendActiveRequest(){
    // const axios = require('axios');

    setInterval(function () {
        axios.get('/active' )
            .then(response => {
                if(response.data.close){
                    let count=0;
                    if(!isReadingSection&&!isListeningSection)
                        count=3;
                    else if(isReadingSection&&!isListeningSection)
                        count=2;
                    else if(!isReadingSection&&isListeningSection)
                        count=1;
                    for(var i=0;i<count;i++){
                        setTimeout(function(){
                            document.getElementById('submit').click();
                        },1000);

                    }
                }
            }).catch(error => console.log(error));

    },180000); //3 Minutes
}






