var serverResponse = document.querySelector('#response');

document.forms.ourform.onsubmit = function(e){
e.preventDefault();

var UserInput = document.forms.ourForm.ourForm_inp.value;


var xhr = new XMLHttpRequest();
xhr.open('POST', 'form.php', true);

xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

xhr.open('POST', 'form.php')
xhr.onreadystatechange = function(){ //обработчик события
    if(xhr.readyState === 4 && xhr.status === 200){
    serverResponse.textContent = xhr.responseText;
    }
};

xhr.send('ourForm_inp' + UserInput);

};