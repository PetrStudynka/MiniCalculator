const panelElem = document.getElementsByClassName('calculator-info')[0];
const infoPanel = document.getElementsByClassName('calculator-info__text--info')[0];
const alertPanel = document.getElementsByClassName('calculator-info__text--warning')[0];

const blinkAnimationClass = 'alert-active';

function _setInfo(msg,info = true){

    if(typeof msg !== 'string')
        return;

    if(info){
        infoPanel.style.display = 'block';
        infoPanel.innerText  = msg;
        infoPanel.classList.add(blinkAnimationClass)
    } else {
        alertPanel.style.display = 'block';
        alertPanel.innerText  = msg;
        alertPanel.classList.add(blinkAnimationClass)
    }
}

function setAlert (msg) {

    _setInfo(msg,false)
}

function setInfo(msg) {

    _setInfo(msg)
}

function _clearInfo(info = true, alert = true){

    if(info){
        infoPanel.style.display = '';
        infoPanel.innerText  = '';
    }

    if(alert) {
        alertPanel.style.display = '';
        alertPanel.innerText  = '';
    }
}

function clearAll () {

    _clearInfo(true,true)
}

function clearInfo() {

    _clearInfo(true,false)
}

function clearAlert() {

    _clearInfo(false,true)
}

export { setInfo, setAlert, clearInfo,clearAlert, clearAll }