import * as alertPanelController from "./modules/AlertPanelController.js";
import * as BootstrapTable from "./modules/BootstrapTable.js";

let returnBtn = document.getElementsByClassName('btn--back')[0];

if (returnBtn)

    returnBtn.addEventListener('click', function () {
        window.history.back()
    });

(function () {
        if(!'fetch' in window){
            console.error('Fetch API not available');
        }
    }
)();

const calculatorServiceEndpoint = 'api/calculator/compare';


const calcForm = document.getElementById('calculatorForm');
const submitBtn = document.getElementById('submitBtn');
const clearBtn = document.getElementById('clearBtn');

const consumptionName = 'consumption';
const priceName = 'price';
const pdtName = 'pdt';
const commodityName = 'commodity';

const inputFields = {};
inputFields[consumptionName] = document.getElementById('energyConsumption');
inputFields[priceName] = document.getElementById('energyPrice');
inputFields[pdtName] = document.getElementById('pdtCharge');
inputFields[commodityName] = document.getElementById('commoditySelect');

const apiResponseMessages = {

    okCodes:{
        0: 'Nenalezli jsme žádné dodavatele pro Vámi zadanou spotřebu.',
        1: 'Nalezli jsme pro Vás levnějšího dodavatele.',
        2: 'Skvělá zpráva! Váš dodavatel je nejlevnější!',
    },

    errorCodes:{
        401: 'Zadané hodnoty musí být ve formátu čísla s nejvýše 4-ciferným desetinným rozvojem.',
        500: 'Služba nefunguje. Kontaktujte prosím technickou podporu.',
        503: 'Služba je momentálně nedostupná.'
    }
};

//


calcForm.addEventListener('submit', function (e) {

    e.preventDefault();

    const payloadData = getPayloadFromFormFields(inputFields);

    let response = post(payloadData);

    response.then(result => {
        dispatch(result);
    }).catch((e) => {
        console.error(e);
        errorHandler(apiResponseMessages.errorCodes["500"])
    })

});

async function post(payloadData) {

    return new Promise(async (resolve,reject) => {
        let result;
        try {
            result = await window.fetch(calculatorServiceEndpoint, {
                method: 'POST',
                cache: 'no-cache',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payloadData)
            })
        } catch (e){
            console.log('API not responding.');
            errorHandler(apiResponseMessages.errorCodes["503"]);
           return reject();
        }
        return resolve(result.json())
    })

}

const errorHandler = function(msg){

    alertPanelController.clearInfo();
    alertPanelController.setAlert(msg);
};

const dispatch = function(responseData){

    const payload = responseData.data;
    const error = payload.error.code;
    const fieldErrors = payload.error.errors.field; //todo
    const status = payload.status;
    const payloadData = payload.payload;

    //invalid data format
    if(error === 401){
        alertPanelController.setAlert(apiResponseMessages.errorCodes[error]);
        return;
    }

    //return data for table
    if(status === 1 && payloadData.length > 0){
        getResultView(payloadData);

        alertPanelController.clearAlert();

        if(payloadData.length === 1)
            return  alertPanelController.setInfo(apiResponseMessages.okCodes["0"]);

        (payloadData[0].commodity === 'userOffer') ? alertPanelController.setInfo(apiResponseMessages.okCodes["2"]) : alertPanelController.setInfo(apiResponseMessages.okCodes["1"]);
        return;
    }

    errorHandler(apiResponseMessages.errorCodes["503"])

};

function getResultView(data){

    const appContent = document.getElementsByClassName('calculator-content')[0];
    const bootstrapTable = BootstrapTable.create(data);


    if(!appContent || !bootstrapTable)
        return errorHandler(apiResponseMessages.errorCodes[402]);

    appContent.innerHTML = '';
    appContent.appendChild(BootstrapTable.create(data));


    const btn = document.createElement('button');
    btn.setAttribute('type','button');
    btn.setAttribute('id','returnBtn');
    btn.classList.add('btn','btn-light', 'calculator-btn__return');
    btn.innerText = 'Zpět';

    document.getElementsByClassName('calculator')[0].classList.add('calculator-result');

    const header = document.getElementsByClassName('calculator-header')[0];
    header.appendChild(btn);
    header.classList.add('calculator-result');

    btn.addEventListener('click',function () {

        location.reload();
    });


}

clearBtn.addEventListener('click', function () {

    Object.values(inputFields).forEach(elem => {
        elem.value = '';
    });

    alertPanelController.clearAll()
});


const getPayloadFromFormFields = function (formFields) {

    const payload = {};
    for (const field in formFields) {

        if (formFields.hasOwnProperty(field))
            payload[field] = formFields[field].value;

    }
    return payload;
};
