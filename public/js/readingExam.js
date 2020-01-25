let vocabQuestionsArray = [], randomVocabQuestions, vocabQuestion = 0, vocabQuestions;
let  randomParagraphs, paragraph = 0, paragraphs;
let  randomParagraphQuestions, paragraphQuestion = 0, paragraphQuestions;
let isParagraphs =false;
// let questionsArray = [], randomQuestions, question = 0, questions;
window.onload = function () {
    if(document.location.pathname.indexOf('live')==-1) {
        var id = document.getElementById('id').value;
        var name = document.getElementById('name').value;
        if (document.cookie.indexOf('student-' + id + '-' + name + '-reading-vocab') > -1 && document.cookie.indexOf('student-' + id + '-' + name + '-reading-paragraph') > -1) {
            window.location.replace('/exam/listening');
        }
    }
    setTimer();
    vocabQuestions = document.getElementsByClassName('vocab');
    var vocabNumbers = fillNumbersArray(vocabQuestions);
    randomVocabQuestions = shuffle(vocabNumbers);

    paragraphs = document.getElementsByClassName('paragraph');
    var paragraphNumbers = fillNumbersArray(paragraphs);
    randomParagraphs = shuffle(paragraphNumbers);



    // showNextQuestion(randomQuestions,questions);
    showNextQuestion(randomVocabQuestions,vocabQuestions,isParagraphs);
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

    if(isParagraphs===true){
        // hidePrevQuestion(findQuestions);
        showNextQuestion(randomParagraphs,paragraphs,isParagraphs);
    }
    else{
        // hidePrevQuestion(fillQuestions);
        showNextQuestion(randomVocabQuestions,vocabQuestions,isParagraphs);
    }
    if (vocabQuestion === vocabQuestions.length ) {
        isParagraphs=true;
    }

    if(paragraph === paragraphs.length &&paragraphQuestion===0){
        if(document.location.pathname.indexOf('live')==-1) {
            var questions = getQuestions('vocab');
            var answers = getAnswers(questions, 'vocabAnswers');
            var id = document.getElementById('id').value;
            var name = document.getElementById('name').value;
            cacheAnswers(answers, id, 'vocab', name);

            questions = getQuestions('pq');
            answers = getAnswers(questions, 'paragraphAnswers');
            cacheAnswers(answers, id, 'paragraph', name);
        }
        document.getElementById('submit').setAttribute('class', 'btn btn-primary d-block');
        document.getElementById('next').setAttribute('class', 'btn btn-primary d-none');
    }
}
function hideAllQuestions(){
    var vocab=document.getElementsByClassName('vocab'),
    paragraphs=document.getElementsByClassName('paragraph'),
    questions =document.getElementsByClassName('question');
    for (var i=0;i<vocab.length;i++){
        if(vocab[i].classList.contains('d-block'))
        vocab[i].classList.replace('d-block','d-none');
        if(vocab[i].classList.contains('q'))
            vocab[i].classList.remove('q');
    }
    for (var i=0;i<paragraphs.length;i++){
        if(paragraphs[i].classList.contains('d-block'))
        paragraphs[i].classList.replace('d-block','d-none');
    }
    for (var i=0;i<questions.length;i++){
        if(questions[i].classList.contains('d-block'))
            questions[i].classList.replace('d-block','d-none');
        if(questions[i].classList.contains('q'))
            questions[i].classList.remove('q');
    }


}
function showNextQuestion( randomQuestionsArray,questionsList,mode) {
    hideAllQuestions();

    if(mode===true){
        if(paragraphQuestion===0){
            paragraphs[randomParagraphs[paragraph]].classList.replace('d-none','d-block');
            paragraphQuestions=$('.d-block .question');
            var questionNumbers = fillNumbersArray(paragraphQuestions);
            randomParagraphQuestions = shuffle(questionNumbers);
            paragraph++;
        }

        if(paragraphQuestion===paragraphQuestions.length){
            paragraphQuestion=0;
        }else{
            paragraphs[randomParagraphs[paragraph-1]].classList.replace('d-none','d-block');
            paragraphQuestions.get(randomParagraphQuestions[paragraphQuestion]).classList.replace("d-none","d-block");;
            paragraphQuestions.get(randomParagraphQuestions[paragraphQuestion]).classList.add('q');
            randomizeOptions();
            paragraphQuestion++;
            if(paragraphQuestion===paragraphQuestions.length){
                paragraphQuestion=0;
            }
        }

    }
    else{
        var nextQuestion =randomQuestionsArray[vocabQuestion];
        vocabQuestionsArray.push(nextQuestion);
        questionsList[nextQuestion].classList.add('q');
        questionsList[nextQuestion].classList.replace('d-none','d-block');
        vocabQuestion++;
        randomizeOptions();

    }

}



function randomizeOptions() {
    var options = [0, 1, 2, 3];
    var option = $('.q .option'),
        parent = option.parent();
    var randomOptions = shuffle(options);
    for (var i = 0; i < 4; i++) {
        parent.children().remove(parent.children());
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
function getQuestions(name){
    let questions=[];
    var q=document.getElementsByName(name);
    for(var i=0; i<q.length;i++){
        questions.push(parseInt(q[i].value));
    }
    return questions;
}
function getAnswers(questions,name){
    let answers=[];
    for (var i=0;i<questions.length;i++){
        var a=document.getElementsByName(name+'['+questions[i]+']');
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
function cacheAnswers(answers,id=0,name,st_name){
    var json =JSON.stringify(answers);
    setCookie('student-'+id+"-"+st_name+"-reading-"+name,json,7);
}
