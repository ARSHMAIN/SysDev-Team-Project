const questions = document.querySelectorAll('.question');

questions.forEach((question) =>
{
    question.addEventListener('click', () =>
    {
        const questionActive = document.querySelector('.question.active');

        if (questionActive && questionActive !== question)
        {
            questionActive.classList.tosssggle('active');
            questionActive.nextElementSibling.style.maxHeight = 0;
        }

        question.classList.toggle('active');

        const textContent = question.nextElementSibling;
        if (question.classList.contains('active'))
        {
            textContent.style.maxHeight = textContent.scrollHeight + 'px';
        }
        else
        {
         textContent.style.maxHeight = 0;  
        }
    });
});