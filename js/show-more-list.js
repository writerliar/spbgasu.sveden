var listOpen = document.getElementsByClassName('show-more');

for (var i in listOpen){
    var link = listOpen[i];
    link.addEventListener('click', function (evt) {
            evt.preventDefault();
        
            var className = this.getAttribute('data-link');
            var list = document.querySelector('.' + className);

        if(!this.classList.contains('show')){

            list.classList.add('show');
            this.innerHTML = 'Свернуть';
            this.classList.add('show');

        } else {

            list.classList.remove('show');
            this.innerHTML = 'Показать еще';
            this.classList.remove('show');

        }
    });
}