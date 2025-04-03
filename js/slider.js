(function(){
    
    const sliders = [...document.querySelectorAll('.swaps__body')];
    const buttonNext = document.querySelector('#next');
    const buttonBefore = document.querySelector('#before');
    let value;   

    buttonNext.addEventListener('click', ()=>{
        changePosition(1);
    });

    buttonBefore.addEventListener('click', ()=>{
        changePosition(-1);
    });

    const changePosition = (add)=>{
        const currentSwaps = document.querySelector('.swaps__body--show').dataset.id;
        value = Number(currentSwaps);
        value+= add;


        sliders[Number(currentSwaps)-1].classList.remove('swaps__body--show');
        if(value === sliders.length+1 || value === 0){
            value = value === 0 ? sliders.length  : 1;
        }

        sliders[value-1].classList.add('swaps__body--show');

    }

})();