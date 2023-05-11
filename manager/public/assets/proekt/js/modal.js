const modalBtn = document.querySelectorAll('[data-modal]');
// const body = document.body;
const bod = document.body;

//выбираем кнопки с классом modal__close - закрыть м.о.
const modalClose = document.querySelectorAll('.modal__close');

//выбираем все  м.о.
const modal = document.querySelectorAll('.modal');

// 2 - пройтись циклом по всем кнопкам и повесить обработчик события - клик
modalBtn.forEach(item => {
    item.addEventListener('click', event =>{
        let $this = event.currentTarget; //в $this сохраняем значение - какое окно хотим открыть
        let modalId = $this.getAttribute('data-modal'); //в  modalId - значение атрибута data-modal т.е id мод.окна которого будем открывать
        let modal = document.getElementById(modalId); //теперь в modal -храниться само модальное окно
        //  в стили мод.окна добавим класс, который будет открывать его
        let modalContent = modal.querySelector('.modal__content');

        modalContent.addEventListener('click', event =>{
            event.stopPropagation();
        });

        modal.classList.add('show'); // это добавляет класс show для визуализации м.о.
        bod.classList.add('no-scroll');// это добавляет класс no-scroll для отмены скрола, когда открыто м.о..

        setTimeout(() => {
            modalContent.style.transform = 'none' ;
            modalContent.style.opacity = '1' ;
        }, 1);

    });
});
//  пройтись циклом по всем кнопкам и повесить обработчик события - клик
modalClose.forEach(item => {
    item.addEventListener('click', event =>{
        let currentModal = event.currentTarget.closest('.modal');
        //ищим ближайшего родителя, для которого будем закрывать м.о.
        // ниже функция закрытия м.о.
        closeModall(currentModal);
    });
});

//  пройтись циклом по всем мод. окнам - и вешаем событие - клик
modal.forEach(item => {
    item.addEventListener('click', event =>{
        let currentModal = event.currentTarget;

        closeModall(currentModal);
    });
});

//  функция закрытия м.о
function closeModall(currentModal) {
    let modalContent = currentModal.querySelector('.modal__content');
    modalContent.removeAttribute('style');

    setTimeout(() => {
        currentModal.classList.remove('show');
        bod.classList.remove('no-scroll');
    }, 200);

}
// 1шаг - надо повесить обработчик события: клик вызова мод.ок
// data-modal="mesto-modal" - дата-атрибут для идентификации мод.окна
// "mesto-modal" - это id и назвние мод.окна, которого будем вызывать

// выбираем все кнопки и пройдем циклом


// 1 - выбираем все кнопки с селектором data-modal --  мод.окна