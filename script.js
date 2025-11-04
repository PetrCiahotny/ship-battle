function shot(ev) {
    let ix = ev.target.dataset.field;
    if(ix){
        let shotInp = document.querySelector('#shot-input');
        shotInp.name = 'action';
        shotInp.value = 'shot@' + ix;
        shotInp.form.submit();        
    }
}

function prepareShot(){
    let cells = document.querySelectorAll(".opponentBoard .field");
    cells.forEach(cell => {
        cell.addEventListener("click", (e) => {
            shot(e);
        })
    })
}
