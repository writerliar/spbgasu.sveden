var buttonsOpen = document.getElementsByClassName('button-table-open');

for (var i in buttonsOpen){
    var button = buttonsOpen[i];
    button.addEventListener('click', function (evt) {
            evt.preventDefault();
        
            var className = this.getAttribute('data-table');
            var table = document.querySelector('.' + className);

        if(!this.classList.contains('button-show')){

            table.classList.add('show');
            this.innerHTML = 'Закрыть таблицу';
            this.classList.add('button-show');

        } else {

            table.classList.remove('show');
            this.innerHTML = 'Открыть таблицу';
            this.classList.remove('button-show');

        }
    });
}