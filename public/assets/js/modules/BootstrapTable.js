function create(data) {

    const headerValues = ['#', 'Dodavatel', 'Cena (Kč/MWh)', 'Poplatek za OPM (Kč/měsíc)', 'Celkem (Kč)'];

    const elFactory = function (elem) {
        return function () {
            return document.createElement(elem);
        }
    };

    const _cDiv = elFactory('div');
    const _cTh = elFactory('th');
    const _cTr = elFactory('tr');
    const _cTd = elFactory('td');
    const _cTable = elFactory('table');
    const _cTheader = elFactory('thead');
    const _cTbody = elFactory('tbody');


    //root
    const contentElem = _cDiv();
    contentElem.classList.add('calculator-result', 'table-responsive', 'mx-2');
    contentElem.classList.add('m-3');

    //header
    const tableHeader = _cTheader();
    const tableHeaderRow = _cTr();

    headerValues.forEach(elem => {
        let th = _cTh();
        th.setAttribute('scope', 'col');
        th.innerText = elem;
        tableHeaderRow.appendChild(th);
    });

    tableHeader.appendChild(tableHeaderRow);


    //body
    const tableBody = _cTbody();

    if (data.length > 0)
        data.forEach((rowData, i) => {

            let tr = _cTr();

            let th = _cTh();
            th.setAttribute('scope', 'row');
            th.innerText = i+1;

            let col_1 = _cTd();
            let col_2 = _cTd();
            let col_3 = _cTd();
            let col_4 = _cTd();

            col_1.innerText = rowData.supplier;
            col_2.innerText = rowData.price;
            col_3.innerText = rowData.pdt;
            col_4.innerText = rowData.total_cost;

            tr.appendChild(th);
            tr.appendChild(col_1);
            tr.appendChild(col_2);
            tr.appendChild(col_3);
            tr.appendChild(col_4);

            tableBody.appendChild(tr);
        });


    const table = _cTable();
    table.classList.add('table', 'table-hover');

    table.appendChild(tableHeader);
    table.appendChild(tableBody);

    contentElem.appendChild(table);

    return contentElem;
}

export { create }